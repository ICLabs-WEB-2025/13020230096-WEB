<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Scheduling\Schedule;

// Command artisan bawaan Laravel
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Tambahkan scheduler di bawah ini
// app(Schedule::class)
//     ->command('jadwal:kirim-notifikasi') // Pastikan nama command-mu benar!
//     ->everyMinute();
