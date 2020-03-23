@extends('templates.bookTem')

@section('BookName')
    {{$book->name}}
    <form method="post" action="/api/v1/book/{{ $book->bid }}">
        <input type="hidden" name="_method" value="delete">
        <a href="/api/v1/books/edit/{{$book->id}}"><img src="http://bookshop/image/update.png" alt="Редактировать" width="20px"></a>
        <input type="submit" class="bt_del" value="" />
        {{csrf_field()}}
    </form>
@endsection

@section('BookWritter') {{$wrName}} @endsection

@section('BookYear') {{$book->year}} @endsection

@section('BookPrice') {{$book->price}} @endsection
