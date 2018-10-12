@extends('wrappers.auth')
@section('auth')
<form method="post" action="{{route('register')}}">

  {{csrf_field()}}
  <div class="pd-xs">
    <h1 class="typ l c">Register</h1>
  </div>

@if(count($errors))
  <div class="pd-s-v">
    <span class="typ s thin danger">{{$errors->first()}}</span>
  </div>
@endif

  <div class="auth-form">
    <div class="input">
      <input placeholder="Name" name="name" required/>
    </div>
    <div class="input">
      <input type="email" placeholder="Email" name="email" required/>
    </div>
    <div class="input">
      <input type="password" placeholder="Password" name="password" required/>
    </div>
    <div class="input">
      <input type="password" placeholder="Confirm Password" name="password_confirmation" required/>
    </div>

    <div class="buttons pd-xs">
      <button>Register</button>
    </div>

    <a class="typ s c" href="{{route('login')}}">Have an account? Login</a>
  </div>


</form>
@endsection
