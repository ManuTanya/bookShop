@extends('templates.writterTem')

@section('StartForm')
   <form method="Post" action="http://bookshop/api/v1/writters/save/0">
@endsection

@section('WritterName')
    <input type="text" class="form_edit" name="WName" value="">
@endsection

@section('EndForm')
   {{csrf_field()}}
   <input type="submit" value="Сохранить" class="bt_save">
   </form>
@endsection
