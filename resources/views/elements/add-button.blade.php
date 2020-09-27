@extends('layouts.app')
@section('content')

<form action="{{route('add.button')}}" method="post" style="padding-left:50px" enctype="multipart/form-data">
<div class="input-group">
<label>choose file</label>
<input type="file" name="image1" >
</div>
<button type="submit">add button</button>
@csrf
</form>

@endsection
