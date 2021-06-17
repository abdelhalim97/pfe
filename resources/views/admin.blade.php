@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin   Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($users as $user)
                    <div>status</div>
                    {{$user->name}}
                    <div>status</div>
                    @if($user->status == 0)
                    Inactive
                    @else
                    active
                    @endif
                    <a href="{{route('status',['id'=>$user->id])}}">
                    @if($user->status == 0)
                    active
                    @else
                    inactive
                    @endif
                    </a>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
