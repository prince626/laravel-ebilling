<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cancelsubscription extends Model
{
    use HasFactory;

    public $timestamps = false;
    // protected $primaryKey = 'kit';
    protected $primaryKey = 'sno';
    protected $fillable = [
        'subs_id',
        'user_id',
        'email',
        'phone',
        'cancelationReason',
        'cancelationDate',
        'subscriptionType',
        'software',
        'planInfo',
        'Duration',
        'amount',
        'refundAmount',
        'refundStatus',
    ];
}
