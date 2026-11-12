@extends('layouts.app')

@section('title', 'Tiket Masuk')

@section('page-title', 'Tiket Masuk')

@section('content')
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        <i class="bi bi-check-circle"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif


@if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show">

        <i class="bi bi-exclamation-triangle"></i>

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

@endif

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                Tiket Masuk
            </h4>

            <p class="text-muted mb-0">
                Daftar seluruh laporan masalah dari pegawai.
            </p>

        </div>

    </div>


    {{-- Tabel --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            @if($tickets->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>No. Tiket</th>

                                <th>Pelapor</th>

                                <th>Judul</th>

                                <th>Kategori</th>

                                <th>Lokasi</th>

                                <th>Status</th>

                                <th>Tanggal</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($tickets as $ticket)

                                <tr>

                                    {{-- Nomor --}}
                                    <td>

                                        <strong>
                                            {{ $ticket->ticket_number }}
                                        </strong>

                                    </td>


                                    {{-- Pelapor --}}
                                    <td>

                                        {{ $ticket->user->name ?? '-' }}

                                    </td>


                                    {{-- Judul --}}
                                    <td>

                                        {{ $ticket->title }}

                                    </td>


                                    {{-- Kategori --}}
                                    <td>

                                        {{ $ticket->category->name ?? '-' }}

                                    </td>


                                    {{-- Lokasi --}}
                                    <td>

                                        {{ $ticket->location ?? '-' }}

                                    </td>


                                    {{-- Status --}}
                                    <td>

                                        @if($ticket->status === 'sedang_diproses')

                                            <span class="badge bg-warning text-dark">
                                                🟡 Sedang Diproses
                                            </span>

                                        @elseif($ticket->status === 'diterima')

                                            <span class="badge bg-primary">
                                                🔵 Diterima
                                            </span>

                                        @elseif($ticket->status === 'dalam_penanganan')

                                            <span class="badge bg-warning text-dark">
                                                🟠 Dalam Penanganan
                                            </span>

                                        @elseif($ticket->status === 'selesai')

                                            <span class="badge bg-success">
                                                🟢 Selesai
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Tanggal --}}
                                    <td>

                                        {{ $ticket->created_at->format('d/m/Y H:i') }}

                                    </td>


                                    {{-- Aksi --}}
                                   <td>

                                         <div class="d-flex gap-1">

                                     {{-- Detail --}}
                                    
                                        <a
                                            href="{{ route('it.tickets.show', $ticket->id) }}"
                                            class="btn btn-sm btn-outline-primary">

                                            <i class="bi bi-eye"></i>

                                            Detail

                                        </a>


                                    {{-- Terima --}}
                                    @if($ticket->status === 'sedang_diproses')

                                        <form
                                            action="{{ route('it.tickets.accept', $ticket->id) }}"
                                            method="POST">

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-primary">

                                                Terima

                                            </button>

                                        </form>

                                        @endif


                                    {{-- Mulai Penanganan --}}
                                    @if($ticket->status === 'diterima')

                                        <form
                                            action="{{ route('it.tickets.start', $ticket->id) }}"
                                            method="POST">

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-warning">

                                                Mulai Penanganan

                                            </button>

                                        </form>

                                    @endif


                                    {{-- Selesaikan --}}
                                    @if($ticket->status === 'dalam_penanganan')

                                        <form
                                            action="{{ route('it.tickets.complete', $ticket->id) }}"
                                            method="POST">

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-success">

                                                Selesaikan

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <div class="fs-1 mb-3">
                        🎫
                    </div>

                    <h5 class="fw-bold">
                        Belum Ada Tiket
                    </h5>

                    <p class="text-muted">
                        Belum ada laporan masalah dari pegawai.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection