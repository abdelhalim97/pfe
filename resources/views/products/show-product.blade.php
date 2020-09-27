@extends('layouts.app')
@section('content')
<a href="{{route('show.products') }}">go back</a>

<div>path</div>
<div>{{$product->name}}</div>

<div>image product name</div>
<div>{{$product->image}}</div>

<div>image button name</div>
<div>{{$button->first_image}}</div>

<div>image boitier name</div>
<div>{{$boitier->second_image}}</div>

<div>image connexion name</div>
<div>{{$pole->third_image}}</div>

<div>image ampere name</div>
<div>{{$ampere->fourth_image}}</div>


<a href="{{route('edit-form.product',['product'=>$product->id]) }}" class="btn btn-default">Edit</a>
<a href="{{ url('/delete/product/' . $product->id) }}" class="bt btn-danger">delete</a>
@endsection

