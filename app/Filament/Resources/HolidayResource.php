<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HolidayResource\Pages;
use App\Filament\Resources\HolidayResource\RelationManagers;
use App\Models\Employee;
use App\Models\Holiday;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;
    protected static ?string $navigationGroup = 'Employees';
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('schedule_id')
                    ->label('Employee')
                    ->options(Employee::pluck('name', 'id')->toArray()),
                DatePicker::make('start_date')
                    ->label('Start date')
                    ->native(false)
                    ->format('d-m-Y')
                    ->displayFormat('d-m-Y')
                    ->weekStartsOnMonday()
                    ->closeOnDateSelection()
                    ->minDate(now()),
                DatePicker::make('end_date')
                    ->label('End date')
                    ->native(false)
                    ->format('d-m-Y')
                    ->displayFormat('d-m-Y')
                    ->weekStartsOnMonday()
                    ->closeOnDateSelection()
                    ->minDate(now()->addDay())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup(Group::make('schedule.employee.name')->label('Employee'))
            ->columns([
                TextColumn::make('schedule.employee.name')
                    ->label('Employee')
                    ->sortable()
                    ->searchable(),
                ColumnGroup::make('Dates', [
                    TextColumn::make('start_date')
                        ->label('From')
                        ->sortable()
                        ->searchable(),
                    TextColumn::make('end_date')
                        ->label('To')
                        ->sortable()
                        ->searchable(),
                ])->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('schedule_id')
                    ->label('Employee')
                    ->options(Employee::pluck('name', 'id')->toArray()),
                Filter::make('start_date')
                    ->label('Start date')
                    ->form([
                        DatePicker::make('start_date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            );
                    }),
                Filter::make('end_date')
                    ->label('End date')
                    ->form([
                        DatePicker::make('end_date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['end_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('end_date', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
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
            'index' => Pages\ListHolidays::route('/'),
            'create' => Pages\CreateHoliday::route('/create'),
            'edit' => Pages\EditHoliday::route('/{record}/edit'),
        ];
    }
}
