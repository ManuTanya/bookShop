@extends('templates.bookTem')

@section('StartForm')
<form method="Post" action="http://bookshop/api/v1/books/update/{{$book->id}}">
    @endsection

    @section('BookName')
    <input type="text" class="form_edit" name="name" value="{{$book->name}}">
    @endsection

    @section('BookWritter')
    <select name="writter_id" class="select_Wr">
        @foreach($writters as $writter)
            @if($writter->id === $book->writter_id)
                <option value="{{$writter->id}}" selected > {{$writter->name}} </option>
                @dump($writter->id)
                @dump($book->writter_id)
            @else <option value="{{$writter->id}}"> {{$writter->name}} </option>
            @endif
        @endforeach
    </select>
    @endsection

    @section('BookYear') <input type="text" class="form_edit" name="year" value="{{$book->year}}"> @endsection

    @section('BookPrice') <input type="text" class="form_edit" name="price" value="{{$book->price}}"> @endsection

    @section('EndForm')
    {{csrf_field()}}
    <input type="submit" value="Сохранить" class="bt_save">
</form>
@endsection
