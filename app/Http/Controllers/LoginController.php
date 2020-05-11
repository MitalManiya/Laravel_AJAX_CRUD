<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Input;
use Auth;
use Redirect;
use Validator;

class LoginController extends Controller
{

    public function showLogin()
    {
        // Form View
        return view('checklogin');
    }

    public function doLogout()
    {
        Auth::logout(); // logging out user
        return Redirect::to('login'); // redirection to login screen
    }


    public function dologin(Request $request)
    {
        $rules = array(
            'email' => 'required|email', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:8');
      // password has to be greater than 3 characters and can only be alphanumeric and);
      // checking all field
      $validator = Validator::make(Input::all() , $rules);
      // if the validator fails, redirect back to the form
      if ($validator->fails())
     // if ($validator)
      {
          return Redirect::to('login')->withErrors($validator) // send back all errors to the login form
          ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
      }
    else
      {
          // create our user data for the authentication
          $userdata = array(
              'email' => Input::get('email') ,
              'password' => Input::get('password')
          );
          // attempt to do the login
//         print_r($userdata);

          if (Auth::attempt($userdata))
          {
              // validation successful
              // do whatever you want on success
              return "Sucess Login";
          }
          else
          {
              // validation not successful, send back to form
              print_r($userdata);
              return "Fail Login";
//              return Redirect::to('login');
          }
      }

    }
}
