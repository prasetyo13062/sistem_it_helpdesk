@extends('layouts.app')

@section('title', 'Riwayat Tiket & Aktivitas')

@section('page-title', 'Riwayat')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Riwayat Tiket & Aktivitas IT
            </h4>
            <p class="text-muted mb-0">
                Arsip riwayat penanganan tiket yang telah selesai serta log kronologis penanganan seluruh tiket.
            </p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm border-start border-success border-4">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-success text-uppercase fw-semibold">Tiket Selesai Ditangani</small>
                        <h2 class="fw-bold text-dark mb-0 mt-1">{{ $completedCount }}</h2>
                    </div>
                    <div class="fs-1 text-success opacity-75">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm border-start border-primary border-4">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-primary text-uppercase fw-semibold">Total Log Aktivitas Tercatat</small>
                        <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalLogsCount }}</h2>
                    </div>
                    <div class="fs-1 text-primary opacity-75">
                        <i class="bi bi-journal-text"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Nav Tabs --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom pt-3 pb-0 px-4">
            <ul class="nav nav-tabs card-header-tabs" id="historyTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold"
                            id="completed-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#completed-pane"
                            type="button"
                            role="tab">
                        <i class="bi bi-check2-all me-1 text-success"></i>
                        Tiket Selesai
                        <span class="badge bg-success ms-1">{{ $completedCount }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold"
                            id="logs-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#logs-pane"
                            type="button"
                            role="tab">
                        <i class="bi bi-clock-history me-1 text-primary"></i>
                        Log Aktivitas Penanganan
                        <span class="badge bg-secondary ms-1">{{ $totalLogsCount }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content" id="historyTabContent">

                {{-- TAB 1: TIKET SELESAI --}}
                <div class="tab-pane fade show active" id="completed-pane" role="tabpanel">
                    {{-- Filter Form --}}
                    <div class="p-3 border-bottom bg-light">
                        <form action="{{ route('it.tickets.history') }}" method="GET" class="row g-2 align-items-center">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class="bi bi-search text-muted"></i>
                                    </span>
                                    <input type="text"
                                           name="search"
                                           value="{{ request('search') }}"
                                           class="form-control border-start-0"
                                           placeholder="Cari nomor tiket, judul, pelapor, teknisi...">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-1"></i> Cari
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('it.tickets.history') }}" class="btn btn-outline-secondary">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    @if($completedTickets->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">No. Tiket</th>
                                        <th>Pelapor</th>
                                        <th>Judul Masalah</th>
                                        <th>Kategori</th>
                                        <th>Teknisi Penuntas</th>
                                        <th>Waktu Masuk</th>
                                        <th>Waktu Selesai</th>
                                        <th>Durasi</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedTickets as $ticket)
                                        <tr>
                                            <td class="ps-4">
                                                <a href="{{ route('it.tickets.show', $ticket->id) }}" class="fw-bold text-decoration-none text-primary">
                                                    {{ $ticket->ticket_number }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $ticket->user->name ?? '-' }}</div>
                                                <small class="text-muted">{{ $ticket->user->department->name ?? '-' }}</small>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 250px;">
                                                    {{ $ticket->title }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark border">
                                                    {{ $ticket->category->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($ticket->technician)
                                                    <span class="fw-semibold text-dark">
                                                        <i class="bi bi-person-check text-success me-1"></i>
                                                        {{ $ticket->technician->name }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                                                <small class="text-muted">{{ $ticket->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                @if($ticket->resolved_at)
                                                    <div>{{ $ticket->resolved_at->format('d/m/Y') }}</div>
                                                    <small class="text-success fw-semibold">{{ $ticket->resolved_at->format('H:i') }}</small>
                                                @else
                                                    <span class="text-muted">{{ $ticket->updated_at->format('d/m/Y H:i') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($ticket->resolved_at)
                                                    <span class="badge bg-secondary">
                                                        {{ $ticket->created_at->diffForHumans($ticket->resolved_at, true) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center pe-4">
                                                <a href="{{ route('it.tickets.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-3 border-top d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Menampilkan {{ $completedTickets->firstItem() ?? 0 }} - {{ $completedTickets->lastItem() ?? 0 }} dari {{ $completedTickets->total() }} tiket selesai
                            </small>
                            <div>
                                {{ $completedTickets->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="fs-1 mb-3 text-muted">📁</div>
                            <h5 class="fw-bold">Belum Ada Riwayat Tiket Selesai</h5>
                            <p class="text-muted">
                                @if(request('search'))
                                    Tidak ditemukan tiket selesai dengan kata kunci "{{ request('search') }}".
                                @else
                                    Tiket yang telah berhasil diselesaikan oleh tim IT akan muncul di sini.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

                {{-- TAB 2: LOG AKTIVITAS (TIMELINE) --}}
                <div class="tab-pane fade" id="logs-pane" role="tabpanel">
                    @if($historyLogs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Waktu</th>
                                        <th>No. Tiket</th>
                                        <th>Aktor</th>
                                        <th>Status Perubahan</th>
                                        <th>Deskripsi / Catatan</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($historyLogs as $log)
                                        <tr>
                                            <td class="ps-4 text-nowrap">
                                                <div class="fw-semibold">
                                                    {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y') }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}
                                                </small>
                                            </td>
                                            <td>
                                                @if($log->ticket)
                                                    <a href="{{ route('it.tickets.show', $log->ticket->id) }}" class="fw-bold text-decoration-none">
                                                        {{ $log->ticket->ticket_number }}
                                                    </a>
                                                    <div class="text-truncate text-muted small" style="max-width: 200px;">
                                                        {{ $log->ticket->title }}
                                                    </div>
                                                @else
                                                    <span class="text-muted">#{{ $log->ticket_id }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-semibold">{{ $log->user->name ?? 'Sistem' }}</div>
                                                <small class="badge bg-light text-dark border">
                                                    {{ ucfirst($log->user->role ?? '-') }}
                                                </small>
                                            </td>
                                            <td>
                                                @if($log->status === 'sedang_diproses')
                                                    <span class="badge bg-warning text-dark">
                                                        🟡 Sedang Diproses
                                                    </span>
                                                @elseif($log->status === 'diterima')
                                                    <span class="badge bg-primary">
                                                        🔵 Diterima
                                                    </span>
                                                @elseif($log->status === 'dalam_penanganan')
                                                    <span class="badge bg-warning text-dark">
                                                        🟠 Dalam Penanganan
                                                    </span>
                                                @elseif($log->status === 'selesai')
                                                    <span class="badge bg-success">
                                                        🟢 Selesai
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $log->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span>{{ $log->description ?? '-' }}</span>
                                            </td>
                                            <td class="text-center pe-4">
                                                @if($log->ticket)
                                                    <a href="{{ route('it.tickets.show', $log->ticket->id) }}" class="btn btn-sm btn-outline-secondary" title="Lihat Tiket">
                                                        <i class="bi bi-box-arrow-up-right"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="p-3 border-top d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Menampilkan {{ $historyLogs->firstItem() ?? 0 }} - {{ $historyLogs->lastItem() ?? 0 }} dari {{ $historyLogs->total() }} log aktivitas
                            </small>
                            <div>
                                {{ $historyLogs->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="fs-1 mb-3 text-muted">📜</div>
                            <h5 class="fw-bold">Belum Ada Log Aktivitas</h5>
                            <p class="text-muted">
                                Rekam jejak seluruh penanganan tiket akan dicatat dan ditampilkan di sini.
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>

@endsection
