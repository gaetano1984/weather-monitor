<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Model\Weather;

class weather extends Controller
{
    //
    
    public function saveStats($temp_c, $temp_f, $humidity){
    	$w = new Weather();
    	$w->temp_f = $temp_f;
    	$w->temp_c = $temp_c;
    	$w->humidity = $humidity;
    	$w->save();
    }
}
