<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyGetOffer extends Model
{
    use HasFactory;

    protected $table = 'buy_get_offer';

    protected $fillable = ['product_x_id', 'product_y_id', 'quantity_x', 'quantity_y','discount_type', 'discount_value', 'offer_message'];

    // العلاقة مع المنتج X
    public function productX()
    {
        return $this->belongsTo(Product::class, 'product_x_id');
    }

    // العلاقة مع المنتج Y
    public function productY()
    {
        return $this->belongsTo(Product::class, 'product_y_id');
    }

    public function specialOffer()
    {
        return $this->hasOne(SpecialOffer::class, 'buy_get_offer_id'); // المفتاح الأجنبي من جدول SpecialOffer
    }
}
