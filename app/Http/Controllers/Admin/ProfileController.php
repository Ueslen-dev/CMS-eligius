<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin.user.profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if($user){
            $data = $request->only('name', 'email', 'permission', 'password', 'password_confirmation');
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', 'max:255']
            ]);
            if($validator->fails()){
                return redirect()->route('admin.profile')
                        ->withErrors($validator);
            }

            $user->name = ucwords($data['name']);
            
            if(!empty($data['password'])){
                if(strlen($data['password']) >= 3){
                    if($data['password'] === $data['password_confirmation']){
                        $user->password = Hash::make($data['password']);
                    }else{
                        $validator->errors()->add('password', __('validation.confirmed', [
                            'attribute' => 'password'
                        ]));
                        return redirect()->route('admin.profile')
                                ->withErrors($validator);
                    }
                }else{
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 3
                    ]));
                    return redirect()->route('admin.profile')
                            ->withErrors($validator);
                }
            }
            $user->save();
            return redirect()->route('admin.home');
        }
        return redirect()->route('home');
    }
}
