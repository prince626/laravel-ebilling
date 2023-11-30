<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoicereceipts extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'sno';

    protected $fillable = [
        'receipt_no',
        'invoice_number',
        'user_id',
        'subs_id',
        'email',
        'phone',
        'software',
        'planInfo',
        'paid_amount',
        'paymentStatus',
        'payment_method',
        'cardExpiryDate',
        'cvvcvc',
        'holder_name',
        'payment_id',
        'payment_date',
        'invoice_date',
        'due_date'
    ];
}
