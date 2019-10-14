<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    //
    protected $table = 'weather';
    public $timestamps = true;
    protected $fillable = ['temp_c','temp_f','humidity'];
}
