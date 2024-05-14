<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('employee.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('client_name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('client_phone')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('price')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('service.duration')
                    ->label('Duration')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('slot.date')
                    ->label('Date')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('slot.start_time')
                    ->label('Time')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('service.name')
                    ->label('Service')
                    ->options(Service::pluck('name', 'name')->toArray()),
                Tables\Filters\SelectFilter::make('employee.name')
                    ->label('Employee')
                    ->options(Employee::pluck('name', 'name')->toArray()),

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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
