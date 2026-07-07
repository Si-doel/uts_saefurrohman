<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sales;
use App\Models\StockIn;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard.
     */
    public function index(): View
    {
        /* Summary Dashboard */

        $totalCategory = Category::count();

        $totalProduct = Product::count();

        $totalSales = Sales::count();

        $totalStockIn = StockIn::count();

        /* Chart Product Category */

        $categories = Category::withCount('products')
            ->orderBy('nama_kategori')
            ->get();

        /* Produk dengan penjualan tertinggi */

        $topSellingProducts = Sales::select(
            'id_produk',
            DB::raw('SUM(qty) as total_qty'),
            DB::raw('SUM(subtotal) as total_sales')
        )
            ->with('product')
            ->groupBy('id_produk')
            ->orderByDesc('total_qty')
            ->limit(3)
            ->get();

        /* Produk dengan stok kritis */

        $criticalStocks = Product::whereColumn(
            'stok',
            '<=',
            'min_stok'
        )
            ->orderBy('stok')
            ->limit(3)
            ->get();

        /* Recommendation By System */
        $increaseRecommendations = collect();
        foreach ($topSellingProducts as $item) {
            /* Rekomendasi penambahan stok= 20% dari total penjualan */
            $recommendedQty = ceil($item->total_qty * 0.20);
            $increaseRecommendations->push([
                'product' => $item->product->nama_produk,
                'sold_qty' => $item->total_qty,
                'recommended_qty' => $recommendedQty,
                'reason' => 'Highest Sales'
            ]);
        }

        $restockRecommendations = collect();
        foreach ($criticalStocks as $item) {
            /** rekomendasi Stock In sampai mencapai Max Stock */
            $recommendedQty = $item->max_stok - $item->stok;
            $restockRecommendations->push([
                'product' => $item->nama_produk,
                'current_stock' => $item->stok,
                'minimum_stock' => $item->min_stok,
                'recommended_qty' => $recommendedQty,
                'reason' => 'Critical Stock'
            ]);
        }

        /* Return View */
        return view(
            'pages.index',
            compact(
                // Summary
                'totalCategory',
                'totalProduct',
                'totalSales',
                'totalStockIn',
                // Chart
                'categories',
                // Insight
                'topSellingProducts',
                'criticalStocks',
                // Recommendation
                'increaseRecommendations',
                'restockRecommendations'
            )
        );
    }
}
