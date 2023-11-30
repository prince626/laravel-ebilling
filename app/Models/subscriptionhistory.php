<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscriptionhistory extends Model
{
    use HasFactory;
    public $timestamps = false;
    // protected $primaryKey = 'kit';
    protected $primaryKey = 'sno';
    protected $fillable = [
        'user_id',
        'subs_id',
        'email',
        'phone',
        'subscriptionType',
        'software',
        'business_Category',
        'planInfo',
        'subscriptionStatus',
        'duration',
        'durationType',
        'paymentStatus',
        'amount',
        'startDate',
        'expiryDate',
        'addons',
    ];
}
