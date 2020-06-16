<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:permission');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'users' => User::paginate(5),
            'isLogged' => Auth::id()
        ];
        return view('admin.user.main', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name', 'email', 'permission', 'password', 'password_confirmation');
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('users.create')
                    ->withErrors($validator)
                    ->withInput();
        }
        User::create([
            'name' => ucwords($data['name']),
            'email' => $data['email'],
            'permission' => $data['permission'],
            'password' => Hash::make($data['password']),
            'updated_at' => null
        ]);
        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user = User::find($id);
        if($user){
            return view('admin.user.edit', ['user' => $user]);
        }
        return redirect()->route('users.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if($user){
            $data = $request->only('name', 'email', 'permission', 'password', 'password_confirmation');
            $validator = Validator::make($data, [
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', 'max:255']
            ]);
            if($validator->fails()){
                return redirect()->route('users.edit', ['user' => $id])
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
                        return redirect()->route('users.edit', ['user' => $id])
                                ->withErrors($validator);
                    }
                }else{
                    $validator->errors()->add('password', __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 3
                    ]));
                    return redirect()->route('users.edit', ['user' => $id])
                            ->withErrors($validator);
                }
            }
            if($data['permission'] !== $user->permission){
                $user->permission = $data['permission'];
            }
            
            $user->save();
            return redirect()->route('users.index');
        }
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete($id)
    {
       if(User::find($id)){
           if($id != Auth::id()){
                User::find($id)->update([
                    'is_deleted' => date('Y-m-d H:i:s')
                ]);
                return redirect()->route('users.index')
                        ->with('msg', 'Usuário excluído com sucesso!');
           }else{
                return redirect()->route('users.index')
                    ->with('warning', 'Você não pode excluir o seu próprio usuário!');
           }
       }
       return redirect()->route('users.index');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3','confirmed']
        ]);
    }
}
