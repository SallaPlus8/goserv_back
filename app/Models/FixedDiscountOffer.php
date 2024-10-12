<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedDiscountOffer extends Model
{
    use HasFactory;

    protected $table = 'fixed_discount_offer';

    protected $fillable = [
        'discount_value', 
        'apply_to', 
        'min_quantity', 
        'min_purchase_amount', 
        'apply_with_coupon', 
        'offer_message', 
        'product_id', 
        'category_id', 
        'payment_method_id'
    ];

    // العلاقة مع المنتجات
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // العلاقة مع التصنيفات
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // العلاقة مع طرق الدفع
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}
