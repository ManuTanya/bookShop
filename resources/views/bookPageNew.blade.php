@extends('templates.bookTem')

@section('StartForm')
    <form method="Post" action="http://bookshop/api/v1/books/update/0">
        @endsection

@section('BookName')
    <input type="text" class="form_edit" name="BName" value="">
@endsection

@section('BookWritter')
    <select name="WId" class="select_Wr">
        <option value="" selected> [Выберите автора] </option>
        @foreach($writters as $writter)
            <option value="{{$writter->id}}"> {{$writter->name}} </option>
        @endforeach
    </select>
@endsection

@section('BookYear') <input type="text" class="form_edit" name="BYear" value=""> @endsection

@section('BookPrice') <input type="text" class="form_edit" name="BPrice" value=""> @endsection

@section('EndForm')
    {{csrf_field()}}
    <input type="submit" value="Сохранить" class="bt_save">
    </form>
@endsection
