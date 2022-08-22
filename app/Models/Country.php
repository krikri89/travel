<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel as H;

class Country extends Model
{
    use HasFactory;
    public function countryHasManyHotels()
    {
        return $this->hasMany(H::class, 'country_id', 'id');
    }
}
