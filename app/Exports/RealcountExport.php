<?php

namespace App\Exports;

use App\Models\{Kandidat, Vote};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RealcountExport implements FromCollection, WithHeadings {
    public function collection() {
        $kandidat   = Kandidat::withCount('votes')->orderBy('nomor_urut')->get();
        $totalVotes = Vote::count();

        return $kandidat->map(fn($k) => [
            'Nomor Urut'  => $k->nomor_urut,
            'Ketua'       => $k->nama_ketua,
            'Wakil'       => $k->nama_wakil,
            'Jumlah Suara'=> $k->votes_count,
            'Persentase'  => $totalVotes > 0
                ? round($k->votes_count / $totalVotes * 100, 2) . '%'
                : '0%',
        ]);
    }

    public function headings(): array {
        return ['Nomor Urut','Ketua','Wakil','Jumlah Suara','Persentase'];
    }
}