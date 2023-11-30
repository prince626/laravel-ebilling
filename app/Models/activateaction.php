<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activateaction extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'sno';
    protected $fillable = [
        'user_id',
        'subs_id',
        'user_email',
        'user_phone',
        'planInfo',
        'action',
    ];
}
