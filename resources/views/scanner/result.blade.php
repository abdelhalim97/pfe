@extends('layouts.app')
@section('content')
<div>our button</div>
<div><img src="{{asset('storage/' . $buttonR->first_name)}}" class="img-thumbnail"></div>

<div>our boitier</div>
<div><img src="{{asset('storage/' . $boitierR->second_name)}}" class="img-thumbnail"></div>
<div><img src="{{asset('storage/' . $boitierR2->second_name)}}" class="img-thumbnail"></div>

<div>our pole</div>
<div><img src="{{asset('storage/' . $poleR->third_name)}}" class="img-thumbnail"></div>

<div>our ampere</div>
<div><img src="{{asset('storage/' . $ampereR->fourth_name)}}" class="img-thumbnail"></div>
@endsection
