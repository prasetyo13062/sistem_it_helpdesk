@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('page-title', 'Detail Tiket')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Detail Tiket
            </h4>

            <p class="text-muted mb-0">
                Detail laporan masalah dan proses penanganan IT.
            </p>
        </div>

        <a
            href="{{ route('it.tickets.index') }}"
            class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

    </div>


    <div class="row g-4">

        {{-- KOLOM UTAMA --}}
        <div class="col-lg-8">

            {{-- INFORMASI TIKET --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start mb-4">

                        <div>

                            <small class="text-muted">
                                Nomor Tiket
                            </small>

                            <h3 class="fw-bold">
                                {{ $ticket->ticket_number }}
                            </h3>

                        </div>


                        {{-- Status --}}
                        <div>

                            @if($ticket->status === 'sedang_diproses')

                                <span class="badge bg-warning text-dark fs-6">
                                    🟡 Sedang Diproses
                                </span>

                            @elseif($ticket->status === 'diterima')

                                <span class="badge bg-primary fs-6">
                                    🔵 Diterima
                                </span>

                            @elseif($ticket->status === 'dalam_penanganan')

                                <span class="badge bg-warning text-dark fs-6">
                                    🟠 Dalam Penanganan
                                </span>

                            @elseif($ticket->status === 'selesai')

                                <span class="badge bg-success fs-6">
                                    🟢 Selesai
                                </span>

                            @endif

                        </div>

                    </div>


                    <hr>


                    {{-- Judul --}}
                    <div class="mb-4">

                        <small class="text-muted">
                            Judul Masalah
                        </small>

                        <h5 class="fw-bold mt-1">
                            {{ $ticket->title }}
                        </h5>

                    </div>


                    {{-- Informasi --}}
                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <small class="text-muted">
                                Kategori
                            </small>

                            <div class="fw-semibold">
                                {{ $ticket->category->name ?? '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <small class="text-muted">
                                Lokasi
                            </small>

                            <div class="fw-semibold">
                                {{ $ticket->location ?? '-' }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <small class="text-muted">
                                Prioritas
                            </small>

                            <div class="fw-semibold">
                                {{ ucfirst($ticket->priority) }}
                            </div>

                        </div>


                        <div class="col-md-6 mb-3">

                            <small class="text-muted">
                                Dibuat
                            </small>

                            <div class="fw-semibold">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </div>

                        </div>

                    </div>


                    <hr>


                    {{-- Deskripsi --}}
                    <div>

                        <small class="text-muted">
                            Deskripsi Masalah
                        </small>

                        <div class="bg-light rounded p-3 mt-2">

                            {!! nl2br(e($ticket->description)) !!}

                        </div>

                    </div>

                </div>

            </div>


            {{-- TIMELINE --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">

                        <i class="bi bi-clock-history"></i>

                        Timeline Tiket

                    </h5>


                    @forelse($ticket->history as $history)

                        <div class="d-flex mb-4">

                            <div class="me-3">

                                @if($history->status === 'sedang_diproses')
                                    🟡
                                @elseif($history->status === 'diterima')
                                    🔵
                                @elseif($history->status === 'dalam_penanganan')
                                    🟠
                                @elseif($history->status === 'selesai')
                                    🟢
                                @endif

                            </div>


                            <div>

                                <div class="fw-bold">

                                    @if($history->status === 'sedang_diproses')
                                        Sedang Diproses
                                    @elseif($history->status === 'diterima')
                                        Diterima
                                    @elseif($history->status === 'dalam_penanganan')
                                        Dalam Penanganan
                                    @elseif($history->status === 'selesai')
                                        Selesai
                                    @else
                                        {{ $history->status }}
                                    @endif

                                </div>


                                <div class="text-muted">

                                    {{ $history->description }}

                                </div>


                                <small class="text-muted">

                                    {{ \Carbon\Carbon::parse($history->created_at)->format('d/m/Y H:i') }}

                                    @if($history->user)
                                        — {{ $history->user->name }}
                                    @endif

                                </small>

                            </div>

                        </div>

                    @empty

                        <p class="text-muted">
                            Belum ada riwayat.
                        </p>

                    @endforelse

                </div>

            </div>


            {{-- ========================================= --}}
            {{-- CATATAN PENANGANAN --}}
            {{-- ========================================= --}}
            @if($ticket->status === 'dalam_penanganan')

                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body p-4">

                        <h5 class="fw-bold mb-3">

                            <i class="bi bi-tools"></i>

                            Catatan Penanganan

                        </h5>

                        <p class="text-muted">
                            Tambahkan informasi mengenai tindakan yang dilakukan
                            untuk menangani masalah tiket ini.
                        </p>


                        {{-- Error Validasi --}}
                        @if($errors->any())

                            <div class="alert alert-danger">

                                <strong>Terjadi kesalahan:</strong>

                                <ul class="mb-0 mt-2">

                                    @foreach($errors->all() as $error)

                                        <li>{{ $error }}</li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        {{-- Form Catatan + Upload --}}
                        <form
                            action="{{ route('it.tickets.handling', $ticket->id) }}"
                            method="POST"
                            enctype="multipart/form-data">

                            @csrf


                            {{-- Catatan --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Catatan Penanganan
                                </label>

                                <textarea
                                    name="note"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Contoh: Melakukan pengecekan kabel jaringan dan mengganti kabel LAN yang bermasalah..."
                                    required>{{ old('note') }}</textarea>

                            </div>


                            {{-- Upload Bukti --}}
                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Bukti Penanganan
                                </label>

                                <input
                                    type="file"
                                    name="attachment"
                                    class="form-control">

                                <small class="text-muted">
                                    Format: JPG, JPEG, PNG, PDF, DOC, DOCX, XLS, XLSX.
                                    Maksimal 5 MB.
                                </small>

                            </div>


                            {{-- Tombol Simpan --}}
                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="bi bi-save"></i>

                                Simpan Catatan

                            </button>

                        </form>

                    </div>

                </div>

            @endif


            {{-- KOMENTAR --}}
            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-3">

                        <i class="bi bi-chat-left-text"></i>

                        Komentar

                    </h5>


                    @forelse($ticket->comments as $comment)
                        {{-- FORM KOMENTAR IT --}}
                        <div class="border-top pt-4 mt-4">

                            <h6 class="fw-bold mb-3">
                                Tambahkan Komentar
                            </h6>

                            <form
                                action="{{ route('it.tickets.comment', $ticket->id) }}"
                                method="POST">

                                @csrf

                                <div class="mb-3">

                                    <textarea
                                        name="comment"
                                        class="form-control"
                                        rows="4"
                                        placeholder="Tulis komentar atau informasi tambahan..."
                                        required>{{ old('comment') }}</textarea>

                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-primary">

                                    <i class="bi bi-send"></i>

                                    Kirim Komentar

                                </button>

                            </form>

                        </div>
                        <div class="border rounded p-3 mb-3">

                            <div class="fw-bold">

                                {{ $comment->user->name ?? 'User' }}

                            </div>

                            <small class="text-muted">

                                {{ $comment->created_at->format('d/m/Y H:i') }}

                            </small>

                            <div class="mt-2">

                                {!! nl2br(e($comment->comment)) !!}

                            </div>

                        </div>

                    @empty

                        <p class="text-muted">
                            Belum ada komentar.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- SIDEBAR --}}
        <div class="col-lg-4">


            {{-- DATA PELAPOR --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Data Pelapor
                    </h5>


                    <div class="mb-3">

                        <small class="text-muted">
                            Nama
                        </small>

                        <div class="fw-semibold">
                            {{ $ticket->user->name ?? '-' }}
                        </div>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted">
                            Email
                        </small>

                        <div class="fw-semibold">
                            {{ $ticket->user->email ?? '-' }}
                        </div>

                    </div>


                    <div>

                        <small class="text-muted">
                            Departemen
                        </small>

                        <div class="fw-semibold">
                            {{ $ticket->user->department->name ?? '-' }}
                        </div>

                    </div>

                </div>

            </div>


            {{-- TEKNISI --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Teknisi
                    </h5>


                    @if($ticket->technician)

                        <div class="fw-semibold">

                            {{ $ticket->technician->name }}

                        </div>

                        <small class="text-muted">

                            {{ $ticket->technician->email }}

                        </small>

                    @else

                        <p class="text-muted mb-0">
                            Belum ada teknisi yang menangani.
                        </p>

                    @endif

                </div>

            </div>


            {{-- LAMPIRAN --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">

                        <i class="bi bi-paperclip"></i>

                        Lampiran

                    </h5>


                    @forelse($ticket->attachments as $attachment)

                        <div class="border rounded p-2 mb-2">

                            <i class="bi bi-file-earmark"></i>

                            <a
                                href="{{ asset('storage/' . $attachment->file) }}"
                                target="_blank">

                                {{ basename($attachment->file) }}

                            </a>

                        </div>

                    @empty

                        <p class="text-muted mb-0">
                            Tidak ada lampiran.
                        </p>

                    @endforelse

                </div>

            </div>


            {{-- AKSI TIKET --}}
            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Proses Tiket
                    </h5>


                    @if(session('success'))

                        <div class="alert alert-success">

                            {{ session('success') }}

                        </div>

                    @endif


                    @if(session('error'))

                        <div class="alert alert-danger">

                            {{ session('error') }}

                        </div>

                    @endif


                    {{-- TERIMA --}}
                    @if($ticket->status === 'sedang_diproses')

                        <form
                            action="{{ route('it.tickets.accept', $ticket->id) }}"
                            method="POST"
                            class="mb-2">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-primary w-100">

                                <i class="bi bi-check-circle"></i>

                                Terima Tiket

                            </button>

                        </form>

                    @endif


                    {{-- MULAI PENANGANAN --}}
                    @if($ticket->status === 'diterima')

                        <form
                            action="{{ route('it.tickets.start', $ticket->id) }}"
                            method="POST"
                            class="mb-2">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-warning w-100">

                                <i class="bi bi-tools"></i>

                                Mulai Penanganan

                            </button>

                        </form>

                    @endif


                    {{-- SELESAIKAN --}}
                    @if($ticket->status === 'dalam_penanganan')

                        <form
                            action="{{ route('it.tickets.complete', $ticket->id) }}"
                            method="POST">

                            @csrf

                            <button
                                type="submit"
                                class="btn btn-success w-100">

                                <i class="bi bi-check-circle"></i>

                                Selesaikan Tiket

                            </button>

                        </form>

                    @endif


                    {{-- SUDAH SELESAI --}}
                    @if($ticket->status === 'selesai')

                        <div class="alert alert-success mb-0">

                            <i class="bi bi-check-circle"></i>

                            Tiket sudah selesai ditangani.

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection