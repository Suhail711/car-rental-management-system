<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. إنشاء المستخدمين
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'المدير العام',
                'phone_number' => '0500000000',
                'id_card_number' => '1000000000',
                'type' => 'manager',
                'password' => Hash::make('password'),
            ]
        );

        $customer = User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'أحمد العتيبي',
                'phone_number' => '0511111111',
                'id_card_number' => '2000000000',
                'type' => 'customer',
                'password' => Hash::make('password'),
            ]
        );

        // 2. إنشاء السيارات
        $car1 = Car::updateOrCreate(
            ['car_number' => 'أ ب ج 1234'],
            [
                'model' => 'بي إم دبليو الفئة الخامسة',
                'price' => 120,
                'photo' => 'cars-photos/bmw.png',
                'state' => 'available',
            ]
        );

        $car2 = Car::updateOrCreate(
            ['car_number' => 'د هـ و 5678'],
            [
                'model' => 'تسلا موديل Y',
                'price' => 150,
                'photo' => 'cars-photos/tesla.png',
                'state' => 'available',
            ]
        );

        $car3 = Car::updateOrCreate(
            ['car_number' => 'س ص ع 9012'],
            [
                'model' => 'بورش 911',
                'price' => 450,
                'photo' => 'cars-photos/porsche.png',
                'state' => 'available',
            ]
        );

        $car4 = Car::updateOrCreate(
            ['car_number' => 'ر ز س 3456'],
            [
                'model' => 'رنج روفر فوج',
                'price' => 280,
                'photo' => 'cars-photos/rover.png',
                'state' => 'rented',
            ]
        );

        // 3. إنشاء حجز تجريبي
        Booking::create([
            'user_id' => $customer->id,
            'car_id' => $car4->id,
            'pickup_date' => Carbon::now()->format('Y-m-d'),
            'return_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
            'state' => 'approved',
        ]);
    }
}
