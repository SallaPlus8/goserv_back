<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialCartDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'discount_percentage',
        'discount_amount',
        'end_time',
        'status',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function isValid()
    {
        $now = now();

        return $this->status == 'active' &&
               ($this->end_time === null || $this->end_time >= $now);
    }
}
