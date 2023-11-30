<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticketmessage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'message_id',
        'ticketId',
        'adminId',
        'type',
        'message',
        'status',
    ];
}
