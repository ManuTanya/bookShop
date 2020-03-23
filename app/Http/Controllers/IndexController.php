<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function myMetod()
    {
        $message1='Tanya!!';
        $message2='Hello!!';
        return view('page')->with(['p1'=>$message1,'p2'=>$message2]);
    }
}
