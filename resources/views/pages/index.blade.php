@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('template/assets/css/dashboard.css') }}">

@section('page-header')
    <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
        <div>
            <h4 class="page-title mb-2">DASHBOARD SMART CATALOG</h4>
        </div>
        <div>
            <ul class="breadcrumbs mb-0">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-round welcome-card shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h2 class="fw-bold text-white mb-2">
                            Welcome, {{ auth()->user()->name }}
                        </h2>
                        <p class="text-white mb-0 welcome-text">
                            Selamat datang di Smart Catalog Dashboard.
                            Pantau kondisi inventori, transaksi penjualan,
                            serta rekomendasi sistem secara real-time.
                        </p>
                    </div>
                    <div class="welcome-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Summary -->
    <div class="row g-3 mb-4">
        <!-- Product -->
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="card card-round dashboard-stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Total Product
                            </small>
                            <h2 class="mt-2 mb-0 fw-bold">
                                {{ $totalProduct }}
                            </h2>
                        </div>
                        <div class="icon-shape bg-primary text-white rounded-circle">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category -->
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="card card-round dashboard-stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Categories
                            </small>
                            <h2 class="mt-2 mb-0 fw-bold">
                                {{ $totalCategory }}
                            </h2>
                        </div>
                        <div class="icon-shape bg-success text-white rounded-circle">
                            <i class="fas fa-tags"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales -->
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="card card-round dashboard-stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Total Sales
                            </small>
                            <h2 class="mt-2 mb-0 fw-bold">
                                {{ $totalSales }}
                            </h2>
                        </div>
                        <div class="icon-shape bg-info text-white rounded-circle">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock In -->
        <div class="col-xl-3 col-lg-3 col-md-6">
            <div class="card card-round dashboard-stat-card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">
                                Stock In
                            </small>
                            <h2 class="mt-2 mb-0 fw-bold">
                                {{ $totalStockIn }}
                            </h2>
                        </div>
                        <div class="icon-shape bg-warning text-white rounded-circle">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- TOP SELLING PRODUCT -->
        <div class="col-lg-6 mb-4">
            <div class="card card-round h-100 shadow-sm">
                <div class="card-header">
                    <div class="card-head-row">
                        <div>
                            <h4 class="card-title mb-1">
                                <i class="fas fa-fire text-danger"></i>
                                Top Selling Product
                            </h4>
                            <small class="text-muted">
                                Top 3 produk dengan penjualan tertinggi.
                            </small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($topSellingProducts as $index => $product)
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold">
                                    @switch($index)
                                        @case(0)
                                            <span class="badge badge-warning">TOP 1</span>
                                        @break

                                        @case(1)
                                            <span class="badge badge-secondary">TOP 2</span>
                                        @break

                                        @case(2)
                                            <span class="badge badge-info">TOP 3</span>
                                        @break
                                    @endswitch

                                    {{ $product->product->nama_produk }}
                                </div>
                                <small class="text-muted">
                                    Revenue :
                                    Rp {{ number_format($product->total_sales, 0, ',', '.') }}
                                </small>
                            </div>
                            <div>
                                <span class="badge badge-primary">
                                    {{ number_format($product->total_qty) }}
                                    PCS
                                </span>
                            </div>
                        </div>
                        @unless ($loop->last)
                            <hr>
                        @endunless

                        @empty
                            <div class="text-center py-4">
                                Belum ada transaksi penjualan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- CRITICAL STOCK -->
            <div class="col-lg-6 mb-4">
                <div class="card card-round h-100 shadow-sm">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div>
                                <h4 class="card-title mb-1">
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                    Critical Stock
                                </h4>
                                <small class="text-muted">
                                    Top 3 produk dengan stok kritis.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse($criticalStocks as $product)
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">
                                        {{ $product->nama_produk }}
                                    </div>
                                    <small class="text-muted">
                                        Minimum stock :
                                        {{ $product->min_stok }}
                                        {{ $product->satuan }}
                                    </small>
                                </div>
                                <div>
                                    <span class="badge badge-danger">
                                        {{ $product->stok }}
                                        {{ $product->satuan }}
                                    </span>
                                </div>
                            </div>
                            @unless ($loop->last)
                                <hr>
                            @endunless

                        @empty
                            <div class="text-center py-4 text-success">
                                Semua stok berada di atas batas minimum.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <!-- INCREASE STOCK RECOMMENDATION -->
            <div class="col-lg-6 mb-4">
                <div class="card card-round h-100 shadow-sm">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div>
                                <h4 class="card-title mb-1">
                                    <i class="fas fa-chart-line text-primary"></i>
                                    Increase Stock Recommendation
                                </h4>
                                <small class="text-muted">
                                    Rekomendasi penambahan stok berdasarkan produk dengan penjualan tertinggi.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse($increaseRecommendations as $index => $item)
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold">
                                        <span class="badge badge-primary">
                                            TOP {{ $index + 1 }}
                                        </span>
                                        {{ $item['product'] }}
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        Sold :
                                        {{ number_format($item['sold_qty']) }}
                                        PCS

                                    </small>
                                    <small class="text-success d-block">
                                        Recommendation :
                                        Increase
                                        <strong>{{ $item['recommended_qty'] }} PCS</strong>
                                    </small>
                                </div>
                            </div>
                            @unless ($loop->last)
                                <hr>
                            @endunless

                        @empty
                            <div class="text-center py-4">
                                Belum ada rekomendasi.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- RESTOCK RECOMMENDATION -->
            <div class="col-lg-6 mb-4">
                <div class="card card-round h-100 shadow-sm">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div>
                                <h4 class="card-title mb-1">
                                    <i class="fas fa-box-open text-danger"></i>
                                    Restock Recommendation
                                </h4>
                                <small class="text-muted">
                                    Rekomendasi Stock In berdasarkan produk dengan stok kritis.
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @forelse($restockRecommendations as $item)
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-bold">
                                        {{ $item['product'] }}
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        Current Stock :
                                        {{ $item['current_stock'] }}
                                    </small>
                                    <small class="text-muted d-block">
                                        Minimum Stock :
                                        {{ $item['minimum_stock'] }}
                                    </small>
                                    <small class="text-danger d-block">
                                        Recommendation :
                                        Stock In
                                        <strong>{{ $item['recommended_qty'] }} PCS</strong>
                                    </small>
                                </div>
                            </div>
                            @unless ($loop->last)
                                <hr>
                            @endunless
                        @empty
                            <div class="text-center py-4 text-success">
                                Tidak ada produk yang perlu dilakukan Stock In.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart + Calendar -->
        <div class="row mt-4">
            <!-- Chart -->
            <div class="col-lg-7 col-md-12">
                <div class="card" style="height: 100%;">
                    <div class="card-header">
                        <div class="card-title">
                            Product Category Diagram
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="kategoriChart" height="90" data-labels='@json($categories->pluck('nama_kategori'))'
                            data-values='@json($categories->pluck('products_count'))'>
                        </canvas>
                    </div>
                </div>
            </div>

            <!-- Calendar -->
            <div class="col-lg-5 col-md-12">
                <div class="card card-chart" style="height: 100%;">
                    <div class="card-header">
                        <div class="card-title">
                            Calendar
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart JS -->
        <script src="{{ asset('template/assets/js/dashboard-chart.js') }}"></script>
    @endsection
