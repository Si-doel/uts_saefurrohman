@extends('layouts.export')

@section('page-header')
    <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
        <div>
            <h4 class="page-title mb-2">Export Data</h4>
            <p class="text-muted">Cetak laporan produk ke Excel untuk keperluan arsip dan analisis.</p>
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
                    <a href="#">Export Data</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Export Produk</h5>
                    <p class="card-text">Klik tombol di bawah untuk mengunduh semua data produk dalam format Excel.</p>
                    <a href="{{ route('products.export') }}" class="btn btn-primary">
                        <i class="fas fa-file-excel"></i> Download Excel
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
