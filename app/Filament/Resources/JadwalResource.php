<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Jadwal;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use App\Filament\Resources\JadwalResource\Pages;
use App\Models\User;


class JadwalResource extends Resource
{
    protected static ?string $navigationLabel = 'Jadwal';
    protected static ?string $modelLabel = 'Jadwal';           // Label tunggal
    protected static ?string $pluralModelLabel = 'Jadwal';     // Label jamak

    protected static ?string $model = Jadwal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Select::make('pengajar_id')
                ->label('Pengajar')
                ->options(
                User::where('role', 'pengajar')->pluck('name', 'id')
                )
                ->searchable()
                ->nullable()
                ->preload(),
                TextInput::make('nama_kegiatan')->label('Nama Kegiatan')->required(),
                Select::make('hari')
                    ->label('Hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                        'Sabtu' => 'Sabtu',
                        'Minggu' => 'Minggu',
                    ])
                    ->required(),
                TimePicker::make('jam_mulai')->label('Jam Mulai')->required(),
                TimePicker::make('jam_selesai')->label('Jam Selesai')->required(),
                TextInput::make('tempat')->label('Tempat'),
                Textarea::make('keterangan')->label('Keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pengajar.name')
            ->label('Pengajar')
            ->sortable()
            ->searchable(),
                TextColumn::make('nama_kegiatan')->label('Nama Kegiatan'),
                TextColumn::make('hari')->label('Hari'),
                TextColumn::make('jam_mulai')->label('Jam Mulai'),
                TextColumn::make('jam_selesai')->label('Jam Selesai'),
                TextColumn::make('tempat')->label('Tempat'),
                TextColumn::make('keterangan')->label('Keterangan')->limit(30),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJadwals::route('/'),
            'create' => Pages\CreateJadwal::route('/create'),
            'edit' => Pages\EditJadwal::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()->role === 'admin' || auth()->user()->role === 'pengajar';
    }
    // public static function canDelete(): bool
    // {
    //     return auth()->user()->role === 'admin' || auth()->user()->role === 'pengajar';
    // }
    // public static function canEdit(): bool
    // {
    //     return auth()->user()->role === 'admin' || auth()->user()->role === 'pengajar';
    // }
}
