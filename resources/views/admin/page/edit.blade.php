@extends('adminlte::page')
@section('title', 'Editar pagina')
@section('content_header')
    <h1>Editar página</h1>
@endsection
@section('content')
@if($errors->any())
    <nav>
    
        @component('component.alert')
            @foreach ($errors->all() as $error)
                <li>
                {{$error}} 
                </li>
            @endforeach
        @endcomponent
    
    </nav>
@endif
<section class="card">
   <div class="card-body">
    <form action="{{route('admin.page.atualizar', ['id'=>$page->id])}}" method="POST">
        @method('PUT')
        @csrf
        <input type="text" class="form-control mb-3" name="title" placeholder="Título da página" value="{{$page->title}}">
        <textarea name="body" class="form-control mb-3 bodyfield" id="" cols="30" rows="10" placeholder="Corpo da página">{{$page->body}}</textarea>
        <input type="submit" class="col-12 mb-3 btn btn-primary" value="Criar página">
    </form>
   </div>
</section>
@endsection
{{-- @section('css')@endsection --}}
@section('js')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
 tinymce.init({
        selector: 'textarea.bodyfield',
        menubar: false,
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | link image | print preview media fullpage | ' +
                'forecolor backcolor emoticons | help',
        plugins: ['link', 'table', 'image', 'autoresize', 'lists'],
        content_css: '{{asset('css/content.css')}}',
        images_upload_url:'{{route('uploadimage')}}',
        images_upload_credentials: true,
        convert_urls:false
      });
</script>
@endsection