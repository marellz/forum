@extends('wrappers.main')
@section('content')
<div class="section pd-2">
  <thread-view code="{{$code}}" auth="{{Auth::check()}}"></thread-view>
</div>
@endsection
