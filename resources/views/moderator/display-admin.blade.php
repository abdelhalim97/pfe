@extends('layouts.master')
@section('content')
<a href="{{route('moderator.login') }}">go back</a>
<h1>admins</h1>
<?php $i=1 ?>
@if(count($admins)>0)

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">name</th>
      <th scope="col">Last</th>
      <th scope="col">email</th>
      <th scope="col">password</th>
    </tr>
  </thead>
  @foreach($admins as $admin)

  <tbody>
    <tr>
      <th scope="row">{{$i}}</th>
      <td><a href="{{url ('/moderator/manage/admin/'.$admin->id) }}">{{$admin->name}}</a></td>
      @csrf
      <td>{{$admin->name}}</td>
      <td>{{$admin->email}}</td>
      <td>{{$admin->password}}</td>
      <?php $i++;?>
    </tr>

    @endforeach
  </tbody>
</table>

@else
<p>you have no admins</p>
@endif
@endsection
