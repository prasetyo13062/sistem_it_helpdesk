@extends('layouts.app')

@section('title', 'Buat Tiket')

@section('page-title', 'Buat Tiket')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-9">

        <div class="card shadow-sm border-0">

            <div class="card-body p-4">

                <div class="mb-4">

                    <h4 class="fw-bold">
                        Laporkan Masalah IT
                    </h4>

                    <p class="text-muted mb-0">
                        Silakan isi informasi masalah yang ingin dilaporkan.
                    </p>

                </div>


                {{-- Error Validasi --}}

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Terdapat kesalahan:
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    action="{{ route('pegawai.tickets.store') }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf


                    {{-- Judul --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Judul Masalah
                        </label>

                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="{{ old('title') }}"
                            placeholder="Contoh: Komputer tidak bisa menyala"
                            required>

                    </div>


                    {{-- Kategori --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Kategori
                        </label>

                        <select
                            name="category_id"
                            class="form-select"
                            required>

                            <option value="">
                                -- Pilih Kategori --
                            </option>

                            @foreach ($categories as $category)

                                <option
                                    value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Lokasi --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Lokasi
                        </label>

                        <input
                            type="text"
                            name="location"
                            class="form-control"
                            value="{{ old('location') }}"
                            placeholder="Contoh: Ruang Produksi 1">

                        <small class="text-muted">
                            Isi lokasi perangkat atau tempat terjadinya masalah.
                        </small>

                    </div>


                    {{-- Deskripsi --}}

                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Deskripsi Masalah
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="6"
                            placeholder="Jelaskan masalah yang terjadi secara detail..."
                            required>{{ old('description') }}</textarea>

                    </div>


                    {{-- Lampiran --}}

                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Lampiran
                        </label>

                        <input
                            type="file"
                            name="attachments[]"
                            class="form-control"
                            multiple>

                        <small class="text-muted">
                            Maksimal 5 MB per file.
                            Format: JPG, JPEG, PNG, PDF, DOC, DOCX, XLS, XLSX.
                        </small>

                    </div>


                    {{-- Informasi Status --}}

                    <div class="alert alert-warning">

                        <i class="bi bi-info-circle"></i>

                        Setelah tiket dikirim, status awal tiket adalah:

                        <strong>
                            Sedang Diproses
                        </strong>

                    </div>


                    {{-- Button --}}

                    <div class="d-flex justify-content-end gap-2">

                        <a
                            href="{{ route('pegawai.dashboard') }}"
                            class="btn btn-secondary">

                            Batal

                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-send"></i>

                            Kirim Tiket

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection