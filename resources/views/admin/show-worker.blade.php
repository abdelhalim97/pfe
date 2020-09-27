@extends('layouts.app')
@section('content')
<a href="{{route('admin.worker.display') }}">go back</a>

<h1>{{$worker->full_name}}</h1>
<div>{{$worker->age}}</div>
<div>{{$worker->nb_matricule}}</div>
<a href="{{route('admin.worker.edit',['worker'=>$worker->id]) }}" class="btn btn-default">Edit</a>


<a href="{{route('admin.worker.delete',['worker'=>$worker->id]) }}" class="bt btn-danger">delete</a>
@endsection

