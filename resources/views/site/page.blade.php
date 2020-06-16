@extends('site.layout.layout')
@section('content')
<div class="row align-items-center">
  <h1>{{$page['title']}}</h1>
</div>
<div class="col-md-4 mr-auto">
  {!!$page['body']!!}
</div>
@endsection