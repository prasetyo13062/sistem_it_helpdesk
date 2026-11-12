@extends('layouts.app')

@section('title', 'Dashboard IT')

@section('page-title', 'Dashboard IT')

@section('content')

<div class="container-fluid px-0">

    {{-- Hero Operational Banner --}}
    <div class="card border-0 shadow-sm text-white mb-4 overflow-hidden position-relative"
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 20px;">
        
        {{-- Background decorative ambient lights --}}
        <div class="position-absolute"
             style="width: 320px; height: 320px; background: radial-gradient(circle, rgba(37, 99, 235, 0.25) 0%, rgba(0,0,0,0) 70%); top: -80px; right: -50px; border-radius: 50%; pointer-events: none;">
        </div>

        <div class="card-body p-4 p-md-5 position-relative" style="z-index: 2;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-primary bg-opacity-25 border border-primary border-opacity-25 text-info small fw-semibold mb-3">
                        <span class="spinner-grow spinner-grow-sm text-info" role="status" style="width: 8px; height: 8px;"></span>
                        Sistem Operasional IT Aktif
                    </div>

                    <h2 class="fw-bold mb-2 text-white">
                        Pusat Operasional IT Helpdesk
                    </h2>

                    <p class="text-slate-300 mb-4 opacity-75" style="max-width: 600px; font-size: 15px;">
                        Selamat bertugas, <strong>{{ auth()->user()->name }}</strong>. Pantau antrean laporan, tangani kendala teknis pegawai, dan pastikan SLA layanan IT tetap prima.
                    </p>

                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('it.tickets.index') }}" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-inbox me-1"></i> Periksa Tiket Masuk
                        </a>
                        <a href="{{ route('it.tickets.all') }}" class="btn btn-outline-light px-4 py-2" style="background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.2);">
                            <i class="bi bi-ticket-detailed me-1"></i> Semua Tiket
                        </a>
                        <a href="{{ route('it.reports.index') }}" class="btn btn-outline-light px-3 py-2" style="background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.2);">
                            <i class="bi bi-bar-chart me-1"></i> Laporan
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 text-center text-lg-end d-none d-lg-block">
                    <div class="d-inline-flex align-items-center justify-content-center p-4 rounded-4"
                         style="background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.1); width: 140px; height: 140px;">
                        <i class="bi bi-shield-check text-info" style="font-size: 72px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- KPI Metric Cards Grid --}}
    <div class="row g-3 mb-4">
        {{-- Total Tiket --}}
        <div class="col-6 col-xl-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-ticket-perforated-fill"></i>
                        </div>
                        <span class="badge badge-soft-primary">Total Tiket</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ $totalTiket }}</h2>
                    <small class="text-muted">Akumulasi seluruh laporan</small>
                </div>
            </div>
        </div>

        {{-- Sedang Diproses --}}
        <div class="col-6 col-xl-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <span class="badge badge-soft-warning">Menunggu</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ $tiketSedangDiproses }}</h2>
                    <small class="text-muted">Belum diterima oleh IT</small>
                </div>
            </div>
        </div>

        {{-- Dalam Penanganan --}}
        <div class="col-6 col-xl-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon text-info" style="background-color: rgba(14, 165, 233, 0.1);">
                            <i class="bi bi-gear-wide-connected"></i>
                        </div>
                        <span class="badge badge-soft-info">Dalam Proses</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ $tiketDalamPenanganan + $tiketDiterima }}</h2>
                    <small class="text-muted">{{ $tiketDiterima }} diterima &bull; {{ $tiketDalamPenanganan }} dikerjakan</small>
                </div>
            </div>
        </div>

        {{-- Selesai --}}
        <div class="col-6 col-xl-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <span class="badge badge-soft-success">Tuntas</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ $tiketSelesai }}</h2>
                    <small class="text-muted">Masalah berhasil diselesaikan</small>
                </div>
            </div>
        </div>
    </div>


    {{-- Launchpad Menu Cepat & Tiket Terbaru --}}
    <div class="row g-4 mb-4">
        {{-- Tiket Masuk Terbaru Table (Left Column / Main) --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-clock-history me-1 text-primary"></i> Tiket Masuk Terbaru
                        </h6>
                        <small class="text-muted">Laporan kendala terbaru yang diajukan oleh pegawai</small>
                    </div>
                    <a href="{{ route('it.tickets.index') }}" class="btn btn-sm btn-outline-primary">
                        Lihat Semua Antrean <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="card-body p-0">
                    @if(isset($recentTickets) && $recentTickets->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">No. Tiket</th>
                                        <th>Pelapor</th>
                                        <th>Judul Masalah</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTickets as $ticket)
                                        <tr>
                                            <td class="ps-4">
                                                <a href="{{ route('it.tickets.show', $ticket->id) }}" class="fw-bold text-decoration-none text-primary">
                                                    {{ $ticket->ticket_number }}
                                                </a>
                                                <div class="text-muted" style="font-size: 11px;">
                                                    {{ $ticket->created_at->diffForHumans() }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $ticket->user->name ?? '-' }}</div>
                                                <small class="text-muted">{{ $ticket->user->department->name ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;" title="{{ $ticket->title }}">
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
                                                        🟡 Menunggu
                                                    </span>
                                                @elseif($ticket->status === 'diterima')
                                                    <span class="badge badge-soft-primary">
                                                        🔵 Diterima
                                                    </span>
                                                @elseif($ticket->status === 'dalam_penanganan')
                                                    <span class="badge badge-soft-warning text-dark" style="background-color: #fff7ed; color: #c2410c; border: 1px solid #fed7aa;">
                                                        🟠 Ditangani
                                                    </span>
                                                @elseif($ticket->status === 'selesai')
                                                    <span class="badge badge-soft-success">
                                                        🟢 Selesai
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center pe-4">
                                                <a href="{{ route('it.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
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
                            <div class="fs-1 mb-2 text-muted">🎉</div>
                            <h6 class="fw-bold">Belum Ada Tiket Baru</h6>
                            <p class="text-muted small">Semua tiket telah ditangani atau belum ada pengajuan baru.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick Action Cards (Right Column) --}}
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-3">
                {{-- Card 1: Antrean Tiket Masuk --}}
                <div class="card card-hover border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="stat-icon bg-primary text-white">
                            <i class="bi bi-inbox-fill"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Tiket Perlu Ditangani</h6>
                            <small class="text-muted">Klaim dan proses antrean tiket baru</small>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Terdapat <strong>{{ $tiketSedangDiproses }}</strong> tiket menunggu respon segera dari tim teknisi.
                    </p>
                    <a href="{{ route('it.tickets.index') }}" class="btn btn-primary w-100">
                        Buka Antrean Tiket <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                {{-- Card 2: Arsip Riwayat & Audit --}}
                <div class="card card-hover border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Riwayat Penanganan</h6>
                            <small class="text-muted">Arsip dan jejak aktivitas</small>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Lihat rekam jejak tiket tuntas dan log kronologi pengerjaan oleh tim IT.
                    </p>
                    <a href="{{ route('it.tickets.history') }}" class="btn btn-outline-secondary w-100">
                        Buka Riwayat Tiket <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                {{-- Card 3: Rekap & Laporan --}}
                <div class="card card-hover border-0 shadow-sm p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="stat-icon text-info" style="background-color: rgba(14, 165, 233, 0.1);">
                            <i class="bi bi-file-earmark-bar-graph"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">Laporan & Ekspor</h6>
                            <small class="text-muted">Statistik performa & unduh CSV</small>
                        </div>
                    </div>
                    <p class="text-muted small mb-3">
                        Analisis data kendala berkala dan unduh berkas laporan resmi.
                    </p>
                    <a href="{{ route('it.reports.index') }}" class="btn btn-outline-info w-100 text-dark">
                        Buka Laporan IT <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection