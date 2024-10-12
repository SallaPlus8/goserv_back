<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = ['method_name', 'description'];

    // العلاقة مع جدول العروض (Fixed Discount Offer)
    public function fixedDiscountOffers()
    {
        return $this->hasMany(FixedDiscountOffer::class, 'payment_method_id');
    }
}
