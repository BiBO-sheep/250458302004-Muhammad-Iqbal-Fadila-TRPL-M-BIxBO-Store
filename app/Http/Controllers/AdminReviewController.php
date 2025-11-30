<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewsTable;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    // Show all reviews
    public function index(Request $request)
    {
        $query = ReviewsTable::with(['product', 'user']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('product', function ($productQuery) use ($request) {
                        $productQuery->where('name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhere('comment', 'like', '%' . $request->search . '%');
            });
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    // Show review detail
    public function show($id)
    {
        $review = ReviewsTable::with(['product', 'user', 'order'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    // Approve review
    public function approve($id)
    {
        $review = ReviewsTable::findOrFail($id);
        $review->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Review approved successfully!');
    }

    // Reject review
    public function reject($id)
    {
        $review = ReviewsTable::findOrFail($id);
        $review->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Review rejected successfully!');
    }

    // Delete review
    public function destroy($id)
    {
        $review = ReviewsTable::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully!');
    }

    // Bulk actions
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:reviews,id'
        ]);

        switch ($request->action) {
            case 'approve':
                ReviewsTable::whereIn('id', $request->review_ids)->update(['status' => 'approved']);
                $message = 'Reviews approved successfully!';
                break;
            case 'reject':
                ReviewsTable::whereIn('id', $request->review_ids)->update(['status' => 'rejected']);
                $message = 'Reviews rejected successfully!';
                break;
            case 'delete':
                ReviewsTable::whereIn('id', $request->review_ids)->delete();
                $message = 'Reviews deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
