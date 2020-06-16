@extends('adminlte::page')
@section('title', 'Admin')
@section('content_header')
    <h1>Configurações do site</h1>
@endsection
@section('content')
    <section class="card">
        <div class="card-header">
            <h5 class="card-title">Configure o seu site</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
            <nav>
                @component('component.alert')
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                @endcomponent
            </nav>
            @endif
            @if(session('msg'))
            @component('component.success')
                {{session('msg')}}
            @endcomponent
            @endif
            @if(count($sets) > 0)
            <form action="{{route('admin.savesettings')}}" method="POST">
                @method('PUT')
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <p>Título do site</p>
                        <input type="text" name="title" class="form-control" placeholder="Título do site" value="{{$sets['title']}}">
                    </div>
                    <div class="col">
                        <p>Subtítulo do site</p>
                        <input type="text" name="subtitle" class="form-control" placeholder="Subtítulo do site" value="{{$sets['subtitle']}}">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <p>E-mail do admnistrador</p>
                        <input type="email" name="email" class="form-control" placeholder="E-mail do admnistrador" value="{{$sets['email']}}">
                    </div>
                    <div class="col">
                        <p>Cor do fundo do site</p>
                        <input type="color" name="bgcolor" class="form-control" placeholder="Cor do fundo do site" value="{{$sets['bgcolor']}}">
                    </div>
                    <div class="col">
                        <p>Cor do texto do site</p>
                        <input type="color" name="textcolor" class="form-control" value="{{$sets['textcolor']}}">
                    </div>
                </div>
                <input class="col-12 btn btn-primary" type="submit" value="Alterar configurações">
            </form>
            @endif
        
        </div>
    </section>
@endsection
@section('css')@endsection
@section('js')@endsection