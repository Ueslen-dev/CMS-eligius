<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $req)
    {
        $data = $req->only(['email', 'password']);
        $validator = $this->validator($data);
        $remember = $req->input('remember', false);
        if($validator->fails()){
            return redirect()->route('login')
                    ->withErrors($validator)
                    ->withInput();
        }
        if(Auth::attempt($data, $remember)){
            return redirect()->route('admin.home');
        }else{
            $validator->errors()->add('password', 'E-mail e/ou senha errados!');
            return redirect()->route('login')
                    ->withErrors($validator)
                    ->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:3']
        ]);
    }
}
