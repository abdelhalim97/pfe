@extends('layouts.app')
@section('content')
<a href="{{route('admin.login') }}">go back</a>
<h1>workers</h1>
<?php $i=1 ?>
@if(count($workers)>0)

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">full name</th>
      <th scope="col">age</th>
      <th scope="col">registration number</th>
    </tr>
  </thead>
  @foreach($workers as $worker)

  <tbody>
    <tr>
      <th scope="row">{{$i}}</th>
      <td><a href="{{url ('/admin/update/worker/'.$worker->id) }}">{{$worker->full_name}}</a></td>
      <td>{{$worker->age}}</td>
      <td>{{$worker->nb_matricule}}</td>
      @csrf

      <?php $i++;?>
    </tr>

    @endforeach
  </tbody>
</table>

@else
<p>you have no workers</p>
@endif
@endsection
