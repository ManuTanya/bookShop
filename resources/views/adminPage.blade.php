@extends('templates.mainTem')

@section('menu')
    <a href="/" class="admin"> Публичная часть</a>
    <a href="/logout" class="admin"> Выйти</a>
@endsection

@section('content')
    <p class="table_tittle"> Список книг
        <a href="/api/v1/books/new"><img src="http://bookshop/image/insert.png" alt="Добавить" width="20px"></a>
    </p>
    <table align="center" class="book_table">
        <tr class="header">
            <td>Название книги</td>
            <td>Автор</td>
            <td>Год издания</td>
            <td>Цена</td>
            <td></td>
        </tr>
        @foreach($books as $book)
            <tr>
                <td>{{ $book->bname }}</td>
                <td>{{ $book->wname }}</td>
                <td>{{ $book->year }}</td>
                <td>{{ $book->price }}</td>
                <td>
                    <form method="post" action="/api/v1/book/{{ $book->bid }}">
                        <input type="hidden" name="_method" value="delete">
                        <a href="/api/v1/books/by-id/{{ $book->bid }}"><img src="http://bookshop/image/watch.png" alt="Просмотр" width="20px"></a>
                        <a href=/api/v1/books/edit/{{ $book->bid }}"><img src="http://bookshop/image/update.png" alt="Редактировать" width="20px"></a>
                        <input type="submit" class="bt_del" value="" />
                        {{csrf_field()}}
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <br><br>
    <p class="table_tittle"> Список писателей
        <a href="/api/v1/writters/new"><img src="http://bookshop/image/insert.png" alt="Добавить" width="20px"></a>
    </p>
    <table align="center" class="book_table">
        <tr class="header">
            <td>Автор</td>
            <td>Количество книг</td>
            <td></td>
        </tr>
        @foreach($writters as $writter)
            <tr>
                <td>{{ $writter->name }}</td>
                <td>{{ $writter->bcount }}</td>
                <td>
                    <a href="/api/v1/books/list/{{ $writter->id }}"><img src="http://bookshop/image/watch.png" alt="Просмотр" width="20px"></a>
                    <a href="/api/v1/writters/edit/{{ $writter->id }}"><img src="http://bookshop/image/update.png" alt="Редактировать" width="20px"></a>
                </td>
            </tr>
        @endforeach
        @foreach($otherWr as $wr)
            <tr>
                <td>{{ $wr->name }}</td>
                <td>0</td>
                <td>
                    <form method="post" action="/api/v1/writters/delete/{{ $wr->id }}">
                        <input type="hidden" name="_method" value="delete">
                        <a href="/api/v1/books/list/{{ $wr->id }}"><img src="http://bookshop/image/watch.png" alt="Просмотр" width="20px"></a>
                        <a href="/api/v1/writters/edit/{{ $wr->id }}"><img src="http://bookshop/image/update.png" alt="Редактировать" width="20px"></a>
                        <input type="submit" class="bt_del" value="" />
                        {{csrf_field()}}
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection()
