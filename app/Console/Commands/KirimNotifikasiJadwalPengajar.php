<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use App\Models\User;
use Carbon\Carbon;
// Pastikan ada Notification (optional, jika pakai notification Laravel)
// use App\Notifications\JadwalPengajarNotification;

class KirimNotifikasiJadwalPengajar extends Command
{
    protected $signature = 'jadwal:kirim-notifikasi';
    protected $description = 'Mengirim notifikasi ke pengajar 30 menit sebelum jadwal mengajar.';

    public function handle()
    {
        $now = Carbon::now();
        $today = ucfirst(strtolower($now->locale('id')->isoFormat('dddd')));
        $jadwals = Jadwal::where('hari', $today)->get();

        foreach ($jadwals as $jadwal) {
            // Pecah jam dari DB (format 'HH:MM')
            $jamParts = explode(':', $jadwal->jam_mulai);
            $jam = $jamParts[0] ?? '00';
            $menit = $jamParts[1] ?? '00';
            $jadwalTime = Carbon::now()->setTime($jam, $menit, 0);

            $diff = $jadwalTime->diffInMinutes($now, false);

            // Cek 0 <= diff <= 30 menit sebelum jadwal
            if ($diff >= 0 && $diff <= 30) {
                // Ambil pengajar (relasi harus benar di model Jadwal.php)
                $pengajar = $jadwal->pengajar; // pastikan relasi belongsTo ada di model

                if ($pengajar) {
                    // Kirim notifikasi, contoh: Email, Database, dsb.
                    // (Contoh menggunakan notification Laravel, bisa juga pake log)
                    // $pengajar->notify(new JadwalPengajarNotification($jadwal));
                    $this->info("Notifikasi dikirim ke: " . $pengajar->name . " untuk kegiatan: " . $jadwal->nama_kegiatan . " jam " . $jadwal->jam_mulai);

                    // Atau, jika belum implementasi notification, pakai log/info saja
                }
            }
        }
        return 0;
    }
}
