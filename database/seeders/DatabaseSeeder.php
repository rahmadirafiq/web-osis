<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{Admin, User, Kandidat, Setting};

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Admin
        Admin::create([
            'nis'      => 'ADMIN001',
            'nama'     => 'Administrator',
            'password' => Hash::make('admin123'),
        ]);

        // Siswa demo
        $siswa = [
            ['0012345601', 'Andi Pratama',    'XII IPA 1', 'IPA'],
            ['0012345602', 'Sari Dewi',       'XII IPA 2', 'IPA'],
            ['0012345603', 'Budi Santoso',    'XII IPS 1', 'IPS'],
            ['0012345604', 'Fitri Handayani', 'XI IPA 1',  'IPA'],
            ['0012345605', 'Rizky Maulana',   'XI IPS 1',  'IPS'],
        ];

        foreach ($siswa as [$nisn, $nama, $kelas, $jurusan]) {
            User::create([
                'nisn'     => $nisn,
                'nama'     => $nama,
                'kelas'    => $kelas,
                'jurusan'  => $jurusan,
                'password' => Hash::make('siswa123'),
            ]);
        }

        // Kandidat
        Kandidat::create([
            'nomor_urut'   => 1,
            'nama_ketua'   => 'Ahmad Fauzi',
            'nama_wakil'   => 'Nadia Putri',
            'visi'         => 'Mewujudkan OSIS yang inovatif, kreatif, dan berdaya saing tinggi demi kemajuan SMAN 1 Bukittinggi.',
            'misi'         => "1. Meningkatkan kualitas kegiatan ekstrakurikuler\n2. Membangun komunikasi yang baik antara siswa dan guru\n3. Mengadakan program beasiswa untuk siswa berprestasi\n4. Meningkatkan fasilitas dan sarana belajar",
            'program_kerja'=> "• Program Belajar Bersama setiap Sabtu\n• Pekan Seni dan Olahraga tahunan\n• Gerakan Sekolah Bersih\n• Lomba Karya Ilmiah Remaja\n• Beasiswa Siswa Berprestasi",
        ]);

        Kandidat::create([
            'nomor_urut'   => 2,
            'nama_ketua'   => 'Dimas Arya',
            'nama_wakil'   => 'Sinta Maharani',
            'visi'         => 'Membangun generasi muda SMAN 1 Bukittinggi yang berkarakter, berbudaya, dan berprestasi di tingkat nasional.',
            'misi'         => "1. Memberdayakan seluruh organisasi di bawah OSIS\n2. Menjalin hubungan dengan sekolah lain\n3. Program literasi digital untuk seluruh siswa\n4. Penguatan nilai karakter dan kebudayaan lokal",
            'program_kerja'=> "• Festival Budaya Minangkabau\n• Kelas Digital dan Coding\n• Program Mentoring Adik Kelas\n• Kompetisi Debat Bahasa Inggris\n• Kerja sama dengan alumni",
        ]);

        // Settings
        $settings = [
            ['voting_open',        'false',             'Status Voting'],
            ['show_result',        'false',             'Tampilkan Hasil'],
            ['nama_sekolah',       'SMAN 1 Bukittinggi','Nama Sekolah'],
            ['tahun_ajaran',       '2024/2025',         'Tahun Ajaran'],
            ['tanggal_mulai',      now()->format('Y-m-d H:i'), 'Tanggal Mulai Voting'],
            ['tanggal_selesai',    now()->addDays(7)->format('Y-m-d H:i'), 'Tanggal Selesai Voting'],
        ];

        foreach ($settings as [$key, $value, $label]) {
            Setting::create(['key' => $key, 'value' => $value, 'label' => $label, 'updated_at' => now()]);
        }
    }
}