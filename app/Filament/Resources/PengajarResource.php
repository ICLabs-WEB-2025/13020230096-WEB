<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PengajarResource\Pages;


class PengajarResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Pengajar';
    protected static ?string $modelLabel = 'Pengajar';           // Label tunggal
    protected static ?string $pluralModelLabel = 'Pengajar';     // Label jamak
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap'; // (opsional, bisa pakai icon lain)

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'pengajar');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nama')->required(),
                TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => \Hash::make($state))
                ->required(fn ($record) => $record === null),
                // Role di-set otomatis jadi pengajar
                Hidden::make('role')->default('pengajar'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama'),
                TextColumn::make('email'),
                // Bisa tambahkan kolom lainnya jika perlu
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

  public static function canViewForNavigation(): bool
{
    return auth()->user()?->role === 'admin';
}



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengajars::route('/'),
            'create' => Pages\CreatePengajar::route('/create'),
            'edit' => Pages\EditPengajar::route('/{record}/edit'),
        ];
    }
}