<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman laporan IT dengan filter dan statistik.
     */
    public function index(Request $request): View
    {
        $categories = Category::orderBy('name')->get();
        $departments = Department::orderBy('name')->get();

        $query = $this->buildReportQuery($request);

        // Menghitung ringkasan statistik berdasarkan filter
        $totalTiket = (clone $query)->count();
        $tiketSelesai = (clone $query)->where('status', 'selesai')->count();
        $tiketSedangDiproses = (clone $query)->where('status', 'sedang_diproses')->count();
        $tiketDiterima = (clone $query)->where('status', 'diterima')->count();
        $tiketDalamPenanganan = (clone $query)->where('status', 'dalam_penanganan')->count();
        $persentaseSelesai = $totalTiket > 0 ? round(($tiketSelesai / $totalTiket) * 100, 1) : 0;

        // Distribusi kategori
        $kategoriStats = Category::withCount(['tickets' => function ($q) use ($request) {
            $this->applyDateAndDepartmentFilter($q, $request);
        }])->get();

        // Distribusi departemen
        $departemenStats = Department::withCount(['tickets' => function ($q) use ($request) {
            $this->applyDateAndCategoryFilter($q, $request);
        }])->get();

        // Data tiket dengan pagination
        $tickets = $query->latest('created_at')->paginate(15)->withQueryString();

        return view('it.reports.index', compact(
            'tickets',
            'categories',
            'departments',
            'totalTiket',
            'tiketSelesai',
            'tiketSedangDiproses',
            'tiketDiterima',
            'tiketDalamPenanganan',
            'persentaseSelesai',
            'kategoriStats',
            'departemenStats'
        ));
    }

    /**
     * Ekspor data laporan ke format CSV.
     */
    public function export(Request $request): StreamedResponse
    {
        $query = $this->buildReportQuery($request);
        $fileName = 'laporan-tiket-it-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // Tambahkan UTF-8 BOM untuk kompatibilitas Microsoft Excel
            fwrite($handle, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($handle, [
                'No.',
                'Nomor Tiket',
                'Tanggal Dibuat',
                'Pelapor',
                'Departemen',
                'Judul Masalah',
                'Kategori',
                'Prioritas',
                'Status',
                'Teknisi IT',
                'Tanggal Selesai',
                'Lokasi',
            ]);

            $no = 1;
            $query->chunk(100, function ($tickets) use ($handle, &$no) {
                foreach ($tickets as $ticket) {
                    $statusLabel = match ($ticket->status) {
                        'sedang_diproses' => 'Sedang Diproses',
                        'diterima' => 'Diterima',
                        'dalam_penanganan' => 'Dalam Penanganan',
                        'selesai' => 'Selesai',
                        default => $ticket->status,
                    };

                    fputcsv($handle, [
                        $no++,
                        $ticket->ticket_number,
                        $ticket->created_at->format('d/m/Y H:i'),
                        $ticket->user->name ?? '-',
                        $ticket->user->department->name ?? '-',
                        $ticket->title,
                        $ticket->category->name ?? '-',
                        ucfirst($ticket->priority),
                        $statusLabel,
                        $ticket->technician->name ?? 'Belum Ditugaskan',
                        $ticket->resolved_at ? $ticket->resolved_at->format('d/m/Y H:i') : '-',
                        $ticket->location ?? '-',
                    ]);
                }
            });

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Membangun query dasar laporan sesuai request filter.
     */
    private function buildReportQuery(Request $request): Builder
    {
        $query = Ticket::with([
            'category',
            'user.department',
            'technician',
        ]);

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    /**
     * Terapkan filter tanggal dan departemen ke subquery.
     */
    private function applyDateAndDepartmentFilter(Builder $query, Request $request): void
    {
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
    }

    /**
     * Terapkan filter tanggal dan kategori ke subquery.
     */
    private function applyDateAndCategoryFilter(Builder $query, Request $request): void
    {
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
    }
}
