@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
            <div>
                <h4 class="page-title mb-0">Edit Menu</h4>
            </div>
            <ul class="breadcrumbs mb-0">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="{{ route('developer.menus.index') }}">Manage Menu</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item active">Edit Menu</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Form Edit Menu</div>
                    </div>
                    <form action="{{ route('developer.menus.update', $menu->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="name">Nama Menu</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $menu->name) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="parent_id">Menu Sidebar</label>
                                <select class="form-control" id="parent_id" name="parent_id">
                                    <option value="" {{ old('parent_id', $menu->parent_id) ? '' : 'selected' }}>Tidak ada (Menu Utama)</option>
                                    @foreach($parentMenus as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">
                                    {{ $menu->parent ? 'Ini adalah Sub-item, berada di bawah menu "' . $menu->parent->name . '".' : 'Ini adalah Nav Item utama.' }}
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="role">Role Target</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="merchant" {{ old('role', $menu->role) == 'merchant' ? 'selected' : '' }}>Merchant</option>
                                    <option value="developer" {{ old('role', $menu->role) == 'developer' ? 'selected' : '' }}>Developer</option>
                                </select>
                            </div>
                            <input type="hidden" name="order" value="{{ old('order', $menu->order) }}">
                            <div class="form-group form-check ms-2 mt-2">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $menu->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Aktif (Tampilkan di Sidebar)</label>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Update</button>
                            <a href="{{ route('developer.menus.index') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
