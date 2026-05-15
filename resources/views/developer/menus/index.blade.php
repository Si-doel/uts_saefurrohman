@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
            <div>
                <h4 class="page-title mb-0">Manage Menu</h4>
            </div>
            <ul class="breadcrumbs mb-0">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Developer</a></li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item active">Manage Menu</li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">Data Menu</div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('developer.menus.index') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari berdasarkan nama menu..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Urutan</th>
                                        <th>Nama Menu</th>
                                        <th>Tipe</th>
                                        <th>Parent</th>
                                        <th>Role</th>
                                        <th>Status (Sidebar)</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($menus as $menu)
                                        <tr>
                                            <td>{{ $menu->order }}</td>
                                            <td>
                                                @if ($menu->parent)
                                                    <span class="text-muted">&nbsp;&nbsp;&nbsp;↳</span> {{ $menu->name }}
                                                @else
                                                    {{ $menu->name }}
                                                @endif
                                            </td>
                                            <td>{{ $menu->parent ? 'Sub-item' : 'Nav Item' }}</td>
                                            <td>{{ $menu->parent ? $menu->parent->name : '-' }}</td>
                                            <td>{{ ucfirst($menu->role) }}</td>
                                            <td>
                                                <form action="{{ route('developer.menus.toggle', $menu->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    @if ($menu->is_active)
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fas fa-eye"></i> Ditampilkan
                                                        </button>
                                                    @else
                                                        <button type="submit" class="btn btn-secondary btn-sm">
                                                            <i class="fas fa-eye-slash"></i> Disembunyikan
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('developer.menus.edit', $menu->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('developer.menus.destroy', $menu->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">Tidak ada data menu.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $menus->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
