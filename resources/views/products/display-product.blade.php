@extends('layouts.app')
@section('content')


<h1>Products table</h1>

<?php $i=1 ?>
@if(count($products)>0)
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <!-- <th scope="col">name</th> -->
      <th scope="col">image</th>
      <th scope="col">products elements</th>


    </tr>
  </thead>
  @foreach($products as $product )

  <tbody>
    <tr>
      <th scope="row">{{$i}}</th>
      <!-- <td>{{$product->name}}</td> -->
      @if($product->image)
      <td><img src="{{asset('storage/' . $product->name)}}" class="img-thumbnail"></td>
      @else
      <td>ther s no image to show</td>

      @endif
      <td><a href="{{url ('/update/product/'.$product->id) }}">products elements </a></td>


      <?php $i++;?>
    </tr>
    @endforeach

  </tbody>
</table>

@else
<p>No products to show</p>
@endif

@endsection

