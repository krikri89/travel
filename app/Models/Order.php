<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel as H;
use App\Models\User as U;

class Order extends Model
{
    use HasFactory;

    const STATUSES = [

        1 => 'New',
        2 => 'Confirmed',
        3 => 'Canceled',
        4 => 'Done'

    ];

    public function cartConnectHotel()
    {
        return $this->belongsTo(H::class, 'hotel_id', 'id');
    }
    public function cartConnectUser()
    {
        return $this->belongsTo(U::class, 'user_id', 'id');
    }
}
