@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('page-title', 'Dashboard Pegawai')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container-fluid px-0">

    {{-- Hero Welcome Banner --}}
    <div class="card border-0 shadow-sm text-white mb-4 overflow-hidden position-relative"
         style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); border-radius: 20px;">
        
        {{-- Background decorative ambient circles --}}
        <div class="position-absolute"
             style="width: 280px; height: 280px; background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, rgba(0,0,0,0) 70%); top: -60px; right: -40px; border-radius: 50%; pointer-events: none;">
        </div>

        <div class="card-body p-4 p-md-5 position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 text-info small fw-semibold mb-3">
                        <i class="bi bi-building"></i>
                        Departemen: {{ auth()->user()->department->name ?? 'Pegawai Perusahaan' }}
                    </div>

                    <h2 class="fw-bold mb-2 text-white">
                        Halo, {{ auth()->user()->name }} 👋
                    </h2>

                    <p class="text-slate-300 mb-4 opacity-75" style="max-width: 580px; font-size: 15px;">
                        Mengalami kendala pada komputer, laptop, jaringan internet, printer, atau sistem aplikasi? Tim IT Support kami siap membantu menyelesaikan masalah Anda.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('pegawai.tickets.create') }}" class="btn btn-primary px-4 py-2" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                            <i class="bi bi-plus-circle me-1"></i> Buat Laporan Tiket Baru
                        </a>
                        <a href="{{ route('pegawai.tickets.index') }}" class="btn btn-outline-light px-4 py-2" style="background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.25);">
                            <i class="bi bi-ticket-perforated me-1"></i> Lihat Tiket Saya
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                    <div class="d-inline-flex align-items-center justify-content-center p-4 rounded-4"
                         style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.12); width: 130px; height: 130px;">
                        <i class="bi bi-tools text-info" style="font-size: 64px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KPI Status Cards Pegawai --}}
    <div class="row g-3 mb-4">
        {{-- Total Tiket Diajukan --}}
        <div class="col-md-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-folder-fill"></i>
                        </div>
                        <span class="badge badge-soft-primary">Total Riwayat</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ $totalTiket ?? 0 }}</h2>
                    <small class="text-muted">Semua tiket yang pernah Anda ajukan</small>
                </div>
            </div>
        </div>

        {{-- Tiket Sedang Aktif / Diproses --}}
        <div class="col-md-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <span class="badge badge-soft-warning">Dalam Proses</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ $tiketAktif ?? 0 }}</h2>
                    <small class="text-muted">Sedang ditinjau atau ditangani IT</small>
                </div>
            </div>
        </div>

        {{-- Tiket Selesai --}}
        <div class="col-md-4">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <span class="badge badge-soft-success">Tuntas</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ $tiketSelesai ?? 0 }}</h2>
                    <small class="text-muted">Masalah telah berhasil diselesaikan</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Tickets & Info Section --}}
    <div class="row g-4">
        {{-- Tiket Terkini Pegawai --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-clock-history me-1 text-primary"></i> Status Tiket Terakhir Anda
                        </h6>
                        <small class="text-muted">Pantau progres penanganan kendala yang Anda laporkan</small>
                    </div>
                    <a href="{{ route('pegawai.tickets.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="card-body p-0">
                    @if(isset($recentTickets) && $recentTickets->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">No. Tiket</th>
                                        <th>Judul Masalah</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTickets as $ticket)
                                        <tr>
                                            <td class="ps-4">
                                                <a href="{{ route('pegawai.tickets.show', $ticket->id) }}" class="fw-bold text-decoration-none text-primary">
                                                    {{ $ticket->ticket_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 220px;" title="{{ $ticket->title }}">
                                                    {{ $ticket->title }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    {{ $ticket->category->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($ticket->status === 'sedang_diproses')
                                                    <span class="badge badge-soft-warning">
                                                        🟡 Sedang Diproses
                                                    </span>
                                                @elseif($ticket->status === 'diterima')
                                                    <span class="badge badge-soft-primary">
                                                        🔵 Diterima
                                                    </span>
                                                @elseif($ticket->status === 'dalam_penanganan')
                                                    <span class="badge badge-soft-warning text-dark" style="background-color: #fff7ed; color: #c2410c; border: 1px solid #fed7aa;">
                                                        🟠 Dalam Penanganan
                                                    </span>
                                                @elseif($ticket->status === 'selesai')
                                                    <span class="badge badge-soft-success">
                                                        🟢 Selesai
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $ticket->created_at->format('d/m/Y H:i') }}</small>
                                            </td>
                                            <td class="text-center pe-4">
                                                <a href="{{ route('pegawai.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                                    Lihat Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="fs-1 mb-2 text-muted">📋</div>
                            <h6 class="fw-bold">Belum Ada Pengajuan Tiket</h6>
                            <p class="text-muted small mb-3">Anda belum memiliki riwayat kendala yang dilaporkan.</p>
                            <a href="{{ route('pegawai.tickets.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Laporkan Masalah Sekarang
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Petunjuk & Bantuan Card --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-info-circle me-1 text-primary"></i> Panduan Layanan IT
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex gap-3 mb-3">
                        <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-card-text fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small text-dark">Deskripsi Rinci</div>
                            <small class="text-muted">Jelaskan kendala secara spesifik agar teknisi dapat mendiagnosis dengan cepat.</small>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-3">
                        <div class="rounded-3 bg-success bg-opacity-10 text-success p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-paperclip fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small text-dark">Lampirkan Bukti / Screenshot</div>
                            <small class="text-muted">Sertakan foto layar atau dokumen pendukung apabila terdapat pesan error.</small>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-3">
                        <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; flex-shrink: 0;">
                            <i class="bi bi-chat-dots fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-semibold small text-dark">Kolom Diskusi Tiket</div>
                            <small class="text-muted">Anda dapat saling bertukar pesan langsung dengan teknisi pada halaman detail tiket.</small>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="p-3 rounded-3 bg-light text-muted small">
                        <i class="bi bi-shield-lock me-1"></i> Jam operasional IT Helpdesk: Senin - Jumat (08:00 - 17:00 WIB).
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection