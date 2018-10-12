@extends('wrappers.auth')
@section('auth')
<form method="post" action="{{route('login')}}">

  {{csrf_field()}}
  <div class="pd-xs">
    <h1 class="typ l c">Login</h1>
  </div>

@if(count($errors))
  <div class="pd-s-v">
    <span class="typ s thin danger">{{$errors->first()}}</span>
  </div>
@endif

  <div class="auth-form">
    <div class="input">
      <input type="email" placeholder="Email" name="email" required/>
    </div>
    <div class="input">
      <input type="password" placeholder="Password" name="password" required/>
    </div>

    <div class="buttons pd-xs">
      <button>Login</button>
    </div>

    <a class="typ s c" href="{{route('register')}}">No account? Register</a>
  </div>


</form>
@endsection
