<?php

namespace App\Filament\Resources\Bookings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('رقم الحجز')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('car.model')
                    ->label('السيارة')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pickup_date')
                    ->label('تاريخ الاستلام')
                    ->date('Y-m-d')
                    ->sortable(),

                Tables\Columns\TextColumn::make('return_date')
                    ->label('تاريخ الإرجاع')
                    ->date('Y-m-d')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('المبلغ الإجمالي')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('state')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'info',
                        'completed' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد الانتظار',
                        'approved' => 'مقبول',
                        'completed' => 'مكتمل',
                        'rejected' => 'مرفوض',
                        default => $state,
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->label('تصفية حسب الحالة')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'approved' => 'مقبول',
                        'completed' => 'مكتمل',
                        'rejected' => 'مرفوض',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
