@extends('layouts.app')
@section('app')
<div class="header">
  <div class="logo">
    <a class="typ c " href="{{route('home')}}">Forum</a>
  </div>
  <search-component></search-component>

  <div class="header-actions">
    <div class="menu flat">
      <ul>
        <li>
          <!-- <a class="icon ion-md-search mobile-only" href="#search"></a> -->
        </li>
        @if(Auth::check())
        <notification-component></notification-component>
        <li>
          <a class="icon ion-md-log-out" href="{{route('logout')}}"></a>
        </li>
        @else
        <li>
          <a class="icon ion-md-log-in" href="{{route('login')}}"></a>
        </li>
        @endif
      </ul>
    </div>

  </div>
</div>
<div class="content">
  @section('content')
  @show
</div>
@endsection
