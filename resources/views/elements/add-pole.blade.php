
@extends('layouts.app')
@section('content')

<form action="{{route('add.pole')}}" method="post" style="padding-left:50px" enctype="multipart/form-data">
<div class="input-group">
<label>choose file</label>
<input type="file" name="image3" >
</div>
<button type="submit">add connexion</button>
@csrf
</form>

@endsection
