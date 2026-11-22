<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = Coupon::latest();

        if ($search) {
            $query->where('code', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
        }

        $coupons = $query->paginate(15)->appends($request->all());

        return view('backend.pages.coupons.index', compact('coupons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code|max:50',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
        ]);

        Coupon::create([
            'code' => strtoupper(trim($request->code)),
            'title' => $request->title,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount ?: 0,
            'max_discount_amount' => $request->max_discount_amount ?: null,
            'usage_limit' => $request->usage_limit ?: null,
            'start_date' => $request->start_date ?: null,
            'end_date' => $request->end_date ?: null,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon code created successfully!');
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|max:50|unique:coupons,code,' . $coupon->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
        ]);

        $coupon->update([
            'code' => strtoupper(trim($request->code)),
            'title' => $request->title,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount ?: 0,
            'max_discount_amount' => $request->max_discount_amount ?: null,
            'usage_limit' => $request->usage_limit ?: null,
            'start_date' => $request->start_date ?: null,
            'end_date' => $request->end_date ?: null,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully!');
    }

    public function toggleStatus($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = !$coupon->status;
        $coupon->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Coupon status updated',
            'new_status' => $coupon->status,
        ]);
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
