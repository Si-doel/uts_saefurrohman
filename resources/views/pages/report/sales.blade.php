@extends('layouts.app')

@section('page-header')
    <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
        <h4 class="fw-bold mb-3">
            Sales Report
        </h4>
        <ul class="breadcrumbs mb-3">
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
                <a href="#">Sales Report</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    {{-- Filter Report --}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">
                Filter Laporan Penjualan
            </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('report.sales') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>
                                Tanggal Awal
                            </label>
                            <input type="date" name="tanggal_awal" class="form-control"
                                value="{{ request('tanggal_awal') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>
                                Tanggal Akhir
                            </label>
                            <input type="date" name="tanggal_akhir" class="form-control"
                                value="{{ request('tanggal_akhir') }}">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Preview
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- Hasil Report --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title mb-0">
                Hasil Sales Report
            </h4>
            <div>

                @if ($sales->count())
                    <a href="{{ route('report.sales.excel', request()->query()) }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i>
                        Export Excel
                    </a>
                @else
                    <button class="btn btn-success" disabled>
                        <i class="fas fa-file-excel"></i>
                        Export Excel
                    </button>
                @endif

                @if ($sales->count())
                    <a href="{{ route('report.sales.pdf', request()->query()) }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i>
                        Export PDF
                    </a>
                @else
                    <button class="btn btn-danger" disabled>
                        <i class="fas fa-file-pdf"></i>
                        Export PDF
                    </button>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">
                                No
                            </th>
                            <th>
                                Tanggal
                            </th>
                            <th>
                                Produk
                            </th>
                            <th class="text-center">
                                Qty
                            </th>
                            <th class="text-end">
                                Harga
                            </th>
                            <th class="text-end">
                                Subtotal
                            </th>
                            <th>
                                User
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($sales as $index => $sale)
                            <tr>
                                <td class="text-center">
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    {{ $sale->created_at->format('d-m-Y H:i') }}
                                </td>
                                <td>
                                    {{ $sale->product->nama_produk }}
                                </td>
                                <td class="text-center">
                                    {{ number_format($sale->qty) }}
                                    {{ $sale->satuan }}
                                </td>
                                <td class="text-end">
                                    Rp {{ number_format($sale->harga, 0, ',', '.') }}
                                </td>
                                <td class="text-end fw-bold">
                                    Rp {{ number_format($sale->subtotal, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ $sale->user->name }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    Silakan pilih periode kemudian klik
                                    <strong>Preview</strong>.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
