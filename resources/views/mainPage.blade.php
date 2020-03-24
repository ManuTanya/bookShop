@extends('templates.mainTem')

@section('menu')
    @if(Auth::check())
        <p> Добро пожаловать, {{Auth::user()->name}}</p>
        <a href="/logout" class="admin"> Выйти</a>
        @if(Auth::user()->entitlement=="admin")
            <a href="/admin" class="admin"> Административная часть</a>
        @endif
    @else
        <a href="/login" class="admin"> Войти</a>
        <a href="/register" class="admin"> Регистрация</a>
    @endif
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
