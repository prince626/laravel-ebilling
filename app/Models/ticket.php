<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'sno';
    protected $fillable = [
        'ticketId',
        'user_id',
        'email',
        'phone',
        'software_name',
        'status',
    ];
}
