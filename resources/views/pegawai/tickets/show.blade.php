@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('page-title', 'Detail Tiket')

@section('content')

<div class="container-fluid">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Detail Tiket
            </h4>

            <p class="text-muted mb-0">
                Detail laporan masalah dan proses penanganan IT.
            </p>
        </div>

        <a href="{{ route('pegawai.tickets.index') }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

    </div>


    <div class="row g-4">

        {{-- ===================================================== --}}
        {{-- KOLOM KIRI --}}
        {{-- ===================================================== --}}
        <div class="col-lg-8">

            {{-- ================================================= --}}
            {{-- INFORMASI TIKET --}}
            {{-- ================================================= --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-start mb-4">

                        <div>

                            <small class="text-muted">
                                Nomor Tiket
                            </small>

                            <h3 class="fw-bold mb-0">
                                {{ $ticket->ticket_number }}
                            </h3>

                        </div>


                        {{-- STATUS --}}
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


                    {{-- JUDUL --}}
                    <div class="mb-4">

                        <small class="text-muted">
                            Judul Masalah
                        </small>

                        <h5 class="fw-bold mt-1">
                            {{ $ticket->title }}
                        </h5>

                    </div>


                    {{-- INFORMASI --}}
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


                    {{-- DESKRIPSI --}}
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


            {{-- ================================================= --}}
            {{-- TIMELINE --}}
            {{-- ================================================= --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">

                        <i class="bi bi-clock-history"></i>
                        Timeline Tiket

                    </h5>


                    @forelse($ticket->history as $history)

                        <div class="d-flex mb-4">

                            {{-- ICON --}}
                            <div class="me-3 fs-5">

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


                            {{-- DETAIL HISTORY --}}
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

                        <p class="text-muted mb-0">

                            Belum ada riwayat tiket.

                        </p>

                    @endforelse

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- KOMENTAR --}}
            {{-- ================================================= --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">

                        <i class="bi bi-chat-left-text"></i>
                        Komentar

                    </h5>


                    {{-- PESAN SUCCESS --}}
                    @if(session('success'))

                        <div class="alert alert-success">

                            <i class="bi bi-check-circle"></i>

                            {{ session('success') }}

                        </div>

                    @endif


                    {{-- PESAN ERROR --}}
                    @if(session('error'))

                        <div class="alert alert-danger">

                            <i class="bi bi-exclamation-circle"></i>

                            {{ session('error') }}

                        </div>

                    @endif


                    {{-- ERROR VALIDASI --}}
                    @if($errors->any())

                        <div class="alert alert-danger">

                            <strong>Terjadi kesalahan:</strong>

                            <ul class="mb-0 mt-2">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- FORM KOMENTAR PEGAWAI --}}
                    {{-- ================================================= --}}
                    <div class="bg-light rounded p-3 mb-4">

                        <h6 class="fw-bold mb-3">
                            Tambahkan Komentar
                        </h6>


                        <form
                            method="POST"
                            action="{{ route('pegawai.tickets.comment', ['id' => $ticket->id]) }}"
                        >

                            @csrf


                            <div class="mb-3">

                                <label
                                    for="comment"
                                    class="form-label fw-semibold"
                                >
                                    Komentar
                                </label>


                                <textarea
                                    name="comment"
                                    id="comment"
                                    rows="4"
                                    class="form-control"
                                    placeholder="Tulis komentar atau informasi tambahan mengenai tiket ini..."
                                    required
                                >{{ old('comment') }}</textarea>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary"
                            >

                                <i class="bi bi-send"></i>

                                Kirim Komentar

                            </button>

                        </form>

                    </div>


                    {{-- ================================================= --}}
                    {{-- RIWAYAT KOMENTAR --}}
                    {{-- ================================================= --}}
                    <h6 class="fw-bold mb-3">

                        Riwayat Komentar

                    </h6>


                    @forelse($ticket->comments as $comment)

                        <div class="border rounded p-3 mb-3">

                            <div class="d-flex justify-content-between align-items-start">

                                <div class="fw-bold">

                                    <i class="bi bi-person-circle"></i>

                                    {{ $comment->user->name ?? 'User' }}

                                </div>


                                <small class="text-muted">

                                    {{ $comment->created_at->format('d/m/Y H:i') }}

                                </small>

                            </div>


                            <div class="mt-2">

                                {!! nl2br(e($comment->comment)) !!}

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-4">

                            <i class="bi bi-chat-left text-muted fs-2"></i>

                            <p class="text-muted mb-0 mt-2">

                                Belum ada komentar.

                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- KOLOM KANAN --}}
        {{-- ===================================================== --}}
        <div class="col-lg-4">


            {{-- ================================================= --}}
            {{-- STATUS --}}
            {{-- ================================================= --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">

                        <i class="bi bi-info-circle"></i>

                        Status Tiket

                    </h5>


                    @if($ticket->status === 'sedang_diproses')

                        <div class="alert alert-warning mb-0">

                            <strong>
                                🟡 Sedang Diproses
                            </strong>

                            <br>

                            <small>
                                Tiket sudah dikirim dan sedang menunggu
                                diproses oleh tim IT.
                            </small>

                        </div>


                    @elseif($ticket->status === 'diterima')

                        <div class="alert alert-primary mb-0">

                            <strong>
                                🔵 Diterima
                            </strong>

                            <br>

                            <small>
                                Tiket sudah diterima oleh tim IT.
                            </small>

                        </div>


                    @elseif($ticket->status === 'dalam_penanganan')

                        <div class="alert alert-warning mb-0">

                            <strong>
                                🟠 Dalam Penanganan
                            </strong>

                            <br>

                            <small>
                                Tiket sedang ditangani oleh tim IT.
                            </small>

                        </div>


                    @elseif($ticket->status === 'selesai')

                        <div class="alert alert-success mb-0">

                            <strong>
                                🟢 Selesai
                            </strong>

                            <br>

                            <small>
                                Masalah telah selesai ditangani oleh tim IT.
                            </small>

                        </div>

                    @endif

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- TEKNISI --}}
            {{-- ================================================= --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">

                        <i class="bi bi-person-gear"></i>

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


            {{-- ================================================= --}}
            {{-- LAMPIRAN --}}
            {{-- ================================================= --}}
            <div class="card border-0 shadow-sm">

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
                                target="_blank"
                            >

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

        </div>

    </div>

</div>

@endsection