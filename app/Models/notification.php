<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'sno';
    protected $fillable = [
        'messageType',
        'user_id', // Add 'user_id' to the fillable array
        'email',
        'message',
        'type',
    ];
}
