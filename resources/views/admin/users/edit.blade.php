@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-4">
                    <i class="fas fa-user-edit me-2 text-warning"></i>Form Edit User
                </h6>

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Role <span class="text-danger">*</span>
                        </label>
                        <select name="role" class="form-select">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" name="password" class="form-control"
                               placeholder="Kosongkan jika tidak ingin mengganti">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Ulangi password baru">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection