@extends('layouts.app')
@section('content')

<form action="{{ route('moderator.admin.edit',['admin'=>$admin->id]) }}" method="post" style="padding-left:50px">
<p>name</p>
<input type="text" name="name" value="{{$admin->name}}">
<p>email</p>
<input type="email" name="email" value="{{$admin->email}}">
<input type="password" name="password" value="{{$admin->password}}">

<input type="submit" class="btn btn-primary" value="Edit" />
@csrf
</form>
@endsection
