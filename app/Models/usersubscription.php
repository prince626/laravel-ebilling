<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersubscription extends Model
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
        'business_Category',
        'planInfo',
        'software',
        'subscriptionStatus',
        'Duration',
        'durationType',
        'kit',
        'amount',
        'paymentStatus',
        'activationStatus',
        'startDate',
        'expiryDate',
        'accept',
    ];
}
