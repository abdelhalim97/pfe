@extends('layouts.app')
@section('content')

<form action="{{ route('admin.worker.edit',['worker'=>$worker->id]) }}" method="post" style="padding-left:50px">
<p>full name</p>
<input type="text" name="Fname" value="{{$worker->full_name}}">
<p>age</p>

<input type="text" name="age" value="{{$worker->age}}">
<p>registration number</p>
<input type="text" name="nb_matricule" value="{{$worker->nb_matricule}}">

<input type="submit" class="btn btn-primary" value="Edit" />
@csrf
</form>
@endsection
