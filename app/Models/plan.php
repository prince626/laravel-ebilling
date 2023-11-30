<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class plan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'sno';

    protected $fillable = [
        'id',
        'businessCategory',
        'plan',
        'amount',
        'duration',
        'addons',
    ];
}
