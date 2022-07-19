@extends('layouts.app')
@section('content')
<div>
    <h1>Hello Friend</h1>
    <form action="{{route('test.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <button class="btn btn-secondary "type="submit">Submit</button> 
    </form>
    
</div>
@endsection