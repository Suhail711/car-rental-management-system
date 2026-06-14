<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    // هذا السطر يفك الحماية عن كافة الأعمدة ويسمح بحفظ البيانات دون مشاكل
    protected $guarded = [];

    public function bookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Booking::class);
    }
}