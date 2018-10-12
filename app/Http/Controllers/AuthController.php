<?php

namespace App\Http\Controllers;
use App\User;
use App\ResetTokens;
use Illuminate\Http\Request;

use Auth;

class AuthController extends Controller
{
    //
    public function __construct()
    {
      $this->middleware('guest',['except'=>['logout']]);
    }

    public function status()
    {
      if(auth()->check()){
        $response  = [
          'hasAuth' => true,
          'user' => Auth::user(),
        ];
      } else {
        $response = [
          'hasAuth' => false,
        ];
      }
      return response()->json($response);
    }

    public function login(Request $request)
    {
      $email = $request->input('email');
      $password = $request->input('password');
      $user = User::where('email',$email)->first();
      if(!$user){
        // return redirect()->back()->with('error','User does not exist');
      }
      #attempt to log me in
      if(!auth()->attempt(request(['email','password']))){
        return redirect()->back()->with('error','Invalid username/password');
      }

      #get me to dash
      return redirect()->home();
    }

    public function logout()
    {
      #log the f out
      auth()->logout();

      #get me home then
      return redirect()->home();
    }

    public function register(Request $request)
    {

      $name = $request->input('name');
      $email = $request->input('email');
      $password = $request->input('password');
      $confirmation = $request->input('password_confirmation');
      $user_type = 'regular';


      if($password != $confirmation){
        #set message here
        return redirect()->back()->with('error','Passwords do not match.');
      }

      #look for sb with this email
      if(count(User::where('email',$email)->get())){
        #sb has this email, warn!
        return redirect()->back()->with('error','Email is already taken.');
      }

      #validate here
      $this->validate(request(),[
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed',
      ]);

      #create user
      $user = User::create([
        'name' => $name,
        'email' => $email,
        'password' => bcrypt($password),
        'type' => $user_type
      ]);


      #log user in
      auth()->login($user);


      #get me home
      return redirect()->home();

    }

    public function reset_email(Request $request)
    {
      $email = $request->input('email');
      $user = User::where('email',$email)->first();
      //find out if User with such an email exists
      if(!$user){
        return redirect()->back()->with('error','No user is registered with this email.');
      }

      //create a token
      $token = str_random(20);

      //save token
      ResetTokens::create([
        'token'=>$token,
        'email'=>$email,
      ]);

      //send an email

    }

    public function reset_password($token)
    {
      //see if token exists
      $reset = ResetTokens::where('token',$token);
      if(!$reset->first()){
        // return error view saying token is invalid
      }

      return view('auth.reset_password');
    }


    public function new_password(Request $request, $token)
    {
      //see if token exists
      $reset = ResetTokens::where('token',$token);
      $password = $request->input('password');
      $password_confirmation = $request->input('password_confirmation');

      //validate passwords
      if($password != $password_confirmation){
        return redirect()->back()->with('error','Passwords do not match');
      }

      //update user password
      User::where('email',$reset->first()->email)->update([
        'password'=>bcrypt($password)
      ]);

      //delete reset request
      $reset->delete();

      //take me back home
      return redirect()->home();
    }
}
