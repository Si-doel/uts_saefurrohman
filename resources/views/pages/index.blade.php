@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('template/assets/css/dashboard.css') }}">

@section('page-header')
    <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
        <div>
            <h4 class="page-title mb-2">Dashboard</h4>
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
                    <a href="#">Beranda</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    @php
        use App\Models\Product;
        use App\Models\Category;
        use App\Models\User;

        $productCount = Product::count();
        $categoryCount = Category::count();
        $userCount = User::count();
    @endphp

    <!-- Welcome Card -->
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round welcome-card">
                <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                    <div>
                        <h2 class="fw-bold text-white">
                            Have a great day, Wong Cerdas Bro and Sis, {{ auth()->user()->name }}!
                        </h2>
                        <p class="text-white mb-0 welcome-text">
                            Buat kamu yang lagi memperjuangkan mimpi dan rencana, teruslah berjuang dan jangan menyerah.
                        </p>
                    </div>
                    <div class="welcome-icon">
                        <i class="fa fa-shopping-bag"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row row-card-no-pd">
        <!-- Produk -->
        <div class="col-sm-6 col-lg-4">
            <div class="card card-stats card-round dashboard-stat-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Products</h5>
                            <span class="h2 font-weight-bold">
                                {{ $productCount }}
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                                <i class="fa fa-box"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kategori -->
        <div class="col-sm-6 col-lg-4">
            <div class="card card-stats card-round dashboard-stat-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Categories</h5>
                            <span class="h2 font-weight-bold">
                                {{ $categoryCount }}
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                                <i class="fa fa-tags"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Merchant -->
        <div class="col-sm-6 col-lg-4">
            <div class="card card-stats card-round dashboard-stat-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="card-title">Merchant</h5>
                            <span class="h2 font-weight-bold">
                                {{ $userCount }}
                            </span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart + Calendar -->
    <div class="row">
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
