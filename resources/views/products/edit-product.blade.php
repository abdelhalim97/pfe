@extends('layouts.app')
@section('content')

<form action="" method="post" style="padding-left:50px" enctype="multipart/form-data">

<p>product's image</p>

<input type="text" value="{{$productR->image}}" disabled="disabled">
<input type="file" name="file">

<p>Button's name</p>
<select name="fimage">
@foreach($buttons as $button)
  <option value="{{$button->first_image}}" @if ($buttonR->id==$button->id) selected @endif name="fname">{{$button->first_image}}</option>
@endforeach
</select>

<p>boitier's name</p>
<select name="simage">
@foreach($boitiers as $boitier)
  <option value="{{$boitier->second_image}}" @if ($boitierR->id==$boitier->id) selected @endif name="sname">{{$boitier->second_image}}</option>
@endforeach
</select>

<p>pole's name</p>
<select name="timage">
@foreach($poles as $pole)
  <option value="{{$pole->third_image}}" @if ($poleR->id==$pole->id) selected @endif name="tname">{{$pole->third_image}}</option>
@endforeach
</select>

<p>Ampere's name</p>
<select name="qimage">
@foreach($amperes as $ampere)
  <option value="{{$ampere->fourth_image}}" @if ($ampereR->id==$ampere->id) selected @endif name="qname">{{$ampere->fourth_image}}</option>
@endforeach
</select>

<input type="submit" class="btn btn-primary" value="Edit" />
@csrf
</form>
@endsection
