@extends('layouts.app')

@section('page-header')
    <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
        <h4 class="page-title">
            Product Report
        </h4>
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
                    Report
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                <a href="#">Product Report</a>                    
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    Product Report
                </h4>
                <div>
                    <a href="{{ route('report.product.excel') }}" class="btn btn-success">
                        <i class="fa fa-file-excel"></i>
                        Export Excel
                    </a>
                    <a href="{{ route('report.product.pdf') }}" class="btn btn-danger">
                        <i class="fa fa-file-pdf"></i>
                        Export PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Buy Price</th>
                            <th>Sell Price</th>
                            <th>Stock</th>
                            <th>Min</th>
                            <th>Max</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($products as $index => $product)
                            <tr>
                                <td>
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    {{ $product->nama_produk }}
                                </td>
                                <td>
                                    {{ $product->category->nama_kategori }}
                                </td>
                                <td>
                                    Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ $product->stok }}
                                    {{ $product->satuan }}
                                </td>
                                <td>
                                    {{ $product->min_stok }}
                                </td>
                                <td>
                                    {{ $product->max_stok }}
                                </td>
                                <td>
                                    @if ($product->stok <= $product->min_stok)
                                        <span class="badge badge-danger">
                                            Critical
                                        </span>
                                    @elseif($product->stok >= $product->max_stok)
                                        <span class="badge badge-warning">
                                            Overstock
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            Normal
                                        </span>
                                    @endif
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="9" class="text-center">
                                    Tidak ada data.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
