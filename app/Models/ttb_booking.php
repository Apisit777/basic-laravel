<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ttb_booking extends Model
{
    // use HasFactory;

    protected $guarded = [];

    protected $table = 'ttb_booking';

    public $primarykey = 'id';
    
    public $timestamps = true;
}
