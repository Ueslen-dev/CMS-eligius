<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Setting;


class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $arrSettings = [];
        $sets = Setting::get();
        foreach($sets as $set){
            $arrSettings[ $set['name'] ] = $set['content'];
        }
        
        return view('admin.setting', [
            'sets' => $arrSettings
        ]);
    }
    
    public function save(Request $request)
    {
        $data = $request->only('title', 'email', 'subtitle', 'bgcolor', 'textcolor');
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('admin.settings')
                    ->withErrors($validator);
        }
        
        foreach($data as $item => $value){
            Setting::where('name', $item)->update([
                'content' => $value
            ]);
        }
        return redirect()->route('admin.settings')
                ->with('msg', 'Configurações atualizadas com sucesso!');
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:50'],
            'subtitle' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'bgcolor' => ['string', 'regex:/#[a-zA-Z0-9]{6}/i'],
            'textcolor' => ['string', 'regex:/#[a-zA-Z0-9]{6}/i']
        ]);
    }
}
