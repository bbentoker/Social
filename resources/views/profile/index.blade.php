@extends('layouts.app')
@section('content')
<style>
    .profilePhoto{
        width: 15px;
        height: 50px;
        border-radius: 50%;

    }
</style>
<div class="container">
    <div class="row m-5">
        <div class="col-md-2">
            <img src="{{asset('storage/'.$user->photo)}}" style="width:175px;border-radius: 50%;"  class="profilePhoto">
            <!-- <img src="/storage/profile/elliot.png" style="width:175px;border-radius: 50%;"  class="profilePhoto"> -->
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col"></div>
                <div class="row pt-3">
                    <div class="col">

                        <h2>{{$user->name}}</h2>
                        <b>{{$user->profile->title}}</b>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary">
                            X
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Photos of the user goes in here -->
    </div>
</div>
@endsection