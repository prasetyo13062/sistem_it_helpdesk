<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketComment;
use App\Models\TicketHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    // =====================================================
    // TIKET PEGAWAI
    // =====================================================

    public function index()
    {
        $tickets = Ticket::with(['category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pegawai.tickets.index', compact('tickets'));
    }

    // =====================================================
    // TIKET UNTUK IT
    // =====================================================

    public function itIndex()
    {
        $tickets = Ticket::with([
            'category',
            'user',
        ])
            ->latest()
            ->get();

        return view('it.tickets.index', compact('tickets'));
    }

    // =====================================================
    // SEMUA TIKET (UNTUK IT)
    // =====================================================

    public function allTickets(Request $request): View
    {
        $categories = Category::orderBy('name')->get();

        $query = Ticket::with([
            'category',
            'user.department',
            'technician',
        ]);

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
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

        $tickets = $query->latest()->paginate(10)->withQueryString();

        $counts = [
            'total' => Ticket::count(),
            'sedang_diproses' => Ticket::where('status', 'sedang_diproses')->count(),
            'diterima' => Ticket::where('status', 'diterima')->count(),
            'dalam_penanganan' => Ticket::where('status', 'dalam_penanganan')->count(),
            'selesai' => Ticket::where('status', 'selesai')->count(),
        ];

        return view('it.tickets.all', compact('tickets', 'categories', 'counts'));
    }

    // =====================================================
    // RIWAYAT TIKET & AKTIVITAS IT
    // =====================================================

    public function history(Request $request): View
    {
        // 1. Tiket yang sudah diselesaikan
        $completedQuery = Ticket::with([
            'category',
            'user.department',
            'technician',
        ])->where('status', 'selesai');

        if ($request->filled('search')) {
            $search = $request->search;
            $completedQuery->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($uq) use ($search) {
                        $uq->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('technician', function ($tq) use ($search) {
                        $tq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $completedTickets = $completedQuery->latest('resolved_at')
            ->paginate(10, ['*'], 'completed_page')
            ->withQueryString();

        // 2. Seluruh log riwayat aktivitas tiket (TicketHistory)
        $historyLogs = TicketHistory::with([
            'ticket.category',
            'user',
        ])
            ->latest('created_at')
            ->paginate(15, ['*'], 'log_page')
            ->withQueryString();

        $completedCount = Ticket::where('status', 'selesai')->count();
        $totalLogsCount = TicketHistory::count();

        return view('it.tickets.history', compact(
            'completedTickets',
            'historyLogs',
            'completedCount',
            'totalLogsCount'
        ));
    }

    public function itShow($id)
    {
        $ticket = Ticket::with([
            'user.department',
            'category',
            'technician',
            'history.user',
            'comments.user',
            'attachments.user',
        ])->findOrFail($id);

        return view('it.tickets.show', compact('ticket'));
    }

    public function addHandling(Request $request, $id)
    {

        $ticket = Ticket::findOrFail($id);

        // Catatan hanya bisa ditambahkan ketika tiket sedang ditangani
        if ($ticket->status !== 'dalam_penanganan') {
            return back()->with('error', 'Catatan penanganan hanya dapat ditambahkan saat tiket dalam penanganan.');
        }

        // Validasi
        $validated = $request->validate([
            'note' => 'required|string|max:2000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx|max:5120',
        ]);

        // Upload file jika ada
        $filePath = null;

        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')
                ->store('ticket-attachments', 'public');
        }

        DB::transaction(function () use ($ticket, $validated, $filePath) {

            // Simpan catatan penanganan
            TicketComment::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'comment' => $validated['note'],
            ]);

            // Simpan lampiran jika ada
            if ($filePath) {

                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => Auth::id(),
                    'file' => $filePath,
                    'description' => 'Bukti penanganan IT',
                    'created_at' => now(),
                ]);

            }

            // Simpan ke timeline
            TicketHistory::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'status' => $ticket->status,
                'description' => 'IT menambahkan catatan penanganan.',
                'created_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'Catatan penanganan berhasil disimpan.'
        );
    }
    // =====================================================
    // TAMBAH KOMENTAR
    // =====================================================

    public function addComment(Request $request, $id)
    {
        // Jika pegawai, hanya boleh komentar pada tiket miliknya
        if (Auth::user()->role === 'pegawai') {

            $ticket = Ticket::where('user_id', Auth::id())
                ->findOrFail($id);

        } else {

            // IT dapat komentar pada semua tiket
            $ticket = Ticket::findOrFail($id);

        }

        // Validasi komentar
        $validated = $request->validate([
            'comment' => 'required|string|max:2000',
        ]);

        // Simpan komentar
        TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
        ]);

        return back()->with(
            'success',
            'Komentar berhasil ditambahkan.'
        );
    }

    // =====================================================
    // DETAIL TIKET PEGAWAI
    // =====================================================

    public function show($id)
    {
        $ticket = Ticket::with([
            'category',
            'history.user',
            'comments.user',
            'attachments',
        ])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pegawai.tickets.show', compact('ticket'));
    }

    // =====================================================
    // FORM BUAT TIKET
    // =====================================================

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('pegawai.tickets.create', compact('categories'));
    }

    // =====================================================
    // SIMPAN TIKET BARU
    // =====================================================

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'attachments.*' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
                'max:5120',
            ],

        ], [

            'title.required' => 'Judul masalah wajib diisi.',

            'category_id.required' => 'Kategori wajib dipilih.',

            'category_id.exists' => 'Kategori tidak valid.',

            'description.required' => 'Deskripsi masalah wajib diisi.',

            'attachments.*.mimes' => 'File harus berupa JPG, JPEG, PNG, PDF, DOC, DOCX, XLS, atau XLSX.',

            'attachments.*.max' => 'Ukuran file maksimal 5 MB.',
        ]);

        DB::transaction(function () use ($request, $validated) {

            // =================================================
            // MEMBUAT NOMOR TIKET
            // =================================================

            $nextId = (Ticket::max('id') ?? 0) + 1;

            $ticketNumber = 'IT-'.date('Y').'-'.str_pad(
                $nextId,
                4,
                '0',
                STR_PAD_LEFT
            );

            // =================================================
            // MEMBUAT TIKET
            // =================================================

            $ticket = Ticket::create([

                'ticket_number' => $ticketNumber,

                'user_id' => Auth::id(),

                'technician_id' => null,

                'category_id' => $validated['category_id'],

                'department_id' => Auth::user()->department_id,

                'title' => $validated['title'],

                'description' => $validated['description'],

                'location' => $validated['location'] ?? null,

                'priority' => 'sedang',

                'status' => 'sedang_diproses',
            ]);

            // =================================================
            // HISTORY AWAL
            // =================================================

            TicketHistory::create([

                'ticket_id' => $ticket->id,

                'user_id' => Auth::id(),

                'status' => 'sedang_diproses',

                'description' => 'Tiket berhasil dibuat oleh pegawai.',

                'created_at' => now(),
            ]);

            // =================================================
            // SIMPAN LAMPIRAN
            // =================================================

            if ($request->hasFile('attachments')) {

                foreach (
                    $request->file('attachments') as $file
                ) {

                    $path = $file->store(
                        'ticket-attachments',
                        'public'
                    );

                    TicketAttachment::create([

                        'ticket_id' => $ticket->id,

                        'user_id' => Auth::id(),

                        'file' => $path,

                        'description' => null,
                    ]);
                }
            }
        });

        return redirect()
            ->route('pegawai.dashboard')
            ->with(
                'success',
                'Tiket berhasil dibuat.'
            );
    }

    // =====================================================
    // PROSES TIKET OLEH IT
    // =====================================================

    // =====================================================
    // 1. IT MENERIMA TIKET
    // =====================================================

    public function accept($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Pastikan status masih sedang diproses
        if ($ticket->status !== 'sedang_diproses') {

            return back()->with(
                'error',
                'Tiket tidak dapat diterima pada status saat ini.'
            );
        }

        DB::transaction(function () use ($ticket) {

            // Simpan teknisi yang menerima tiket
            $ticket->technician_id = Auth::id();

            // Ubah status
            $ticket->status = 'diterima';

            $ticket->save();

            // Simpan history
            TicketHistory::create([

                'ticket_id' => $ticket->id,

                'user_id' => Auth::id(),

                'status' => 'diterima',

                'description' => 'Tiket telah diterima oleh tim IT.',

                'created_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'Tiket berhasil diterima.'
        );
    }

    // =====================================================
    // 2. IT MULAI PENANGANAN
    // =====================================================

    public function startHandling($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Tiket harus sudah diterima
        if ($ticket->status !== 'diterima') {

            return back()->with(
                'error',
                'Tiket belum dapat masuk ke tahap penanganan.'
            );
        }

        DB::transaction(function () use ($ticket) {

            // Ubah status
            $ticket->status = 'dalam_penanganan';

            $ticket->save();

            // Simpan history
            TicketHistory::create([

                'ticket_id' => $ticket->id,

                'user_id' => Auth::id(),

                'status' => 'dalam_penanganan',

                'description' => 'Tiket mulai ditangani oleh tim IT.',

                'created_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'Tiket masuk ke dalam penanganan.'
        );
    }

    // =====================================================
    // 3. IT MENYELESAIKAN TIKET
    // =====================================================

    public function complete($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Tiket harus sedang ditangani
        if ($ticket->status !== 'dalam_penanganan') {

            return back()->with(
                'error',
                'Tiket belum dapat diselesaikan.'
            );
        }

        DB::transaction(function () use ($ticket) {

            // Ubah status menjadi selesai
            $ticket->status = 'selesai';

            // Simpan waktu penyelesaian
            $ticket->resolved_at = now();

            $ticket->save();

            // Simpan history
            TicketHistory::create([

                'ticket_id' => $ticket->id,

                'user_id' => Auth::id(),

                'status' => 'selesai',

                'description' => 'Masalah telah selesai ditangani oleh tim IT.',

                'created_at' => now(),
            ]);
        });

        return back()->with(
            'success',
            'Tiket berhasil diselesaikan.'
        );
    }
}
