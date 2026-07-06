@extends('layouts.app')

@section('page-header')
<div class="page-header d-flex flex-wrap align-items-start justify-content-between">
    <div>
        <h4 class="page-title mb-0">TAMBAH PRODUK</h4>
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
                <a href="{{ route('products.index') }}">Products</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tambah Produk</a>
            </li>
        </ul>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('pages.products._form')
            <div class="d-flex justify-content-between mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    BATAL
                </a>
                <button class="btn btn-primary">
                    SIMPAN
                </button>
            </div>
        </form>
    </div>
</div>

@endsection