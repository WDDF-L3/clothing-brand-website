<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'   => Product::count(),
            'active_products'  => Product::where('is_active', true)->count(),
            'total_orders'     => Order::count(),
            'pending_orders'   => Order::where('status', 'pending')->count(),
            'total_revenue'    => Order::whereIn('status', ['processing','shipped','delivered'])->sum('total'),
            'total_categories' => Category::count(),
            'low_stock'        => Product::where('stock', '<=', 5)->where('stock', '>', 0)->count(),
            'out_of_stock'     => Product::where('stock', 0)->count(),
        ];

        $recent_orders   = Order::latest()->take(5)->get();
        $low_stock_items = Product::where('stock', '<=', 5)->orderBy('stock')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_items'));
    }
}
