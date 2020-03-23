<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Writter;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class WorkDataController extends Controller
{
    function showWritter($wid,Request $r)
    {
        $fSortName='';
        $wr=Writter::find($wid);
        if(count($r->query()) == 0)  $rezult = DB::select("select * from book where (writter_id=?) order by name", [$wr->id]);
        else
        {
            if($r->has("data")) $data=explode(",",str_replace(['{','}','[',']','"'," "],[],$r->input("data")));
            else $data='*';
            $rezult = Book::select($data)->where("writter_id",$wid);
            if($r->has("filter"))
            {
                $filter=explode("],[",$r->input("filter"));
                for ($i=0;$i<count($filter);$i++)
                {
                    $filter[$i]=explode(",",str_replace(['[',']','"'," "],[],$filter[$i]));
                    $rezult=$rezult->where($filter[$i][0],$filter[$i][1],$filter[$i][2]);
                }
            }
            if($r->has("sort"))
            {
                $order_by=explode(":",str_replace(['{','}','[',']','"'," "],[],$r->input("sort")));
                if($order_by[0]=='name') $fSortName=$order_by[1];
                else $rezult=$rezult->orderBy($order_by[0],$order_by[1]);
            }
            $rezult=$rezult->get();
        }
        $file = Storage::disk('public')->get("json/list_book.json");
        $array=json_decode($file,true);
        $array[$wid]=
        [
            'id' => $wid,
            'writter_name' => $wr->name,
            'books' =>[]
        ];
        for($i=0;$i<count($rezult);$i++)
        {
            if(isset($rezult[$i]->id)) $array[$wid]['books'][$i]['id']=$rezult[$i]->id;
            if(isset($rezult[$i]->name)) $array[$wid]['books'][$i]['book_name']=$rezult[$i]->name;
            if(isset($rezult[$i]->year)) $array[$wid]['books'][$i]['year']=$rezult[$i]->year;
            if(isset($rezult[$i]->price)) $array[$wid]['books'][$i]['price']=$rezult[$i]->price;
        }
        if(isset($rezult[0]->name) && ($fSortName!='')) $array[$wid]['books']=WorkDataController::sortName($array[$wid]['books'],$fSortName);
        Storage::disk('public')->put("json/list_book.json",json_encode($array,JSON_UNESCAPED_UNICODE));
        dump($array[$wid]);
    }

    function sortName($ar,$fsort)
    {
        $dop_array=[];
        $i=0;
        foreach ($ar as $record)
        {
            $dop_array[WorkDataController::tr($record["book_name"])]=$record["book_name"];
            $i++;
        }
        if(mb_strtolower($fsort)=='asc') ksort($dop_array);
        if(mb_strtolower($fsort)=='desc') krsort($dop_array);
        $ret_array=[];
        $j=0;
        foreach ($dop_array as $key=>$value)
            for($i=0;$i<count($ar);$i++)
                if($ar[$i]['book_name']==$value)
                {
                    $ret_array[$j]=$ar[$i];
                    $j++;
                    break;
                }
        //dump($ret_array);
        return $ret_array;
    }

    function tr($str)
    {
        $str = (string) $str;
        $str = trim($str);
        $str=mb_strtolower($str);
        $str = strtr($str, array('а'=>'a','б'=>'b','в'=>'c','г'=>'d','д'=>'e','е'=>'fa','ё'=>'fb','ж'=>'g','з'=>'h','и'=>'ia','й'=>'ib','к'=>'j','л'=>'k','м'=>'l','н'=>'m','о'=>'n','п'=>'o','р'=>'p','с'=>'q','т'=>'r','у'=>'s','ф'=>'t','х'=>'u','ц'=>'va','ч'=>'vb','ш'=>'wa','щ'=>'wb','ы'=>'xa','э'=>'ya','ю'=>'yb','я'=>'z','ъ'=>'xb','ь'=>'xc'));
        return $str;
    }

    function newWritter()
    {
        return view('writterPageNew');
    }

    function  editWritter($wid)
    {
        $wr=Writter::find($wid);
        return view('writterPageEdit')->with(['writter'=>$wr]);
    }

    function saveDataWritter($wid,Request $rec)
    {
        $this->validate($rec, [
            'WName' => 'required'
        ]);
        $data=$rec->all();
        if($wid==0) //добавление
        {
            DB::insert('insert into writter(name) values(?)',[$data['WName']]);
        } else //редактирование
        {
            DB::update('update writter set name=? where id=?',[$data['WName'], $wid]);
        }
        return redirect('/admin');
    }

    function deleteWritter($wid)
    {
        DB::delete('delete from Writter where id=?',[$wid]);
        return redirect('/admin');
    }

    function showBook($bid,Request $r)
    {
        if(count($r->query()) == 0)
        {
            $bk=Book::find($bid);
            $wr=Writter::find($bk->writter_id);
        }
        else
        {
            $wid=Book::find($bid)->writter_id;
            $dataW="";
            if($r->has("data"))
            {
                $data=explode(",",str_replace(['{','}','[',']','"'," "],[],$r->input("data")));
                foreach($data as $key=>$value) if ($value == "writterName")
                {
                    $dataW="name";
                    unset($data[$key]);
                }
            }
            else
            {
                $data='*';
                $dataW='*';
            }
            $bk=Book::select($data)->where('id',$bid)->first();
            if($dataW=="") $wr=[];
            else $wr=Writter::select($dataW)->where('id',$wid)->first();
        }

        $file = Storage::disk('public')->get("json/bookById.json");
        $array=json_decode($file,true);
        $array[$bid]=[];
        if(isset($bk->id)) $array[$bid]['id']=$bid;
        if(isset($bk->name)) $array[$bid]['name']=$bk->name;
        if(isset($bk->writter_id)) $array[$bid]['writterId']=$bk->writter_id;
        if(isset($wr->name)) $array[$bid]['writterName']=$wr->name;
        if(isset($bk->year)) $array[$bid]['year']=$bk->year;
        if(isset($bk->price)) $array[$bid]['price']=$bk->price;
        Storage::disk('public')->put("json/bookById.json",json_encode($array,JSON_UNESCAPED_UNICODE));
        dump($array[$bid]);
        //return view('bookPage')->with(['book'=>$bk,'wrName'=>$wr->name]);
    }

    function newBook()
    {
        $wr=Writter::all();
        return view('bookPageNew')->with(['writters'=>$wr]);
    }

    function  editBook($bid)
    {
        $bk=Book::find($bid);
        $wr=Writter::all();
        //dd($bk);
        return view('bookPageEdit')->with(['book'=>$bk,'writters'=>$wr]);
    }

    function saveDataBook($bid,Request $r)
    {
        $data=$r->json()->all();
        $file = Storage::disk('public')->get("json/updateBook.json");
        $bk=Book::find($bid);
        $array=json_decode($file,true);
        $array[$bid]["before"]=
        [
            'name'=>$bk->name,
            'writter_id'=>$bk->writter_id,
            'year'=>$bk->year,
            'price'=>$bk->price
        ];
        $array[$bid]["after"]=
        [
            'name'=>$data["name"],
            'writter_id'=>$data["writter_id"],
            'year'=>$data["year"],
            'price'=>$data["price"]
        ];
        DB::update('update book set name=?,writter_id=?,year=?,price=? where id=?',[$data["name"],$data["writter_id"],$data["year"],$data["price"],$bid]);
        Storage::disk('public')->put("json/updateBook.json",json_encode($array,JSON_UNESCAPED_UNICODE));
        dump($array[$bid]);

//        $this->validate($r, [
//            'name' => 'required',
//            'year' => 'required | ',
//            'price' => 'required | numeric',
//            'writter_id' => 'required | integer'
//        ]);

        //dump($data);

//        if($bid==0) //добавление
//        {
//            DB::insert('insert into book(name,writter_id,year,price) values(?,?,?,?)',[$data['name'],$data['writter_id'],$data['year'],$data['price']]);
//            return redirect('/admin');
//        } else //редактирование
//        {
//            $bk=Book::find($bid);
//            $wr=Writter::find($bk->writter_id);
//            $array=
//                [
//                    'id' => $bid,
//                    'book_name' => $bk->name,
//                    'writter_name' => $wr->name,
//                    'year' => $bk->year,
//                    'price' => $bk->price
//                ];
//            dump($array);
//            $wr=Writter::find($data['writter_id']);
//            DB::update('update book set name=?,writter_id=?,year=?,price=? where id=?',[$data['name'],$data['writter_id'],$data['year'],$data['price'],$bid]);
//            $bk=Book::find($bid);
//            $wr=Writter::find($bk->writter_id);
//            $array['book_name']=$bk->name;
//            $array['writter_name']=$wr->name;
//            $array['year']=$bk->year;
//            $array['price']=$bk->price;
//            dump($array);
//        }

    }

    function deleteBook($bid)
    {
        $bks=Book::all();
        $file = Storage::disk('public')->get("json/deleteBook.json");
        $array=json_decode($file,true);
        $array[$bid]=
        [
            "id"=>$bid,
            "result"=>true
        ];
        DB::delete('delete from Book where id=?',[$bid]);
        Storage::disk('public')->put("json/deleteBook.json",json_encode($array,JSON_UNESCAPED_UNICODE));
        dump($array[$bid]);
        //return redirect('/admin');
    }
}
