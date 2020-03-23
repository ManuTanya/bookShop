@extends('templates.mainTem')

@section('menu')
    <a href="/admin" class="admin"> Административная часть</a>
@endsection

@section('content')
    <p class="table_tittle">Писатели и книги:</p>
    <ol class="sp_writters">@foreach($writters as $writter)
        <li>
            {{$writter->name}} <br>
            <ul>
                @foreach($books[$writter->name] as $book)
                    <li>
                        {{$book->name}}({{$book->year}}) - {{$book->price}} р.
                    </li>
                @endforeach
            </ul>
        </li>
    @endforeach</ol>
@endsection
