@extends('layouts.app')

@section('title', 'Laporan IT Helpdesk')

@section('page-title', 'Laporan')

@push('styles')
<style>
    @media print {
        .sidebar, .top-navbar, .filter-card, .btn-action-group, .pagination-wrapper {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .content-wrapper {
            padding: 0 !important;
        }
        .card {
            border: 1px solid #dee2e6 !important;
            box-shadow: none !important;
        }
        .print-header {
            display: block !important;
        }
    }
    .print-header {
        display: none;
    }
</style>
@endpush

@section('content')

<div class="container-fluid px-0">

    {{-- Print Only Header --}}
    <div class="print-header mb-4 text-center">
        <h3 class="fw-bold mb-1">LAPORAN PENANGANAN TIKET IT HELPDESK</h3>
        <p class="text-muted mb-1">
            Periode: 
            {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') : 'Awal' }} 
            s/d 
            {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') : 'Sekarang' }}
        </p>
        <small class="text-muted">Dicetak pada: {{ now()->format('d/m/Y H:i') }} oleh {{ auth()->user()->name }}</small>
        <hr>
    </div>

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h4 class="fw-bold mb-1">
                Laporan & Statistik IT Helpdesk
            </h4>
            <p class="text-muted mb-0">
                Rekapitulasi, analisis performa penyelesaian kendala, dan rekap data tiket.
            </p>
        </div>

        <div class="btn-action-group d-flex gap-2">
            <button onclick="window.print()" class="btn btn-outline-secondary">
                <i class="bi bi-printer me-1"></i> Cetak / PDF
            </button>
            <a href="{{ route('it.reports.export', request()->query()) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i> Ekspor Excel/CSV
            </a>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm mb-4 filter-card">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-sliders me-1 text-primary"></i> Filter Periode & Kriteria Laporan
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('it.reports.index') }}" method="GET">
                <div class="row g-3">
                    {{-- Tanggal Mulai --}}
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted">Tanggal Mulai</label>
                        <input type="date"
                               name="start_date"
                               value="{{ request('start_date') }}"
                               class="form-control">
                    </div>

                    {{-- Tanggal Selesai --}}
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted">Tanggal Selesai</label>
                        <input type="date"
                               name="end_date"
                               value="{{ request('end_date') }}"
                               class="form-control">
                    </div>

                    {{-- Status --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="semua">Semua Status</option>
                            <option value="sedang_diproses" {{ request('status') === 'sedang_diproses' ? 'selected' : '' }}>🟡 Sedang Diproses</option>
                            <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>🔵 Diterima</option>
                            <option value="dalam_penanganan" {{ request('status') === 'dalam_penanganan' ? 'selected' : '' }}>🟠 Dalam Penanganan</option>
                            <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>🟢 Selesai</option>
                        </select>
                    </div>

                    {{-- Departemen --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold text-muted">Departemen</label>
                        <select name="department_id" class="form-select">
                            <option value="">Semua Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kategori --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold text-muted">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Prioritas --}}
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-muted">Prioritas</label>
                        <select name="priority" class="form-select">
                            <option value="">Semua Prioritas</option>
                            <option value="rendah" {{ request('priority') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ request('priority') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ request('priority') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                            <option value="kritis" {{ request('priority') === 'kritis' ? 'selected' : '' }}>Kritis</option>
                        </select>
                    </div>

                    {{-- Kata Kunci --}}
                    <div class="col-md-6">
                        <label class="form-label small fw-semibold text-muted">Kata Kunci (No. Tiket / Judul / Pelapor)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="form-control border-start-0"
                                   placeholder="Contoh: IT-2026-0001, printer rusak, Budi...">
                        </div>
                    </div>

                    {{-- Tombol Filter --}}
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-1"></i> Terapkan
                        </button>
                        @if(request()->hasAny(['start_date', 'end_date', 'status', 'department_id', 'category_id', 'priority', 'search']))
                            <a href="{{ route('it.reports.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Kartu Ringkasan KPI --}}
    <div class="row g-3 mb-4">
        {{-- Total Tiket --}}
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm border-start border-primary border-4 h-100">
                <div class="card-body p-3">
                    <small class="text-muted text-uppercase fw-semibold">Total Tiket Masuk</small>
                    <h2 class="fw-bold text-dark mb-1 mt-1">{{ $totalTiket }}</h2>
                    <small class="text-muted">Dalam periode filter</small>
                </div>
            </div>
        </div>

        {{-- Tiket Selesai --}}
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm border-start border-success border-4 h-100">
                <div class="card-body p-3">
                    <small class="text-success text-uppercase fw-semibold">Tiket Selesai</small>
                    <h2 class="fw-bold text-success mb-1 mt-1">{{ $tiketSelesai }}</h2>
                    <small class="text-muted">
                        Tingkat Selesai: <strong>{{ $persentaseSelesai }}%</strong>
                    </small>
                </div>
            </div>
        </div>

        {{-- Sedang Ditangani --}}
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm border-start border-warning border-4 h-100">
                <div class="card-body p-3">
                    <small class="text-warning text-uppercase fw-semibold">Dalam Pengerjaan</small>
                    <h2 class="fw-bold text-warning mb-1 mt-1">{{ $tiketDalamPenanganan + $tiketDiterima }}</h2>
                    <small class="text-muted">
                        {{ $tiketDiterima }} diterima, {{ $tiketDalamPenanganan }} diproses
                    </small>
                </div>
            </div>
        </div>

        {{-- Menunggu Respon --}}
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm border-start border-danger border-4 h-100">
                <div class="card-body p-3">
                    <small class="text-danger text-uppercase fw-semibold">Menunggu Respon IT</small>
                    <h2 class="fw-bold text-danger mb-1 mt-1">{{ $tiketSedangDiproses }}</h2>
                    <small class="text-muted">Belum diterima teknisi</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Distribusi Data Kategori & Departemen --}}
    <div class="row g-4 mb-4">
        {{-- Distribusi Kategori --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-pie-chart me-1 text-primary"></i> Distribusi Kendala per Kategori
                    </h6>
                </div>
                <div class="card-body p-3">
                    @forelse($kategoriStats as $cat)
                        @php
                            $catPercentage = $totalTiket > 0 ? round(($cat->tickets_count / $totalTiket) * 100, 1) : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold small">{{ $cat->name }}</span>
                                <span class="text-muted small">{{ $cat->tickets_count }} tiket ({{ $catPercentage }}%)</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary"
                                     role="progressbar"
                                     style="width: {{ $catPercentage }}%"
                                     aria-valuenow="{{ $catPercentage }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3 mb-0">Belum ada data kategori.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Distribusi Departemen --}}
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-building me-1 text-primary"></i> Laporan per Departemen
                    </h6>
                </div>
                <div class="card-body p-3">
                    @forelse($departemenStats as $dept)
                        @php
                            $deptPercentage = $totalTiket > 0 ? round(($dept->tickets_count / $totalTiket) * 100, 1) : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold small">{{ $dept->name }}</span>
                                <span class="text-muted small">{{ $dept->tickets_count }} tiket ({{ $deptPercentage }}%)</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success"
                                     role="progressbar"
                                     style="width: {{ $deptPercentage }}%"
                                     aria-valuenow="{{ $deptPercentage }}"
                                     aria-valuemin="0"
                                     aria-valuemax="100"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-3 mb-0">Belum ada data departemen.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Data Laporan --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold mb-0 text-dark">
                <i class="bi bi-table me-1 text-primary"></i> Rincian Data Tiket ({{ $tickets->total() }} Tiket)
            </h6>
        </div>
        <div class="card-body p-0">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No.</th>
                                <th>No. Tiket</th>
                                <th>Tanggal Dibuat</th>
                                <th>Pelapor</th>
                                <th>Departemen</th>
                                <th>Judul Masalah</th>
                                <th>Kategori</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th>Teknisi IT</th>
                                <th class="pe-4">Tanggal Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $index => $ticket)
                                <tr>
                                    <td class="ps-4 text-muted small">
                                        {{ $tickets->firstItem() + $index }}
                                    </td>
                                    <td>
                                        <a href="{{ route('it.tickets.show', $ticket->id) }}" class="fw-bold text-decoration-none text-primary">
                                            {{ $ticket->ticket_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $ticket->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $ticket->user->name ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $ticket->user->department->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $ticket->title }}">
                                            {{ $ticket->title }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="small">{{ $ticket->category->name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        @if($ticket->priority === 'kritis')
                                            <span class="badge bg-danger">Kritis</span>
                                        @elseif($ticket->priority === 'tinggi')
                                            <span class="badge bg-warning text-dark">Tinggi</span>
                                        @elseif($ticket->priority === 'sedang')
                                            <span class="badge bg-info text-dark">Sedang</span>
                                        @else
                                            <span class="badge bg-secondary">Rendah</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ticket->status === 'sedang_diproses')
                                            <span class="badge bg-warning text-dark">🟡 Diproses</span>
                                        @elseif($ticket->status === 'diterima')
                                            <span class="badge bg-primary">🔵 Diterima</span>
                                        @elseif($ticket->status === 'dalam_penanganan')
                                            <span class="badge bg-warning text-dark">🟠 Penanganan</span>
                                        @elseif($ticket->status === 'selesai')
                                            <span class="badge bg-success">🟢 Selesai</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $ticket->technician->name ?? '-' }}
                                    </td>
                                    <td class="pe-4">
                                        @if($ticket->resolved_at)
                                            <div>{{ $ticket->resolved_at->format('d/m/Y') }}</div>
                                            <small class="text-success">{{ $ticket->resolved_at->format('H:i') }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper p-3 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $tickets->firstItem() ?? 0 }} - {{ $tickets->lastItem() ?? 0 }} dari {{ $tickets->total() }} tiket
                    </small>
                    <div>
                        {{ $tickets->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="fs-1 mb-3 text-muted">📊</div>
                    <h5 class="fw-bold">Tidak Ada Data Tiket yang Sesuai</h5>
                    <p class="text-muted mb-3">
                        Tidak ada tiket yang tercatat pada rentang tanggal atau filter yang dipilih.
                    </p>
                    @if(request()->hasAny(['start_date', 'end_date', 'status', 'department_id', 'category_id', 'priority', 'search']))
                        <a href="{{ route('it.reports.index') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
