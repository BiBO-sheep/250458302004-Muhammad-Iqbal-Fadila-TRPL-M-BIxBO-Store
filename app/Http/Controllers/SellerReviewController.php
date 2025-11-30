<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerReviewController extends Controller
{
    // Show all reviews for seller's products
    public function index()
    {
        $reviews = ReviewsTable::whereHas('product', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->with(['product', 'user'])
            ->latest()
            ->paginate(15);

        return view('seller.reviews.index', compact('reviews'));
    }

    // Reply to review
    public function reply(Request $request, $id)
    {
        $request->validate([
            'seller_reply' => 'required|string|max:1000'
        ]);

        $review = ReviewsTable::whereHas('product', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $review->update([
            'seller_reply' => $request->seller_reply,
            'replied_at' => now()
        ]);

        return redirect()->back()->with('success', 'Reply posted successfully!');
    }

    // Delete reply
    public function deleteReply($id)
    {
        $review = ReviewsTable::whereHas('product', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $review->update([
            'seller_reply' => null,
            'replied_at' => null
        ]);

        return redirect()->back()->with('success', 'Reply deleted successfully!');
    }
}
