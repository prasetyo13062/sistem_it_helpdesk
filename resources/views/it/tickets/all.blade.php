@extends('layouts.app')

@section('title', 'Semua Tiket')

@section('page-title', 'Semua Tiket')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container-fluid px-0">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">
                Semua Tiket
            </h4>
            <p class="text-muted mb-0">
                Daftar lengkap seluruh tiket kendala IT dari seluruh departemen dan pegawai.
            </p>
        </div>
    </div>

    {{-- Ringkasan Status / Filter Cepat --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md">
            <a href="{{ route('it.tickets.all') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm {{ !request('status') || request('status') === 'semua' ? 'border-start border-primary border-4' : '' }}">
                    <div class="card-body p-3">
                        <small class="text-muted text-uppercase fw-semibold">Total Tiket</small>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $counts['total'] }}</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('it.tickets.all', ['status' => 'sedang_diproses']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm {{ request('status') === 'sedang_diproses' ? 'border-start border-warning border-4' : '' }}">
                    <div class="card-body p-3">
                        <small class="text-warning text-uppercase fw-semibold">Sedang Diproses</small>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $counts['sedang_diproses'] }}</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('it.tickets.all', ['status' => 'diterima']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm {{ request('status') === 'diterima' ? 'border-start border-primary border-4' : '' }}">
                    <div class="card-body p-3">
                        <small class="text-primary text-uppercase fw-semibold">Diterima</small>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $counts['diterima'] }}</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('it.tickets.all', ['status' => 'dalam_penanganan']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm {{ request('status') === 'dalam_penanganan' ? 'border-start border-secondary border-4' : '' }}">
                    <div class="card-body p-3">
                        <small class="text-secondary text-uppercase fw-semibold">Penanganan</small>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $counts['dalam_penanganan'] }}</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md">
            <a href="{{ route('it.tickets.all', ['status' => 'selesai']) }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm {{ request('status') === 'selesai' ? 'border-start border-success border-4' : '' }}">
                    <div class="card-body p-3">
                        <small class="text-success text-uppercase fw-semibold">Selesai</small>
                        <h3 class="fw-bold text-dark mb-0 mt-1">{{ $counts['selesai'] }}</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form action="{{ route('it.tickets.all') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control border-start-0"
                               placeholder="Cari no. tiket, judul, pelapor...">
                    </div>
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="semua">Semua Status</option>
                        <option value="sedang_diproses" {{ request('status') === 'sedang_diproses' ? 'selected' : '' }}>🟡 Sedang Diproses</option>
                        <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>🔵 Diterima</option>
                        <option value="dalam_penanganan" {{ request('status') === 'dalam_penanganan' ? 'selected' : '' }}>🟠 Dalam Penanganan</option>
                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>🟢 Selesai</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="priority" class="form-select">
                        <option value="">Semua Prioritas</option>
                        <option value="rendah" {{ request('priority') === 'rendah' ? 'selected' : '' }}>Rendah</option>
                        <option value="sedang" {{ request('priority') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="tinggi" {{ request('priority') === 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        <option value="kritis" {{ request('priority') === 'kritis' ? 'selected' : '' }}>Kritis</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'category_id', 'priority']))
                        <a href="{{ route('it.tickets.all') }}" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Semua Tiket --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">No. Tiket</th>
                                <th>Pelapor</th>
                                <th>Judul Masalah</th>
                                <th>Kategori</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th>Teknisi IT</th>
                                <th>Tanggal</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
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
                                        @if($ticket->location)
                                            <small class="text-muted">
                                                <i class="bi bi-geo-alt"></i> {{ $ticket->location }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $ticket->category->name ?? '-' }}
                                        </span>
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
                                    <td>
                                        @if($ticket->technician)
                                            <span class="fw-semibold text-secondary">
                                                <i class="bi bi-person-badge me-1"></i>
                                                {{ $ticket->technician->name }}
                                            </span>
                                        @else
                                            <span class="text-muted fst-italic">Belum Ditugaskan</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $ticket->created_at->format('H:i') }}</small>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('it.tickets.show', $ticket->id) }}"
                                               class="btn btn-sm btn-outline-primary"
                                               title="Lihat Detail">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>

                                            @if($ticket->status === 'sedang_diproses')
                                                <form action="{{ route('it.tickets.accept', $ticket->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary" title="Terima Tiket">
                                                        Terima
                                                    </button>
                                                </form>
                                            @elseif($ticket->status === 'diterima')
                                                <form action="{{ route('it.tickets.start', $ticket->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning" title="Mulai Penanganan">
                                                        Mulai
                                                    </button>
                                                </form>
                                            @elseif($ticket->status === 'dalam_penanganan')
                                                <form action="{{ route('it.tickets.complete', $ticket->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Selesaikan Tiket">
                                                        Selesaikan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $tickets->firstItem() ?? 0 }} - {{ $tickets->lastItem() ?? 0 }} dari {{ $tickets->total() }} tiket
                    </small>
                    <div>
                        {{ $tickets->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="fs-1 mb-3">🎫</div>
                    <h5 class="fw-bold">Tidak Ada Tiket Ditemukan</h5>
                    <p class="text-muted mb-3">
                        @if(request()->hasAny(['search', 'status', 'category_id', 'priority']))
                            Tidak ada tiket yang sesuai dengan kriteria filter pencarian Anda.
                        @else
                            Belum ada tiket yang terdaftar di dalam sistem.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'status', 'category_id', 'priority']))
                        <a href="{{ route('it.tickets.all') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

</div>

@endsection
