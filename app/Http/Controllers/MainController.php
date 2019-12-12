<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use validator;
use Auth;
use Carbon\Carbon;

class MainController extends Controller
{
    function index()
    {
     return view('login');
    }

    function checklogin(Request $request)
    {
	     $this->validate($request, [
	      'user_name'   => 'required',
	      'user_password'  => 'required'
	     ]);

	     $user_data = array(
	      'user_name'  => $request->get('user_name'),
	      'password' => $request->get('user_password')
	     );
	     $userName = $request->get('user_name');

	     if(Auth::attempt($user_data))
	     {
	     	$visits = DB::table('users')
				    ->where('user_name',$userName)
				    ->update(array('last_login' => Carbon::now()));
	      	return redirect('main/successlogin');
	     }
	     else
	     {
	      return back()->with('error', 'Data Login Salah!');
	     }	

    }

    function successlogin()
    {
    	

     	return redirect('/')->with('success', 'Login Sukses!');;
    }

    function logout()
    {
     Auth::logout();
     return redirect('main');
    }
}
