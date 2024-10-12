<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    use HasFactory;

    protected $table = 'specialoffer';

    protected $fillable = ['offer_title', 'offer_platform', 'offer_start_date', 'offer_end_date', 'offer_type_id'];

    // Define the relationship with OfferType
    public function offerType()
    {
        return $this->belongsTo(OfferType::class, 'offer_type_id');
    }
}
