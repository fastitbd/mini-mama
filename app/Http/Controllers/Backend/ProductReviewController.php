<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = ProductReview::with('product')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('review_title', 'like', "%{$search}%")
                  ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        $reviews = $query->paginate(15)->appends($request->all());

        $counts = [
            'all' => ProductReview::count(),
            'approved' => ProductReview::where('status', 'approved')->count(),
            'pending' => ProductReview::where('status', 'pending')->count(),
            'rejected' => ProductReview::where('status', 'rejected')->count(),
        ];

        return view('backend.pages.reviews.index', compact('reviews', 'counts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required',
        ]);

        ProductReview::create([
            'product_id' => $request->product_id ?: null,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'rating' => (int)$request->rating,
            'review_title' => $request->review_title,
            'comment' => $request->comment,
            'status' => $request->status ?: 'approved',
            'verified_purchase' => $request->has('verified_purchase') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Customer review added successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $review = ProductReview::findOrFail($id);
        $review->status = $request->status;
        $review->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Review status updated to ' . $review->status,
        ]);
    }

    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Customer review deleted successfully.');
    }
}
