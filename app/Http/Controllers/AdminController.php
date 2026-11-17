<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Files;

class AdminController extends Controller
{
    // Dashboard: a few counts
    public function dashboard()
    {
        return view('admin.dashboard', [
            'userCount'    => User::count(),
            'pendingUsers' => User::where('status', 'pending')->count(),
            'listingCount' => Listing::count(),
            'openReports'  => Report::where('status', 'open')->count(),
        ]);
    }

    // Users
    public function users()
    {
        $users = User::latest()->get();

        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'status' => 'required|in:active,suspended',
        ]);

        // an admin cannot suspend themselves
        abort_if($user->id === auth()->id(), 403);

        $user->status = $data['status'];
        $user->save();

        return back()->with('success', 'User updated.');
    }

    // Listings
    public function listings()
    {
        $listings = Listing::with(['user', 'category'])->latest()->get();

        return view('admin.listings', compact('listings'));
    }

    public function destroyListing(Listing $listing)
    {
        if ($listing->image) {
            File::delete(public_path('uploads/' . $listing->image));
        }

        $listing->delete();

        return back()->with('success', 'Listing removed.');
    }

    // Reports
    public function reports()
    {
        $reports = Report::with(['reporter', 'reportedUser', 'listing'])->latest()->get();

        return view('admin.reports', compact('reports'));
    }

    public function updateReport(Request $request, Report $report)
    {
        $data = $request->validate([
            'status'     => 'required|in:open,reviewing,resolved,dismissed',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $report->update($data);

        return back()->with('success', 'Report updated.');
    }

    // Categories
    public function categories()
    {
        $categories = Category::withCount('listings')->get();

        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60|unique:categories,name',
        ]);

        Category::create($data);

        return back()->with('success', 'Category added.');
    }

    public function destroyCategory(Category $category)
    {
        // do not delete a category that still has listings
        if ($category->listings()->exists()) {
            return back()->with('error', 'This category still has listings, so it cannot be deleted.');
        }

        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}