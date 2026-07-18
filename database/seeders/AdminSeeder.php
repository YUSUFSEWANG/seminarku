<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kegiatan;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun Admin
        User::create([
            'name'        => 'Administrator',
            'email'       => 'admin@seminarku.id',
            'password'    => Hash::make('Admin@12345'),
            'role'        => 'admin',
            'phone'       => '08100000001',
            'institution' => 'SeminarKu',
            'is_active'   => true,
        ]);

        // Buat akun User demo
        User::create([
            'name'        => 'Budi Santoso',
            'email'       => 'budi@example.com',
            'password'    => Hash::make('User@12345'),
            'role'        => 'user',
            'phone'       => '08199999999',
            'institution' => 'Universitas Contoh',
            'is_active'   => true,
        ]);

        // Buat beberapa kegiatan contoh
        $admin = User::where('role', 'admin')->first();

        Kegiatan::create([
            'nama'          => 'Seminar Nasional Teknologi Informasi 2026',
            'deskripsi'     => 'Seminar nasional membahas perkembangan terkini di bidang Teknologi Informasi dan Komunikasi, meliputi AI, Cloud Computing, dan Cybersecurity.',
            'lokasi'        => 'Aula Utama Gedung A, Kampus Pusat',
            'tanggal'       => '2026-08-15',
            'waktu_mulai'   => '08:00',
            'waktu_selesai' => '16:00',
            'kuota'         => 100,
            'biaya'         => 0,
            'status'        => 'aktif',
            'penyelenggara' => 'Himpunan Mahasiswa TI',
            'created_by'    => $admin->id,
        ]);

        Kegiatan::create([
            'nama'          => 'Workshop Laravel & DevSecOps',
            'deskripsi'     => 'Workshop intensif pengembangan aplikasi web dengan Laravel disertai praktik keamanan DevSecOps. Peserta akan belajar SAST, SCA, dan Threat Modeling.',
            'lokasi'        => 'Lab Komputer Lantai 3',
            'tanggal'       => '2026-09-05',
            'waktu_mulai'   => '09:00',
            'waktu_selesai' => '17:00',
            'kuota'         => 30,
            'biaya'         => 150000,
            'status'        => 'aktif',
            'penyelenggara' => 'Program Studi Sistem Informasi',
            'created_by'    => $admin->id,
        ]);

        Kegiatan::create([
            'nama'          => 'Pelatihan Public Speaking untuk Mahasiswa',
            'deskripsi'     => 'Pelatihan komunikasi dan public speaking untuk meningkatkan kepercayaan diri mahasiswa dalam presentasi akademik dan profesional.',
            'lokasi'        => 'Ruang Seminar 2B',
            'tanggal'       => '2026-10-10',
            'waktu_mulai'   => '10:00',
            'waktu_selesai' => '12:00',
            'kuota'         => 50,
            'biaya'         => 50000,
            'status'        => 'aktif',
            'penyelenggara' => 'Unit Kegiatan Mahasiswa',
            'created_by'    => $admin->id,
        ]);
    }
}
