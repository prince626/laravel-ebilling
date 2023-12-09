<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logaction extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'sno';

    protected $fillable = [
        'user_id',
        'action_type',
        'action_performed',
        'ip_address',
        'user_agent',
        'status',
    ];
}
