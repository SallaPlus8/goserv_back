<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferType extends Model
{
    use HasFactory;

    protected $table = 'offer_types';

    // Define the relationship with SpecialOffer
    public function specialOffers()
    {
        return $this->hasMany(SpecialOffer::class, 'offer_type_id');
    }
}
