@extends('templates.mainTem')

@yield('content')

@section('menu')
    <a href="/admin" class="admin"> Административная часть</a>
    <a href="/admin" class="admin"> Публичная часть</a>
@endsection

@section('content')
    @yield('StartForm')
    <p class="table_tittle"> Писатель:</p>
    <ul class="sp_writters_show_edit">
        <li>
            <b>Имя:</b> @yield('WritterName')
        </li>
        @yield('WritterBooks')
    </ul>
    @yield('EndForm')
@endsection
