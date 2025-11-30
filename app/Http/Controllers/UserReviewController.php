<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ReviewsTable;
use Illuminate\Support\Facades\Auth;

class UserReviewController extends Controller
{
    // Show form to create review
    public function create($productId)
    {
        $product = Product::findOrFail($productId);

        // Check if user can review
        if (!Auth::user()->canReviewProduct($productId)) {
            return redirect()->back()->with('error', 'You cannot review this product. You must purchase it first or you have already reviewed it.');
        }

        // Get the order
        $order = Auth::user()->orders()
            ->where('status', 'completed')
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->first();

        return view('reviews.create', compact('product', 'order'));
    }

    // Store review
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'order_id' => 'required|exists:orders,id'
        ]);

        // Check if user can review
        if (!Auth::user()->canReviewProduct($productId)) {
            return redirect()->back()->with('error', 'You cannot review this product.');
        }

        // Verify order belongs to user
        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->firstOrFail();

        ReviewsTable::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved' // Auto approve, or 'pending' if you want moderation
        ]);

        return redirect()->route('products.show', $productId)
            ->with('success', 'Thank you for your review!');
    }

    // Show user's reviews
    public function myReviews()
    {
        $reviews = Auth::user()->reviews()
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('reviews.my-reviews', compact('reviews'));
    }

    // Edit review
    public function edit($id)
    {
        $review = ReviewsTable::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('reviews.edit', compact('review'));
    }

    // Update review
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review = ReviewsTable::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->route('reviews.my-reviews')
            ->with('success', 'Review updated successfully!');
    }

    // Delete review
    public function destroy($id)
    {
        $review = ReviewsTable::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $review->delete();

        return redirect()->route('reviews.my-reviews')
            ->with('success', 'Review deleted successfully!');
    }
}
