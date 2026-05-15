@extends('layouts.app')

@section('page-header')
    <div class="page-header d-flex flex-wrap align-items-start justify-content-between">
        <div>
            <h4 class="page-title mb-2">My Profile</h4>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-edit me-1"></i> Edit Profile
            </a>
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
                    <a href="#">Profile</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Profile Information</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('template/assets/img/profile.jpg') }}"
                                     alt="Profile Picture"
                                     class="img-fluid rounded-circle mb-3"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                                <h5>{{ $user->name }}</h5>
                                <p class="text-muted">{{ $user->email }}</p>
                                <span class="badge badge-primary">{{ ucfirst($user->role ?? 'merchant') }}</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td width="30%"><strong>Name</strong></td>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Role</strong></td>
                                            <td>{{ ucfirst($user->role ?? 'merchant') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email Verified</strong></td>
                                            <td>
                                                @if($user->email_verified_at)
                                                    <span class="badge badge-success">Verified</span>
                                                @else
                                                    <span class="badge badge-warning">Not Verified</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Joined</strong></td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection