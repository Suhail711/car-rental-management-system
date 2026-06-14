<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم الكامل')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label('رقم الهاتف')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('id_card_number')
                    ->label('رقم الهوية/الإقامة')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('نوع الحساب')
                    ->badge()
                    ->color(fn (string $type): string => match ($type) {
                        'manager' => 'danger',
                        'employee' => 'warning',
                        'customer' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $type): string => match ($type) {
                        'manager' => 'مدير',
                        'employee' => 'موظف',
                        'customer' => 'عميل',
                        default => $type,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('تصفية حسب نوع الحساب')
                    ->options([
                        'manager' => 'مدير',
                        'employee' => 'موظف',
                        'customer' => 'عميل',
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
