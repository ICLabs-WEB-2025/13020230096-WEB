<?php
namespace App\Filament\Pages;

use App\Filament\Resources\JadwalResource;
use App\Filament\Widgets\InfoTPAWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use App\Models\Jadwal;


class Dashboard extends BaseDashboard
{
    protected static ?array $widgets= [
        InfoTPAWidget::class,
    ];

}
