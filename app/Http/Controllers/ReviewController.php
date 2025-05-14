<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        // Get all reviews for the company
        $reviews = auth()->user()->companyProfile->reviews()
            ->with('jobseeker')
            ->latest()
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request, CompanyProfile $companyProfile)
    {
        // Only jobseekers can review
        if (Auth::user()->role !== 'Jobseeker') {
            return redirect()->back()->with('error', 'Only jobseekers can review companies.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500',
        ]);

        // Check if user has already reviewed this company
        $existingReview = Review::where('jobseeker_id', Auth::id())
            ->where('company_profile_id', $companyProfile->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this company.');
        }

        Review::create([
            'jobseeker_id' => Auth::id(),
            'company_profile_id' => $companyProfile->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }

    public function edit(Review $review)
    {
        // Only the jobseeker who created the review can edit it
        if (Auth::id() !== $review->jobseeker_id) {
            return redirect()->back()->with('error', 'You can only edit your own reviews.');
        }

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        // Only the jobseeker who created the review can update it
        if (Auth::id() !== $review->jobseeker_id) {
            return redirect()->back()->with('error', 'You can only update your own reviews.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('company-profiles.show', $review->companyProfile)
            ->with('success', 'Review updated successfully.');
    }

    public function destroy(Review $review)
    {
        // Only the jobseeker who created the review can delete it
        if (Auth::id() !== $review->jobseeker_id) {
            return redirect()->back()->with('error', 'You can only delete your own reviews.');
        }

        $companyProfile = $review->companyProfile;
        $review->delete();

        return redirect()->route('company-profiles.show', $companyProfile)
            ->with('success', 'Review deleted successfully.');
    }
} 