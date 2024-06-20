<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlotResource\Pages;
use App\Filament\Resources\SlotResource\RelationManagers;
use App\Models\Slot;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SlotResource extends Resource
{
    protected static ?string $model = Slot::class;
    protected static ?string $navigationGroup = 'Employees';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup(Group::make('schedule.employee.name')->label('Employee'))
            ->columns([
                TextColumn::make('order_id')
                    ->label('Order Id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->sortable()
                    ->searchable(),
                ColumnGroup::make('Slot', [
                    TextColumn::make('start_time')
                        ->label('From')
                        ->sortable()
                        ->searchable(),
                    TextColumn::make('end_time')
                        ->label('To')
                        ->sortable()
                        ->searchable(),
                    TextColumn::make('duration')
                        ->label('Duration')
                        ->sortable()
                        ->searchable(),
                ])->alignCenter(),
            ])
            ->filters([
                Filter::make('date')
                    ->label('Date')
                    ->form([
                        DatePicker::make('date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('date', '=', $date),
                            );
                    }),
                Filter::make('start_time')
                    ->label('Start time')
                    ->form([
                        DatePicker::make('start_time'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_time'],
                                fn(Builder $query, $date): Builder => $query->where('start_time', '=', $date),
                            );
                    }),
            ])
            ->actions([

            ])
            ->bulkActions([

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
            'index' => Pages\ListSlots::route('/'),
        ];
    }
}
