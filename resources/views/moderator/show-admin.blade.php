@extends('layouts.app')
@section('content')
<a href="{{route('moderator.admin.display') }}">go back</a>

<h1>{{$admin->name}}</h1>
<div>{{$admin->email}}</div>
<div>{{$admin->password}}</div>
<a href="{{route('moderator.admin.edit',['admin'=>$admin->id]) }}" class="btn btn-default">Edit</a>

<button href="{{route('moderator.admin.delete',['admin'=>$admin->id]) }}" class="bt btn-danger">delete</button>
@endsection

