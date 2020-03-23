@extends('templates.writterTem')

@section('WritterName')
    @if(count($books) < 1)
        {{$writter->name}}
        <form method="post" action="/api/v1/writters/delete/{{ $writter->id }}">
            <a href="/api/v1/writters/edit/{{ $writter->id }}"><img src="http://bookshop/image/update.png" alt="Редактировать" width="20px"></a>
            <input type="hidden" name="_method" value="delete">
            <input type="submit" class="bt_del" value="" />
            {{csrf_field()}}
        </form>
    @else
        {{$writter->name}} <br>
        <a href="/api/v1/writters/edit/{{ $writter->id }}"><img src="http://bookshop/image/update.png" alt="Редактировать" width="20px"></a>
    @endif
@endsection

@section('WritterBooks')
    <li>
        <b>Список книг:</b>
        <ul>
            @foreach($books as $book)
                <li> {{$book->name}}({{$book->year}}) - {{$book->price}} р. </li>
            @endforeach
        </ul>
    </li>
@endsection
