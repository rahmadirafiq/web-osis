<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Kandidat, Vote, Setting};
use Barryvdh\DomPDF\Facade\Pdf;

class RealcountController extends Controller {
    public function index() {
        $kandidat   = Kandidat::withCount('votes')->orderBy('nomor_urut')->get();
        $totalVotes = Vote::count();
        return view('admin.realcount', compact('kandidat', 'totalVotes'));
    }

    public function data() {
        $kandidat   = Kandidat::withCount('votes')->orderBy('nomor_urut')->get();
        $totalVotes = Vote::count();
        $votes      = Vote::orderByDesc('voted_at')->take(50)->get(['voted_at', 'kandidat_id']);

        return response()->json([
            'kandidat'    => $kandidat,
            'totalVotes'  => $totalVotes,
            'recentVotes' => $votes,
        ]);
    }

    public function exportPdf() {
        $kandidat   = Kandidat::withCount('votes')->orderBy('nomor_urut')->get();
        $totalVotes = Vote::count();
        $pdf = Pdf::loadView('admin.exports.realcount-pdf', compact('kandidat', 'totalVotes'));
        return $pdf->download('rekap-voting.pdf');
    }

    public function exportExcel() {
        $kandidat   = Kandidat::withCount('votes')->orderBy('nomor_urut')->get();
        $totalVotes = Vote::count();
        $namaSekolah = Setting::where('key','nama_sekolah')->value('value') ?? 'SMAN 1 Bukittinggi';
        $tahunAjaran = Setting::where('key','tahun_ajaran')->value('value') ?? '-';

        // Build CSV with BOM for Excel UTF-8 compatibility
        $bom  = "\xEF\xBB\xBF";
        $rows = [];
        $rows[] = implode(',', ['REKAP HASIL VOTING OSIS ' . strtoupper($namaSekolah)]);
        $rows[] = implode(',', ['Tahun Ajaran: ' . $tahunAjaran]);
        $rows[] = implode(',', ['Tanggal Export: ' . now()->format('d/m/Y H:i')]);
        $rows[] = '';
        $rows[] = implode(',', ['No. Urut','Nama Ketua','Nama Wakil','Jumlah Suara','Persentase']);

        foreach ($kandidat as $k) {
            $pct = $totalVotes > 0 ? round($k->votes_count / $totalVotes * 100, 2) . '%' : '0%';
            $rows[] = implode(',', [
                $k->nomor_urut,
                '"' . $k->nama_ketua . '"',
                '"' . $k->nama_wakil . '"',
                $k->votes_count,
                $pct,
            ]);
        }

        $rows[] = '';
        $rows[] = implode(',', ['TOTAL','',$totalVotes . ' suara','100%']);

        $csv = $bom . implode("\r\n", $rows);

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="rekap-voting-' . date('Ymd-His') . '.csv"',
            'Pragma'              => 'no-cache',
        ]);
    }
}
