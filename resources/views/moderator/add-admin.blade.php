@extends('layouts.app')
@section('content')

<a href="{{route('moderator.login') }}">go back</a>
<form action="" method="post" style="padding-left:50px">
<p>name</p>
<input type="text" name="name">
<p>email</p>
<input type="email" name="email">
<p>password</p>
<input type="password" name="password">
<div>{{$errors->first('name')}}</div>

<button type="submit">add admin</button>
@csrf
</form>
@endsection
