@extends('templates.writterTem')

@section('StartForm')
    <form method="POST" action="http://bookshop/api/v1/writters/save/{{$writter->id}}">
@endsection

@section('WritterName')
    <input type="text" class="form_edit" name="WName" value="{{$writter->name}}">
@endsection

@section('EndForm')
    {{csrf_field()}}
    <input type="submit" value="Сохранить" class="bt_save">
    </form>
@endsection
