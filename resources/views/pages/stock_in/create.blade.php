@extends('layouts.app')

@section('page-header')
<div class="page-header d-flex flex-wrap align-items-start justify-content-between">
    <div>
        <h4 class="page-title mb-0">Tambah Transaksi Masuk</h4>
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
                <a href="{{ route('stock_in.index') }}">Stock IN</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tambah Transaksi</a>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('stock_in.store') }}" method="POST">
                @csrf

                {{-- Pilih produk --}}
                <div class="mb-4">
                    <label class="form-label">
                        Produk <span class="text-danger">*</span>
                    </label>
                    <select name="id_produk" id="id_produk" class="form-control @error('id_produk') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id_produk }}">
                                {{ $product->nama_produk }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Menyimpan harga asli untuk Javascript --}}
                    <input type="hidden" id="harga_beli_value">
                    {{-- Menyimpan nilai fraction untuk Javascript --}}
                    <input type="hidden" id="fraction_value">
                    @error('id_produk')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Informasi produk (diisi otomatis oleh AJAX) --}}
                <div class="card border mb-4">
                    <div class="card-header bg-light">
                        <strong>Informasi Produk</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Harga Beli</label>
                                <div id="harga_beli" class="form-control bg-light text-end fw-bold">
                                    -
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Stok Saat Ini</label>
                                <div id="stok" class="form-control bg-light text-end">
                                    -
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Satuan</label>
                                <div id="satuan" class="form-control bg-light">
                                    -
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Isi per Satuan</label>
                                <div id="fraction" class="form-control bg-light">
                                    -
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Input jumlah penjualan --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">
                                Qty
                            </label>
                            <input type="number" name="qty" id="qty" min="1" placeholder="Masukkan Qty"
                                class="form-control @error('qty') is-invalid @enderror" required>
                            @error('qty')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Subtotal</label>
                            {{-- Dihitung otomatis oleh Javascript --}}
                            <input type="text" id="subtotal" class="form-control bg-warning fw-bold text-end"
                                placeholder="Rp 0" readonly>
                        </div>
                    </div>
                </div>

                {{-- Catatan transaksi --}}
                <div class="mb-4">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>

                    @error('keterangan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Tombol aksi --}}
                <div class="d-flex justify-content-between">
                    <a href="{{ route('stock_in.index') }}" class="btn btn-secondary">
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-primary">
                        SAVE
                    </button>
                </div>
            </form>
        </div>
        {{-- Pesan error dari business rule --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>
            </div>
        @endif
    </div>
@endsection

{{-- Memanggil Javascript khusus modul Sales --}}
@push('scripts')
    <script src="{{ asset('template/assets/js/stockin.js') }}"></script>
@endpush

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
