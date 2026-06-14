<?php

namespace App\Filament\Resources\Bookings\Schemas;

use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('العميل'),

                \Filament\Forms\Components\Select::make('car_id')
                    ->relationship('car', 'model')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->model} - ({$record->car_number}) - [\${$record->price}/يوم]")
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('السيارة'),

                \Filament\Forms\Components\DatePicker::make('pickup_date')
                    ->required()
                    ->native(false)
                    ->displayFormat('Y-m-d')
                    ->label('تاريخ الاستلام'),

                \Filament\Forms\Components\DatePicker::make('return_date')
                    ->required()
                    ->native(false)
                    ->displayFormat('Y-m-d')
                    ->afterOrEqual('pickup_date')
                    ->label('تاريخ الإرجاع'),

                \Filament\Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->prefix('$')
                    ->label('السعر الإجمالي')
                    ->helperText('يتم احتسابه تلقائياً بناءً على سعر السيارة وعدد أيام الإيجار إذا تُرك فارغاً.'),

                \Filament\Forms\Components\Select::make('state')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'approved' => 'مقبول',
                        'rejected' => 'مرفوض',
                        'completed' => 'مكتمل',
                    ])
                    ->default('pending')
                    ->required()
                    ->label('حالة الحجز'),
            ]);
    }
}
