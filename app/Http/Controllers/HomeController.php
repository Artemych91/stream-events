<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Follower;
use App\Models\MerchSale;
use App\Models\Subscriber;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Retrieve data for each type of event
        $followers = Follower::where('user_id', $user->getAuthIdentifier())->latest()->get();
        $subscribers = Subscriber::where('user_id', $user->getAuthIdentifier())->latest()->get();
        $donations = Donation::where('user_id', $user->getAuthIdentifier())->latest()->get();

        $events = $followers->concat($subscribers)->concat($donations)->sortByDesc('created_at');

        // Convert the merged collection to a paginator for the AJAX response
        $currentPage = Paginator::resolveCurrentPage('page');
        $perPage = 100;
        $eventsPaginated = new LengthAwarePaginator(
            $events->forPage($currentPage, $perPage),
            $events->count(),
            $perPage,
            $currentPage
        );

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            return view('events', compact('eventsPaginated'));
        }

        $totalDonations = Donation::where('user_id', $user->getAuthIdentifier())
            ->where('created_at', '>', now()->subDays(90))
            ->sum('amount');

        $totalMerchSales = MerchSale::where('user_id', $user->getAuthIdentifier())
            ->where('created_at', '>', now()->subDays(90))
            ->sum('amount');

        $totalRevenue = $totalDonations + $totalMerchSales;

        $totalFollowersGained = Follower::where('user_id', $user->getAuthIdentifier())
            ->where('created_at', '>', now()->subDays(90))
            ->count();

        $topSellingItems = MerchSale::where('user_id', $user->getAuthIdentifier())
            ->where('created_at', '>', now()->subDays(90))
            ->groupBy('item_name')
            ->selectRaw('item_name, sum(amount) as total_amount')
            ->orderByDesc('total_amount')
            ->take(3)
            ->get();

        return view('home', [
            'totalRevenue' => $totalRevenue,
            'totalFollowersGained' => $totalFollowersGained,
            'topSellingItems' => $topSellingItems,
            'eventsPaginated' => $eventsPaginated,
        ]);
    }
}
