
@extends('layouts.app')
@section('content')

<form action="{{route('add.ampere')}}" method="post" style="padding-left:50px" enctype="multipart/form-data">
<div class="input-group">
<label>choose file</label>
<input type="file" name="image4" >
</div>
<button type="submit">add Ampere</button>
@csrf
</form>

@endsection
