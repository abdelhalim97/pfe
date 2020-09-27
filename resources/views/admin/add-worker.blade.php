@extends('layouts.app')
@section('content')

<a href="{{route('admin.dashboard') }}">go back</a>
<form action="" method="post" style="padding-left:50px">
<p>full name</p>
<input type="text" name="Fname">
<p>age</p>
<input type="text" name="age">
<p>number registration</p>
<input type="text" name="nb_matricule">

<div>{{$errors->first('Fname')}}</div>

<button type="submit">add worker</button>
@csrf
</form>
@endsection
