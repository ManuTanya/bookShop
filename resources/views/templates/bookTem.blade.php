@extends('templates.mainTem')

@section('menu')
    <a href="/admin" class="admin"> Административная часть</a>
    <a href="/admin" class="admin"> Публичная часть</a>
@endsection

@section('content')
    @yield('StartForm')
    <p class="table_tittle"> Книга:</p>
    <ul class="sp_writters_show_edit">
        <li>
            <b>Название:</b> @yield('BookName')
        </li>
        <li>
            <b>Писатель:</b> @yield('BookWritter')
        </li>
        <li>
            <b>Год:</b> @yield('BookYear')
        </li>
        <li>
            <b>Цена:</b> @yield('BookPrice')
        </li>
    </ul>
    @yield('EndForm')
@endsection
