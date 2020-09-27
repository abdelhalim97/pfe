@extends('layouts.app')
@section('content')

<form action="{{route('add.product')}}" method="post" style="padding-left:50px" enctype="multipart/form-data">


<label>choose file</label>
<input type="file" name="image" >

<select name="relation1">
@foreach($buttons as $button)
  <option value="{{$button->id}}" name="relation1">{{$button->first_image}}</option>
@endforeach
</select>

<select name="relation2">
@foreach($boitiers as $boitier)
  <option value="{{$boitier->id}}" name="relation2">{{$boitier->second_image}}</option>
@endforeach
</select>

<select name="relation3">
@foreach($poles as $pole)
  <option value="{{$pole->id}}" name="relation3">{{$pole->third_image}}</option>
@endforeach
</select>

<select name="relation4">
@foreach($amperes as $ampere)
  <option value="{{$ampere->id}}" name="relation4">{{$ampere->fourth_image}}</option>
@endforeach
</select>
<button type="submit">add product</button>
@csrf
</form>
@endsection
