<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Page;
use App\User;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   
        $data = DB::table('pages')
        ->join('users', 'pages.user', '=', 'users.id')
        ->select('pages.*', 'users.name')
        ->paginate(10);

        return view('admin.page.main', [
            'pages' => $data
        ]);
    }

    public function create()
    {
        return view('admin.page.create');
    }

    public function save(Request $request)
    {
        $data = $request->only('title', 'body');
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('admin.criar')
                    ->withErrors($validator)
                    ->withInput();
        }
        Page::create([
            'user' => Auth::id(),
            'title' => $data['title'],
            'slug' => Str::slug($data['title'], '-'),
            'body' => $data['body'],
            'updated_at' => null
        ]);

        return redirect()->route('admin.pages');
    }

    public function edit($id)
    {
        $data = Page::find($id);
        if($data){
            return view('admin.page.edit', [
                'page' => $data
            ]);
        }
        return redirect()->route('admin.pages');
    }

    public function update(Request $request, $id)
    {
        $page = Page::find($id);
        if($page){
            $data = $request->only('title', 'body');
            if($page['title'] !== $data['title']){
                $data['slug'] = Str::slug($data['title'], '-');
                $validator = Validator::make($data, [
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['required', 'string'],
                    'slug' => ['required', 'string', 'max:100', 'unique:pages']
                ]);
            }else{
                $validator = Validator::make($data, [
                    'title' => ['required', 'string', 'max:100'],
                    'body' => ['required', 'string']
                ]);
            }

            if($validator->fails()){
                return redirect()->route('admin.page.editar', ['id'=>$id])
                        ->withErrors($validator)
                        ->withInput();
            }
            
            $page->title = $data['title'];
            $page->body = $data['body'];
            if(!empty($data['slug'])){
                $page->slug = $data['slug'];
            }
            $page->save();
            return redirect()->route('admin.pages');
            

        }
        
    }

    public function delete($id)
    {
        $page = Page::find($id);
        if($page){
            Page::find($id)->update([
                'is_deleted' => date('Y-m-d H:i:s')
            ]);
            return redirect()->route('admin.pages')
                    ->with('msg', 'Página excluída com sucesso!');
       }else{
            return redirect()->route('admin.pages');
       }
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:100', 'unique:pages'],
            'body' => ['required', 'string']
        ]);
    }
}
