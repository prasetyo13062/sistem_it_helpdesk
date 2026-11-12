@extends('layouts.app')

@section('title', 'Tiket Saya')

@section('page-title', 'Tiket Saya')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Tiket Saya
            </h4>

            <p class="text-muted mb-0">
                Daftar laporan masalah IT yang Anda buat.
            </p>
        </div>

        <a
            href="{{ route('pegawai.tickets.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-circle"></i>
            Buat Tiket

        </a>

    </div>


    {{-- Pesan sukses --}}
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


    {{-- Tabel --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            @if($tickets->count() > 0)

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>No. Tiket</th>

                                <th>Judul</th>

                                <th>Kategori</th>

                                <th>Prioritas</th>

                                <th>Status</th>

                                <th>Tanggal</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($tickets as $ticket)

                                <tr>

                                    <td>

                                        <strong>
                                            {{ $ticket->ticket_number }}
                                        </strong>

                                    </td>

                                    <td>

                                        {{ $ticket->title }}

                                    </td>

                                    <td>

                                        {{ $ticket->category->name ?? '-' }}

                                    </td>

                                    <td>

                                        @if($ticket->priority === 'tinggi')

                                            <span class="badge bg-danger">
                                                Tinggi
                                            </span>

                                        @elseif($ticket->priority === 'sedang')

                                            <span class="badge bg-warning text-dark">
                                                Sedang
                                            </span>

                                        @else

                                            <span class="badge bg-secondary">
                                                Rendah
                                            </span>

                                        @endif

                                    </td>

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

                                        @else

                                            <span class="badge bg-secondary">
                                                {{ $ticket->status }}
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        {{ $ticket->created_at->format('d/m/Y H:i') }}

                                    </td>

                                     <td>

                                         <a 
                                            href="{{ route('pegawai.tickets.show', $ticket->id) }}"
                                            class="btn btn-sm btn-outline-primary">

                                                <i class="bi bi-eye"></i>
                                                Detail

                                         </a>

                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="text-center py-5">

                    <div class="mb-3">

                        <i
                            class="bi bi-ticket-perforated"
                            style="font-size: 50px;">
                        </i>

                    </div>

                    <h5 class="fw-bold">
                        Belum Ada Tiket
                    </h5>

                    <p class="text-muted">
                        Anda belum membuat laporan masalah IT.
                    </p>

                    <a
                        href="{{ route('pegawai.tickets.create') }}"
                        class="btn btn-primary">

                        <i class="bi bi-plus-circle"></i>
                        Buat Tiket Pertama

                    </a>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection