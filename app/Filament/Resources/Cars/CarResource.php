<?php

namespace App\Filament\Resources\Cars;

use App\Filament\Resources\Cars\Pages;
use App\Models\Car;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Forms; // استدعاء كلاس المكونات الموحد والآمن

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-truck'; 
    
    protected static ?string $navigationLabel = 'السيارات';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // كتابة الحقول مباشرة لتجنب أي كلاس مفقود في إصدارك
                \Filament\Forms\Components\TextInput::make('model')
                    ->label('موديل/اسم السيارة')
                    ->required()
                    ->maxLength(255),

                \Filament\Forms\Components\TextInput::make('car_number')
                    ->label('رقم اللوحة')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),

                \Filament\Forms\Components\TextInput::make('price')
                    ->label('سعر الإيجار اليومي')
                    ->numeric()
                    ->required()
                    ->prefix('$'),

                \Filament\Forms\Components\Select::make('state')
                    ->label('حالة السيارة')
                    ->options([
                        'available' => 'متاحة',
                        'rented' => 'مؤجرة',
                        'maintenance' => 'في الصيانة',
                    ])
                    ->default('available')
                    ->required(),

                \Filament\Forms\Components\FileUpload::make('photo')
                    ->label('صورة السيارة')
                    ->image()
                    ->directory('cars-photos'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('الصورة')
                    ->circular(),

                Tables\Columns\TextColumn::make('model')
                    ->label('الموديل')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('car_number')
                    ->label('رقم اللوحة')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('السعر اليومي')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('state')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'rented' => 'warning',
                        'maintenance' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'available' => 'متاحة',
                        'rented' => 'مؤجرة',
                        'maintenance' => 'في الصيانة',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('state')
                    ->label('تصفية حسب الحالة')
                    ->options([
                        'available' => 'متاحة',
                        'rented' => 'مؤجرة',
                        'maintenance' => 'في الصيانة',
                    ]),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}