<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard untuk pegawai.
     */
    public function pegawai(): View
    {
        $userId = Auth::id();

        $totalTiket = Ticket::where('user_id', $userId)->count();

        $tiketAktif = Ticket::where('user_id', $userId)
            ->whereIn('status', ['sedang_diproses', 'diterima', 'dalam_penanganan'])
            ->count();

        $tiketSelesai = Ticket::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();

        $recentTickets = Ticket::with(['category', 'technician'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('pegawai.dashboard', compact(
            'totalTiket',
            'tiketAktif',
            'tiketSelesai',
            'recentTickets'
        ));
    }

    /**
     * Tampilkan dashboard untuk IT support.
     */
    public function it(): View
    {
        $totalTiket = Ticket::count();

        $tiketSedangDiproses = Ticket::where('status', 'sedang_diproses')->count();
        $tiketDiterima = Ticket::where('status', 'diterima')->count();
        $tiketDalamPenanganan = Ticket::where('status', 'dalam_penanganan')->count();
        $tiketSelesai = Ticket::where('status', 'selesai')->count();

        $recentTickets = Ticket::with(['user.department', 'category', 'technician'])
            ->latest()
            ->take(6)
            ->get();

        return view('it.dashboard', compact(
            'totalTiket',
            'tiketSedangDiproses',
            'tiketDiterima',
            'tiketDalamPenanganan',
            'tiketSelesai',
            'recentTickets'
        ));
    }
}
