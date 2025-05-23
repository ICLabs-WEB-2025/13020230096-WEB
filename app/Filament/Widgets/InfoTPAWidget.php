<?php
namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Jadwal;
use Carbon\Carbon;

class InfoTPAWidget extends Widget
{
    protected static ?string $maxWidth = null;
    protected static string $view = 'filament.widgets.info-t-p-a-widget';

    protected function getViewData(): array
    {
        $deskripsi = "TPA Al-Furqan adalah lembaga pendidikan ...";
        $kegiatan = [
            'Belajar mengaji Al-Quran',
            'Doa-doa harian',
            'Sholat berjamaah',
            'Kegiatan outbond islami',
        ];
        $materi = [
            'Iqro & Al-Quran',
            'Tajwid dasar',
            'Hafalan doa & surat pendek',
            'Fiqih dasar anak',
        ];
        $jadwal = Jadwal::with('pengajar')->get();

        // Inisialisasi array kosong untuk multi jadwal notifikasi
        $jadwalToNotify = [];

        if (auth()->user()?->role === 'pengajar') {
            $today = ucfirst(strtolower(Carbon::now()->locale('id')->isoFormat('dddd')));
            $now = Carbon::now();
            $jadwals = Jadwal::where('pengajar_id', auth()->id())
                ->where('hari', $today)
                ->get();

            foreach ($jadwals as $j) {
                // Flexible handle jam: bisa "17:13" atau "17:13:14"
                $jamParts = explode(':', $j->jam_mulai);
                $jam = $jamParts[0] ?? '00';
                $menit = $jamParts[1] ?? '00';
                $jadwalTime = Carbon::now()->setTime($jam, $menit, 0);
                $diff = $jadwalTime->diffInMinutes($now, false);

                if ($diff >= 0 && $diff <= 30) {
                    $jadwalToNotify[] = [
                        'nama_kegiatan' => $j->nama_kegiatan,
                        'jam_mulai' => $j->jam_mulai,
                    ];
                }
            }
        }

        // Return semua variabel yang dibutuhkan di blade
        return compact('deskripsi', 'kegiatan', 'materi', 'jadwal', 'jadwalToNotify');
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
