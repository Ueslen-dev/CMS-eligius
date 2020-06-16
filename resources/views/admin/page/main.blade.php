@extends('adminlte::page')
@section('title', 'Páginas')
@section('content_header')
    <h1>
        Páginas
        <a href="{{route('admin.page.criar')}}" class="btn btn-success">Criar página</a>
    </h1>
   
@endsection
@section('content')
@if(session('msg'))
    @component('component.success') {{session('msg')}} @endcomponent
@endif
<section class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Title</th>
                    <th>Criação</th>
                    <th>Atualização</th>
                    <th>Ações</th>
                </tr>
               @if(count($pages) > 0)
                @foreach($pages as $page)
                @if($page->is_deleted === null)
                <tr>
                    <td>{{$page->id}}</td>
                    <td>{{$page->name}}</td>
                    <td>{{$page->title}}</td>
                    <td>{{date('d/m/Y H:i:s', strtotime($page->created_at))}}</td>
                    <td>{{$page->updated_at === null ? '---' : date('d/m/Y H:i:s', strtotime($page->updated_at))}}</td>
                    <td>
                        <a href="" class="btn btn-success">Ver</a>
                        <a href="{{route('admin.page.editar', ['id'=>$page->id])}}" class="btn btn-primary">Editar</a>
                        <a href="{{route('admin.page.excluir', ['id'=>$page->id])}}" class="btn btn-danger btDelPage"  data-toggle="modal" data-target="#exampleModal">Excluir</button>
                        
                    </td>
                </tr>
                @endif
                 @endforeach
                @endif
               
            </table>
            {{$pages->links()}}
        </div>
    </div>
</section>
@endsection
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" id="btConfirmDel" class="btn btn-danger">Excluir</button>
        </div>
      </div>
    </div>
  </div>
@section('css')@endsection
@section('js') <script type="text/javascript" src="{{asset('js/main.js')}}"></script>@endsection