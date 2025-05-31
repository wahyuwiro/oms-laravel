<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role?->name === 'staff') {
            return view('staff.dashboard');
        }

        $filter = $request->get('filter', '30days');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($filter === '7days') {
            $from = Carbon::now()->subDays(7);
        } elseif ($filter === '30days') {
            $from = Carbon::now()->subDays(30);
        } elseif ($filter === 'custom' && $startDate && $endDate) {
            $from = Carbon::parse($startDate);
            $to = Carbon::parse($endDate)->endOfDay();
        } else {
            $from = Carbon::now()->subDays(30);
            $to = Carbon::now()->endOfDay();
        }

        $query = Order::where('created_at', '>=', $from);
        if (isset($to)) {
            $query->where('created_at', '<=', $to);
        }

        $totalOrders = $query->count();
        $totalSales = $query->sum('total_price');

        $activeCustomers = Customer::where('status', 'active')->count();
        $inactiveCustomers = Customer::where('status', 'inactive')->count();

        $orderStatusCounts = $query->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

            $monthlyData = Order::where('created_at', '>=', now()->subYear())
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count, SUM(total_price) as total_sales")
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $monthlyLabels = $monthlyData->keys();
        $monthlyOrderCounts = $monthlyData->pluck('count');
        $monthlySalesTotals = $monthlyData->pluck('total_sales');

        $monthlyOrderCounts = Order::where('created_at', '>=', now()->subYear())
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalSales',
            'activeCustomers',
            'inactiveCustomers',
            'orderStatusCounts',
            'monthlyOrderCounts',
            'monthlySalesTotals',
            'monthlyLabels',
            'filter',
            'startDate',
            'endDate'
        ));

    }
}
