<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Booking extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($booking) {
            if ($booking->car_id && $booking->pickup_date && $booking->return_date) {
                $pickup = Carbon::parse($booking->pickup_date);
                $return = Carbon::parse($booking->return_date);
                $days = $pickup->diffInDays($return);
                
                // الحد الأدنى هو يوم واحد للإيجار
                if ($days <= 0) {
                    $days = 1;
                }
                
                $car = Car::find($booking->car_id);
                if ($car && !$booking->total_price) {
                    $booking->total_price = $days * $car->price;
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
