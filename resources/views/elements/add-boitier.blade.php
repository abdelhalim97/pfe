@extends('layouts.app')
@section('content')

<form action="{{route('add.boitier')}}" method="post" style="padding-left:50px" enctype="multipart/form-data">
<div class="input-group">
<label>choose file</label>
<input type="file" name="image2" >
</div>
<button type="submit">add boitier</button>
@csrf
</form>

@endsection
