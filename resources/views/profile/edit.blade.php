@extends('layouts.app')

@section('title', 'Profil')

@section('page-title', 'Profil')

@section('content')

<div class="container-fluid">

    {{-- Alert Success --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- Error --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Terjadi kesalahan:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="row g-4">

        {{-- DATA PROFIL --}}
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center mb-4">

                        <div
                            class="rounded-circle bg-primary text-white
                                   d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">

                            <i class="bi bi-person fs-3"></i>

                        </div>

                        <div class="ms-3">

                            <h4 class="fw-bold mb-1">
                                Profil Pengguna
                            </h4>

                            <p class="text-muted mb-0">
                                Kelola informasi akun Anda.
                            </p>

                        </div>

                    </div>


                    {{-- FORM PROFIL --}}
                    <form
                        action="{{ route('profile.update') }}"
                        method="POST">

                        @csrf
                        @method('PUT')


                        {{-- Nama --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $user->name) }}"
                                required>

                        </div>


                        {{-- Email --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                value="{{ old('email', $user->email) }}"
                                required>

                        </div>


                        {{-- Role --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Role
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ ucfirst($user->role) }}"
                                readonly>

                        </div>


                        {{-- Departemen --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Departemen
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $user->department->name ?? '-' }}"
                                readonly>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-save me-1"></i>

                            Simpan Perubahan

                        </button>

                    </form>

                </div>

            </div>

        </div>


        {{-- PASSWORD --}}
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h4 class="fw-bold mb-1">
                        Keamanan Akun
                    </h4>

                    <p class="text-muted mb-4">
                        Ubah password akun Anda.
                    </p>


                    <form
                        action="{{ route('profile.password') }}"
                        method="POST">

                        @csrf
                        @method('PUT')


                        {{-- Password Lama --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Password Saat Ini
                            </label>

                            <input
                                type="password"
                                name="current_password"
                                class="form-control"
                                required>

                        </div>


                        {{-- Password Baru --}}
                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Password Baru
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                minlength="8"
                                required>

                            <small class="text-muted">
                                Minimal 8 karakter.
                            </small>

                        </div>


                        {{-- Konfirmasi --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Konfirmasi Password Baru
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                required>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-dark">

                            <i class="bi bi-shield-lock me-1"></i>

                            Ubah Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection