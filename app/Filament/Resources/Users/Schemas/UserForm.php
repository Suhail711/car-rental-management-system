<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('name')
                    ->label('الاسم الكامل')
                    ->required()
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('phone_number')
                    ->label('رقم الهاتف')
                    ->tel()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),

                \Filament\Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('id_card_number')
                    ->label('رقم الهوية الوطنية/الإقامة')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),

                \Filament\Forms\Components\Select::make('type')
                    ->label('نوع الحساب')
                    ->options([
                        'customer' => 'عميل',
                        'employee' => 'موظف',
                        'manager' => 'مدير',
                    ])
                    ->default('customer')
                    ->required(),

                \Filament\Forms\Components\FileUpload::make('id_card_image')
                    ->label('صورة الهوية الوطنية')
                    ->image()
                    ->directory('users-id-cards'),

                \Filament\Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->maxLength(255),
            ]);
    }
}
