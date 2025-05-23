<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwals'; // pastikan sama dengan nama tabel migration

    // Field yang boleh diisi mass-assignment
    protected $fillable = [
        'pengajar_id',
        'nama_kegiatan',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'tempat',
        'keterangan',
    ];

    // Jika ingin relasi ke User (misal pengajar_id), tambahkan di sini
    public function pengajar()
    {
        return $this->belongsTo(User::class, 'pengajar_id');
    }
}
