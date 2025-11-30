<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ReviewsTable;
use App\Notifications\ReviewCreatedNotification;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // ================================================================
    // FORM CREATE REVIEW
    // ================================================================
    public function create($productId)
    {
        $product = Product::findOrFail($productId);

        return view('customer.reviews.create', compact('product'));
    }

    // ================================================================
    // STORE REVIEW
    // ================================================================
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($productId);

        $review = ReviewsTable::create([
            'user_id'    => Auth::id(),
            'product_id' => $productId,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'status'     => 'pending', // Default status
        ]);

        if ($product->user) {
            $product->user->notify(new ReviewCreatedNotification($review));
        }

        return redirect()->route('reviews.my-reviews')
            ->with('success', 'Thank you for your review! It will be visible after approval.');
    }

    // ================================================================
    // LIST REVIEW SAYA
    // ================================================================
    public function myReviews()
    {
        $reviews = ReviewsTable::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        return view('customer.reviews.my-reviews', compact('reviews'));
    }

    // ================================================================
    // EDIT REVIEW
    // ================================================================
    public function edit($reviewId)
    {
        $review = ReviewsTable::where('user_id', Auth::id())
            ->findOrFail($reviewId);

        return view('customer.reviews.edit', compact('review'));
    }

    // ================================================================
    // UPDATE REVIEW
    // ================================================================
    public function update(Request $request, $reviewId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = ReviewsTable::where('user_id', Auth::id())
            ->findOrFail($reviewId);

        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
            'status'  => 'pending', // Reset status to pending after edit
        ]);

        return redirect()->route('reviews.my-reviews')
            ->with('success', 'Review updated successfully! It will be visible after approval.');
    }

    // ================================================================
    // DELETE REVIEW
    // ================================================================
    public function destroy($reviewId)
    {
        $review = ReviewsTable::where('user_id', Auth::id())
            ->findOrFail($reviewId);

        $review->delete();

        return redirect()->route('reviews.my-reviews')
            ->with('success', 'Review deleted successfully!');
    }
}
