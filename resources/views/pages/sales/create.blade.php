@extends('layouts.app')

@section('page-header')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('sales.store') }}" method="POST">
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
                    <input type="hidden" id="harga_jual_value">

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
                                <label class="fw-bold">Harga Jual</label>
                                <div id="harga_jual" class="form-control bg-light text-end fw-bold">
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
                            <label class="form-label">Qty</label>
                            <input type="number" name="qty" id="qty" min="1" placeholder="Masukkan Qty"
                                value="{{ old('qty') }}" class="form-control @error('qty') is-invalid @enderror"
                                required>

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
                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                        CANCEL
                    </a>
                    <button type="submit" class="btn btn-primary">
                        SAVE
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- Memanggil Javascript khusus modul Sales --}}
@push('scripts')
    <script src="{{ asset('template/assets/js/sales.js') }}"></script>
@endpush

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
