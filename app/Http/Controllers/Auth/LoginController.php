<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Validator;

class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function login(Request $request)
    {
        $validate = [
            'username' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return redirect()->action('Auth\LoginController@showLoginForm')
                    ->withErrors($validator->errors())
                    ->withInput(['username' => $request['username']]);
        }

        $staff = Staff::where('username', $request['username'])->first();

        if (empty($staff)) {
            return redirect()->action('Auth\LoginController@showLoginForm')
                    ->withErrors(['wrong username or password'])
                    ->withInput(['username' => $request['username']]);
        }

        $dataLogin = [
            'username' => $request['username'],
            'password' => $request['password']
        ];

        if (Auth::attempt($dataLogin)) {
            return redirect()->action('HomeController@index');
        } else {
            return redirect()->action('Auth\LoginController@showLoginForm')
                    ->withErrors(['wrong username or password'])
                    ->withInput(['username' => $request['username']]);
        }
    }
}
