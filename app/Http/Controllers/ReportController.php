<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sales;
use App\Models\StockIn;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Exports\SalesExport;
use App\Exports\StockInExport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\LaravelPdf\Facades\Pdf;


class ReportController extends Controller
{
    /**
     * Menampilkan halaman Product Report.
     */
    public function product(Request $request): View
    {
        $products = Product::orderBy('nama_produk')
            ->get();

        return view(
            'pages.report.product',
            compact('products')
        );
    }

    /**
     * Menampilkan halaman Sales Report.
     */
    public function sales(Request $request): View
    {
        // Default data kosong ketika halaman pertama kali dibuka
        $sales = collect();

        // Preview hanya dijalankan jika periode dipilih
        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {

            $sales = Sales::with([
                'product',
                'user'
            ])
                ->whereBetween('created_at', [
                    $request->tanggal_awal . ' 00:00:00',
                    $request->tanggal_akhir . ' 23:59:59',
                ])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view(
            'pages.report.sales',
            compact('sales')
        );
    }

    /**
     * Export Sales Report ke Excel.
     */
    public function exportSalesExcel(Request $request)
    {
        return Excel::download(
            new SalesExport(
                $request->tanggal_awal,
                $request->tanggal_akhir
            ),
            'Sales_Report_' .
                $request->tanggal_awal .
                '_sd_' .
                $request->tanggal_akhir .
                '.xlsx'
        );
    }

    /**
     * Export Sales Report ke PDF.
     */
    public function exportSalesPdf(Request $request)
    {
        $sales = Sales::with([
            'product',
            'user'
        ])
            ->whereBetween('created_at', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return Pdf::view(
            'pdf.sales',
            [
                'sales' => $sales,
                'tanggalAwal' => $request->tanggal_awal,
                'tanggalAkhir' => $request->tanggal_akhir,
            ]
        )->download(
            'Sales_Report_' .
                $request->tanggal_awal .
                '_sd_' .
                $request->tanggal_akhir .
                '.pdf'
        );
    }

    /**
     * Menampilkan halaman Stock In Report.
     */
    public function stockIn(Request $request): View
    {
        // Default data kosong ketika halaman pertama kali dibuka
        $stockIns = collect();

        // Preview hanya dijalankan jika periode dipilih
        if (
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {

            $stockIns = StockIn::with([
                'product',
                'user'
            ])
                ->whereBetween('created_at', [
                    $request->tanggal_awal . ' 00:00:00',
                    $request->tanggal_akhir . ' 23:59:59',
                ])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view(
            'pages.report.stock_in',
            compact('stockIns')
        );
    }

    /**
     * Export Stock In Report ke PDF.
     */
    public function exportStockInPdf(Request $request)
    {
        $stockIns = StockIn::with([
            'product',
            'user'
        ])
            ->whereBetween('created_at', [
                $request->tanggal_awal . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59',
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return Pdf::view(
            'pdf.stock_in',
            [
                'stockIns'      => $stockIns,
                'tanggalAwal'   => $request->tanggal_awal,
                'tanggalAkhir'  => $request->tanggal_akhir,
            ]
        )->download(
            'Stock_In_Report_' .
                $request->tanggal_awal .
                '_sd_' .
                $request->tanggal_akhir .
                '.pdf'
        );
    }
}
