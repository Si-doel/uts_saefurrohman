@extends('layouts.app')

@section('page-header')
    <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
        <div>
            <h4 class="page-title mb-0">Edit Profile</h4>
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
                    <a href="{{ route('profile.show') }}">Profile</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Edit</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-round shadow-sm border-0">
                <div class="card-header d-flex align-items-center justify-content-between bg-white py-3">
                    <div>
                        <h5 class="card-title mb-1">Edit Profile</h5>
                        <p class="text-muted mb-0">Perbarui nama, email, dan foto profil Anda.</p>
                    </div>
                    <div class="avatar avatar-xl">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('template/assets/img/profile.jpg') }}"
                             alt="Avatar"
                             class="rounded-circle shadow" style="width: 60px; height: 60px; object-fit: cover;">
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4 p-3 rounded-3" style="background: #f8f9fb;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon icon-shape bg-primary text-white rounded-circle shadow-sm" style="width: 45px; height: 45px; display:flex; align-items:center; justify-content:center;">
                                <i class="fa fa-user"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Profil Utama</h6>
                                <p class="text-muted mb-0">Perbarui informasi dasar akun Anda di sini.</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="name">Nama Lengkap</label>
                            <input id="name" name="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="avatar">Unggah Foto Profil</label>
                            <input id="avatar" name="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror"
                                   accept="image/*">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Maks 2MB. Format: jpeg, png, jpg, gif.</small>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                            <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-lg">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-round shadow-sm border-0 overflow-hidden mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <div class="card-title mb-1">Preview Profil</div>
                    <p class="text-white-75 mb-0">Foto dan info akun Anda saat ini.</p>
                </div>
                <div class="card-body text-center py-4">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('template/assets/img/profile.jpg') }}"
                         alt="Current Profile Picture"
                         class="rounded-circle shadow-lg mb-3"
                         style="width: 140px; height: 140px; object-fit: cover;">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge bg-success text-uppercase">{{ $user->role }}</span>
                </div>
            </div>

            <div class="card card-round shadow-sm border-0">
                <div class="card-header">
                    <div class="card-title">Ubah Kata Sandi</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="current_password">Password Saat Ini</label>
                            <input id="current_password" name="current_password" type="password"
                                   class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="password">Password Baru</label>
                            <input id="password" name="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" for="password_confirmation">Konfirmasi Password Baru</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                   class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning w-100">Perbarui Kata Sandi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
