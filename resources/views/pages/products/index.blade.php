@extends('layouts.app')

@section('page-header')
    <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
        <div>
            <h4 class="page-title mb-2">Merchant Products</h4>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm"><i
                    class="fa fa-plus-circle me-1"></i>Tambah Produk</a>
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
                    <a href="#">Products</a>
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

    @if (request('q') || request('category'))
        <div class="alert alert-info">
            @if (request('q'))
                Menampilkan hasil pencarian: <strong>{{ request('q') }}</strong>
            @endif
            @if (request('category'))
                @php
                    $selectedCategory = $categories->where('id_kategori', request('category'))->first();
                @endphp
                @if ($selectedCategory)
                    @if (request('q'))
                        |
                    @endif
                    Kategori: <strong>{{ $selectedCategory->nama_kategori }}</strong>
                @endif
            @endif
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('products.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="category" class="form-label fw-semibold">Filter Kategori</label>
                    <select name="category" id="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id_kategori }}"
                                {{ request('category') == $category->id_kategori ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="q" class="form-label fw-semibold">Cari Produk</label>
                    <input type="text" name="q" id="q" class="form-control" value="{{ request('q') }}"
                        placeholder="Nama produk atau kategori...">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fa fa-search me-1"></i>Filter
                    </button>
                    @if (request('q') || request('category'))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-times me-1"></i>Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                <td>{{ $product->category->nama_kategori ?? '-' }}</td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>
                                    @if ($product->foto)
                                        <img src="{{ asset('storage/' . $product->foto) }}"
                                            alt="{{ $product->nama_produk }}" width="80" />
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                                        class="d-inline-block" onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
