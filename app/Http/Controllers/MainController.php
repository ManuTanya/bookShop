<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Writter;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function showMainPage()
    {
        $wr=Writter::all();
        $arrayOfWritters=array();
        foreach ($wr as $one_wr)
        {
            $rezult = DB::select("select * from book where (writter_id=?) order by name", [$one_wr->id]);
            $arrayOfWritters[$one_wr->name] = $rezult;
        }

        return view('mainPage')->with(['books'=>$arrayOfWritters,'writters'=>$wr]);

    }

    public function showAdminPage()
    {
        if((!Auth::check()) || (Auth::user()->entitlement!="admin"))
        {
            return "В доступе отказано!";
        }
        $rezult1=DB::select("select b.id as bid,w.id as wid,b.name as bname,w.name as wname,b.year,b.price from book b, writter w where (w.id=b.writter_id) order by b.name");
        $rezult2=DB::select("select w.id, w.name, count(*) as bcount from writter w,book b where (w.id=b.writter_id) group by w.id,w.name order by w.name ");
        $rezult3=DB::select("select id, name from writter where id not in (select w.id from writter w,book b where (w.id=b.writter_id))");
        //dump($rezult3);
        dump($rezult1);
        return view('adminPage')->with(['books'=>$rezult1,'writters'=>$rezult2,'otherWr'=>$rezult3]);
    }
}
