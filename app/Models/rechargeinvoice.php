<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rechargeinvoice extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'sno';

    protected $fillable = [
        'invoice_number',
        'user_id',
        'subs_id',
        'email',
        'phone',
        'software',
        'planInfo',
        'amount',
        'paymentStatus',
        'invoice_date',
        'due_date'
    ];
}
