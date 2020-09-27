@extends('layouts.app')
@section('content')

<h1>Buttons table</h1><!--1 elements table -->
<?php $i=1 ?>
@if(count($buttons)>0)

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">name</th>
      <th scope="col">image</th>
    </tr>
  </thead>
  @foreach($buttons as $button)

  <tbody>
    <tr>
      <th scope="row">{{$i}}</th>
      <td><img src="{{asset('storage/' . $button->first_name)}}" class="img-thumbnail"></td>
      <?php $i++;?>
    </tr>

    @endforeach
  </tbody>
</table>

@else
<p>No buttons </p>
@endif

<h1>boitiers table</h1> <!--2 elements table -->
<?php $i=1 ?>
@if(count($boitiers)>0)

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">name</th>
      <th scope="col">image</th>
    </tr>
  </thead>
  @foreach($boitiers as $boitier)

  <tbody>
    <tr>
      <th scope="row">{{$i}}</th>
      <td><img src="{{asset('storage/' . $boitier->second_name)}}" class="img-thumbnail"></td>
      <?php $i++;?>
    </tr>

    @endforeach
  </tbody>
</table>

@else
<p>No boitiers</p>

@endif


<h1>poles table</h1><!--1 elements table -->
<?php $i=1 ?>
@if(count($poles)>0)

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">name</th>
      <th scope="col">image</th>
    </tr>
  </thead>
  @foreach($poles as $pole)

  <tbody>
    <tr>
      <th scope="row">{{$i}}</th>
      <td><img src="{{asset('storage/' . $pole->third_name)}}" class="img-thumbnail"></td>
      <?php $i++;?>
    </tr>

    @endforeach
  </tbody>
</table>

@else
<p>No poles </p>
@endif
<!-- 4-->


<h1>type of amperes</h1>
<?php $i=1 ?>
@if(count($amperes)>0)

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">name</th>
      <th scope="col">image</th>
    </tr>
  </thead>
  @foreach($amperes as $ampere)

  <tbody>
    <tr>
      <th scope="row">{{$i}}</th>
      <td><img src="{{asset('storage/' . $ampere->fourth_name)}}" class="img-thumbnail"></td>
      <?php $i++;?>
    </tr>

    @endforeach
  </tbody>
</table>

@else
<p>No amperes</p>
@endif
@endsection

