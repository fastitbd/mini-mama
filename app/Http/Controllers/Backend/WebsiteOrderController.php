<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\PurchaseItem;
use App\Models\WebsiteOrder;
use App\Models\WebsiteOrderItem;
use App\Services\CourierFraudCheckerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebsiteOrderController extends Controller
{
    protected $fraudChecker;

    public function __construct(CourierFraudCheckerService $fraudChecker)
    {
        $this->fraudChecker = $fraudChecker;
    }

    /**
     * Display a listing of the website orders.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'processing');
        $search = $request->get('search');
        $courierFilter = $request->get('courier_service');

        // Status counts for top carousel pills
        $counts = [
            'processing' => WebsiteOrder::where('status', 'processing')->count(),
            'good_no_response' => WebsiteOrder::where('status', 'good_no_response')->count(),
            'no_response' => WebsiteOrder::where('status', 'no_response')->count(),
            'advance_payment' => WebsiteOrder::where('status', 'advance_payment')->count(),
            'on_hold' => WebsiteOrder::where('status', 'on_hold')->count(),
            'approved' => WebsiteOrder::where('status', 'approved')->count(),
            'delivered' => WebsiteOrder::where('status', 'delivered')->count(),
            'cancelled' => WebsiteOrder::where('status', 'cancelled')->count(),
            'all' => WebsiteOrder::count(),
        ];

        $query = WebsiteOrder::with(['items.product.unit', 'items.variation', 'invoice'])
            ->orderBy('created_at', 'desc');

        // Filter by Status (unless 'all')
        if (!empty($status) && $status !== 'all') {
            $query->where('status', $status);
        }

        // Search query
        if (!empty($search)) {
            $searchVal = trim($search);
            $query->where(function ($q) use ($searchVal) {
                $q->where('order_no', 'like', "%{$searchVal}%")
                  ->orWhere('customer_name', 'like', "%{$searchVal}%")
                  ->orWhere('customer_phone', 'like', "%{$searchVal}%")
                  ->orWhere('customer_address', 'like', "%{$searchVal}%")
                  ->orWhereHas('items', function ($itemQ) use ($searchVal) {
                      $itemQ->where('product_name', 'like', "%{$searchVal}%")
                            ->orWhere('product_code', 'like', "%{$searchVal}%");
                  });
            });
        }

        if (!empty($courierFilter)) {
            $query->where('courier_service', $courierFilter);
        }

        $orders = $query->paginate(20)->appends($request->all());

        // Attach courier fraud check stats for each order's customer phone
        $orders->getCollection()->transform(function ($order) {
            try {
                $order->fraud_stats = $this->fraudChecker->checkFraud($order->customer_phone);
            } catch (\Exception $e) {
                $order->fraud_stats = [
                    'overall_success_rate' => 0,
                    'total_parcels' => 0,
                    'total_delivered' => 0,
                    'total_cancelled' => 0,
                    'risk_level' => 'new_customer',
                    'risk_label' => 'New Customer',
                    'badge_class' => 'secondary',
                ];
            }

            // Also check stock availability for each item in the order
            $canApprove = true;
            $stockDetails = [];
            foreach ($order->items as $item) {
                $prod = $item->product;
                if ($prod && $prod->is_service == 0) {
                    $stockQ = PurchaseItem::where('product_id', $item->product_id)
                        ->where('stock_qty', '>', 0);
                    if ($item->product_variation_id) {
                        $stockQ->where('product_variation_id', $item->product_variation_id);
                    }
                    $available = (float) $stockQ->sum('stock_qty');
                    $required = (float) $item->quantity;
                    $itemInStock = $available >= $required;
                    if (!$itemInStock) {
                        $canApprove = false;
                    }
                    $stockDetails[] = [
                        'item_id' => $item->id,
                        'product_name' => $item->product_name,
                        'available' => $available,
                        'required' => $required,
                        'in_stock' => $itemInStock,
                    ];
                } else {
                    $stockDetails[] = [
                        'item_id' => $item->id,
                        'product_name' => $item->product_name,
                        'available' => 9999,
                        'required' => (float) $item->quantity,
                        'in_stock' => true,
                    ];
                }
            }
            $order->can_approve = $canApprove;
            $order->stock_details = $stockDetails;

            return $order;
        });

        return view('backend.pages.website_orders.index', compact('orders', 'counts', 'status', 'search'));
    }

    /**
     * Check real-time stock for an order's items.
     */
    public function checkStock($id)
    {
        $order = WebsiteOrder::with('items.product')->findOrFail($id);
        $itemsStock = [];
        $allInStock = true;

        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product && $product->is_service == 0) {
                $stockQ = PurchaseItem::where('product_id', $item->product_id)
                    ->where('stock_qty', '>', 0);
                if ($item->product_variation_id) {
                    $stockQ->where('product_variation_id', $item->product_variation_id);
                }
                $available = (float) $stockQ->sum('stock_qty');
                $required = (float) $item->quantity;
                $inStock = $available >= $required;
                if (!$inStock) {
                    $allInStock = false;
                }
                $itemsStock[] = [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'required' => $required,
                    'available' => $available,
                    'in_stock' => $inStock,
                ];
            } else {
                $itemsStock[] = [
                    'product_id' => $item->product_id,
                    'product_name' => $item->product_name,
                    'required' => (float) $item->quantity,
                    'available' => 9999,
                    'in_stock' => true,
                ];
            }
        }

        return response()->json([
            'success' => true,
            'can_approve' => $allInStock,
            'items' => $itemsStock,
        ]);
    }

    /**
     * Update the status of a Website Order.
     * If approved, checks stock first, then deducts via FIFO and creates an Invoice in Online Sale List with status 'processing'.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = WebsiteOrder::with(['items.product', 'items.variation'])->findOrFail($id);
        $newStatus = strtolower(trim($request->status));
        $userBranchId = auth()->user()->branch_id ?? 1;

        // Prevent changing status if order is already approved
        if ($order->status === 'approved') {
            $msg = 'Approved অর্ডার অনুমোদিত হয়ে গেছে! অনুমোদনের পর এর স্ট্যাটাস আর পরিবর্তন করা যাবে না।';
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 422);
            }
            return redirect()->back()->with('error', $msg);
        }

        // If transitioning to 'approved'
        if ($newStatus === 'approved') {
            // 1. Stock check: Ensure every physical product has sufficient stock
            $insufficientItems = [];
            foreach ($order->items as $item) {
                $prod = $item->product;
                if ($prod && $prod->is_service == 0) {
                    $stockQuery = PurchaseItem::where('product_id', $item->product_id)
                        ->where('stock_qty', '>', 0);
                    if ($item->product_variation_id) {
                        $stockQuery->where('product_variation_id', $item->product_variation_id);
                    }
                    $available = (float) $stockQuery->sum('stock_qty');
                    $required = (float) $item->quantity;

                    if ($available < $required) {
                        $insufficientItems[] = "{$item->product_name} (প্রয়োজন: {$required}, মজুদ: {$available})";
                    }
                }
            }

            if (!empty($insufficientItems)) {
                $msg = "স্টক পর্যাপ্ত নেই! নিম্নের পণ্যগুলো প্রথমে পারচেজ (Purchase) করুন:\n- " . implode("\n- ", $insufficientItems);
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $msg,
                        'insufficient_items' => $insufficientItems,
                    ], 422);
                }
                return redirect()->back()->with('error', $msg);
            }

            // 2. Perform DB Transaction: Deduct FIFO stock, create/find Customer, create Invoice & InvoiceItems
            try {
                DB::transaction(function () use ($order, $userBranchId) {
                    // Find or create customer
                    $cleanPhone = preg_replace('/[^\d]/', '', $order->customer_phone);
                    if (strlen($cleanPhone) > 11) {
                        $cleanPhone = substr($cleanPhone, -11);
                    }

                    $customer = Customer::where('phone', $order->customer_phone)
                        ->orWhere('phone', $cleanPhone)
                        ->first();

                    if (!$customer) {
                        $customer = Customer::create([
                            'name' => $order->customer_name,
                            'phone' => $order->customer_phone,
                            'address' => $order->customer_address,
                            'branch_id' => $userBranchId,
                            'status' => 1,
                        ]);
                    }

                    // Generate Invoice Number
                    $last_invoice = Invoice::orderBy('id', 'desc')->first();
                    $nextNumber = 1;
                    if ($last_invoice) {
                        $digits = preg_replace('/\D/', '', $last_invoice->invoice_no);
                        $nextNumber = ((int) $digits) + 1;
                    }
                    $invoice_no = "INV-" . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);
                    while (Invoice::where('invoice_no', $invoice_no)->exists()) {
                        $nextNumber++;
                        $invoice_no = "INV-" . str_pad($nextNumber, 7, '0', STR_PAD_LEFT);
                    }

                    // Create Invoice in Online Sale List with status 'processing'
                    $invoice = new Invoice();
                    $invoice->date = Carbon::now()->toDateString();
                    $invoice->unique_id = uniqid();
                    $invoice->invoice_no = $invoice_no;
                    $invoice->customer_id = $customer->id;
                    $invoice->branch_id = $userBranchId;
                    $invoice->sale_type = 'Online';
                    $invoice->order_status = 'processing';
                    $invoice->courier_type = $order->courier_service ?? 'Steadfast Courier';
                    $invoice->total_amount = $order->total_amount;
                    $invoice->delivery_charge = $order->shipping_fee ?? 0;
                    $invoice->discount = $order->discount ?? 0;
                    $invoice->discount_amount = $order->discount ?? 0;
                    $invoice->total_paid = 0;
                    $invoice->total_due = $order->total_amount;
                    $invoice->note = $order->note;
                    $invoice->source_link = $order->order_no;
                    $invoice->status = 1;
                    $invoice->created_by = auth()->id() ?? 1;
                    $invoice->save();

                    // Create InvoiceItems and deduct FIFO stock
                    foreach ($order->items as $item) {
                        $invoice_item = new InvoiceItem();
                        $invoice_item->invoice_id = $invoice->id;
                        $invoice_item->product_id = $item->product_id;
                        $invoice_item->product_variation_id = $item->product_variation_id;
                        $invoice_item->branch_id = $userBranchId;
                        $invoice_item->rate = $item->unit_price;
                        $invoice_item->main_qty = $item->quantity;
                        $invoice_item->actual_main = $item->quantity;
                        $invoice_item->subtotal = $item->subtotal;
                        $invoice_item->actual_total = $item->subtotal;
                        $invoice_item->inv_subtotal = $item->subtotal;

                        $prod = $item->product;
                        if ($prod && $prod->is_service == 0) {
                            $purSubtotal = calculateUnitPriceUsingFIFO(
                                $item->product_id,
                                $item->quantity,
                                $item->product_variation_id,
                                $userBranchId
                            );
                            $invoice_item->pur_subtotal = $purSubtotal;
                        } else {
                            $invoice_item->pur_subtotal = 0;
                        }
                        $invoice_item->save();
                    }

                    // Mark order approved and link invoice
                    $order->update([
                        'status' => 'approved',
                        'invoice_id' => $invoice->id,
                    ]);
                });

                $successMsg = "অর্ডার {$order->order_no} সফলভাবে অনুমোদিত হয়েছে এবং অনলাইন সেল লিস্টে (Processing) যুক্ত করা হয়েছে।";
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => $successMsg,
                        'status' => 'approved',
                    ]);
                }
                return redirect()->back()->with('success', $successMsg);

            } catch (\Exception $e) {
                Log::error("Error approving website order #{$order->id}: " . $e->getMessage());
                $errMsg = "অনুমোদন ব্যর্থ হয়েছে: " . $e->getMessage();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $errMsg], 500);
                }
                return redirect()->back()->with('error', $errMsg);
            }
        }

        // Other status changes (processing, good_no_response, no_response, advance_payment, on_hold, delivered, cancelled)
        $order->update(['status' => $newStatus]);

        $statusLabels = [
            'processing' => 'Processing',
            'good_no_response' => 'Good But No Response',
            'no_response' => 'No Response',
            'advance_payment' => 'Advance Payment',
            'on_hold' => 'On Hold',
            'approved' => 'Approved',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ];

        $label = $statusLabels[$newStatus] ?? ucfirst($newStatus);
        $msg = "অর্ডারের স্ট্যাটাস '{$label}' এ পরিবর্তন করা হয়েছে।";

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'status' => $newStatus,
            ]);
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Update order note.
     */
    public function updateNote(Request $request, $id)
    {
        $order = WebsiteOrder::findOrFail($id);
        $order->update([
            'note' => $request->input('note'),
            'note_updated_at' => Carbon::now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'নোট সফলভাবে আপডেট করা হয়েছে।',
                'note' => $order->note,
                'updated_time' => Carbon::now()->diffForHumans(),
            ]);
        }

        return redirect()->back()->with('success', 'নোট আপডেট করা হয়েছে।');
    }

    /**
     * Bulk update status or perform bulk actions.
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $orderIds = $request->input('order_ids', []);

        if (empty($orderIds) || !is_array($orderIds)) {
            return response()->json(['success' => false, 'message' => 'কোনো অর্ডার সিলেক্ট করা হয়নি!'], 400);
        }

        $orders = WebsiteOrder::whereIn('id', $orderIds)->get();
        $approvedCount = 0;
        $failedCount = 0;
        $errorMessages = [];

        foreach ($orders as $order) {
            if ($action === 'approve') {
                $subRequest = new Request(['status' => 'approved']);
                $res = $this->updateStatus($subRequest, $order->id);
                $resData = json_decode($res->getContent(), true);
                if (!empty($resData['success'])) {
                    $approvedCount++;
                } else {
                    $failedCount++;
                    $errorMessages[] = "#{$order->order_no}: " . ($resData['message'] ?? 'Failed');
                }
            } elseif (in_array($action, ['processing', 'good_no_response', 'no_response', 'advance_payment', 'on_hold', 'delivered', 'cancelled'])) {
                if ($order->status === 'approved') {
                    $failedCount++;
                    $errorMessages[] = "#{$order->order_no}: Approved অর্ডারের স্ট্যাটাস পরিবর্তন করা যাবে না।";
                    continue;
                }
                $order->update(['status' => $action]);
                $approvedCount++;
            } elseif ($action === 'delete') {
                $order->delete();
                $approvedCount++;
            }
        }

        $msg = "{$approvedCount} টি অর্ডার সফলভাবে আপডেট হয়েছে।";
        if ($failedCount > 0) {
            $msg .= " ({$failedCount} টি অর্ডারে স্টক ঘাটতি বা সমস্যা ছিল)";
        }

        return response()->json([
            'success' => true,
            'message' => $msg,
            'errors' => $errorMessages,
        ]);
    }

    /**
     * Dispatch selected orders directly to Courier API (e.g. Steadfast).
     */
    public function dispatchCourier(Request $request)
    {
        $orderIds = $request->input('order_ids', []);
        $courierService = $request->input('courier_service', 'Steadfast Courier');
        $sendToCourierApi = $request->boolean('send_to_courier_api', false);

        if (empty($orderIds)) {
            return response()->json(['success' => false, 'message' => 'কোনো অর্ডার সিলেক্ট করা হয়নি!'], 400);
        }

        // First approve them if they are still processing
        $approved = 0;
        $errors = [];

        foreach ($orderIds as $oid) {
            $order = WebsiteOrder::find($oid);
            if (!$order) continue;

            if ($order->status !== 'approved') {
                $subRequest = new Request(['status' => 'approved']);
                $res = $this->updateStatus($subRequest, $order->id);
                $resData = json_decode($res->getContent(), true);
                if (empty($resData['success'])) {
                    $errors[] = "#{$order->order_no}: " . ($resData['message'] ?? 'Stock insufficient');
                    continue;
                }
            }
            $approved++;
        }

        $msg = "{$approved} টি অর্ডার সফলভাবে কুরিয়ার প্রসেসিংয়ে পাঠানো হয়েছে।";
        if (!empty($errors)) {
            $msg .= " (" . count($errors) . " টি অর্ডারে সমস্যা পাওয়া গেছে)";
        }

        return response()->json([
            'success' => true,
            'message' => $msg,
            'errors' => $errors,
        ]);
    }

    /**
     * E-Commerce Website Sales & Order Reports
     */
    public function report(Request $request)
    {
        $range = $request->get('range', '30_days');

        $query = WebsiteOrder::query();

        if ($range === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($range === '7_days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($range === '30_days') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        } elseif ($range === 'this_month') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        }

        $allOrders = $query->with('items')->get();

        $totalOrders = $allOrders->count();
        $totalRevenue = (float)$allOrders->sum('total_amount');
        
        $deliveredOrders = $allOrders->whereIn('status', ['delivered', 'completed', 'approved']);
        $deliveredCount = $deliveredOrders->count();
        $deliveredRevenue = (float)$deliveredOrders->sum('total_amount');

        $processingCount = $allOrders->whereIn('status', ['processing', 'pending'])->count();
        $cancelledCount = $allOrders->whereIn('status', ['cancelled', 'returned'])->count();

        // Daily Trend (Last 14 days)
        $dailyTrend = WebsiteOrder::where('created_at', '>=', Carbon::now()->subDays(14))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Top Selling Products
        $topProducts = WebsiteOrderItem::selectRaw('product_name, product_code, SUM(quantity) as total_qty, SUM(subtotal) as total_amount')
            ->groupBy('product_name', 'product_code')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();

        // Status Breakdown
        $statusBreakdown = WebsiteOrder::selectRaw('status, COUNT(*) as count, SUM(total_amount) as total')
            ->groupBy('status')
            ->get();

        // Courier Breakdown
        $courierBreakdown = WebsiteOrder::selectRaw('courier_service, COUNT(*) as count')
            ->groupBy('courier_service')
            ->get();

        return view('backend.pages.website_orders.report', compact(
            'range',
            'totalOrders',
            'totalRevenue',
            'deliveredCount',
            'deliveredRevenue',
            'processingCount',
            'cancelledCount',
            'dailyTrend',
            'topProducts',
            'statusBreakdown',
            'courierBreakdown'
        ));
    }
}
