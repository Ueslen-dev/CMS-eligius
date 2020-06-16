@extends('adminlte::page')
@section('title', 'Usuário')
@section('content_header')
    <h1>
        Usuários
        <a href="{{route('users.create')}}" class="btn btn-success">Novo usuário</a>
    </h1>
@endsection
@section('content')

    @if(session('msg'))
    @component('component.success')
        {{session('msg')}}
    @endcomponent
    @endif

    @if( session('warning'))
    @component('component.alert')
        {{session('warning')}}
    @endcomponent
    @endif
    <section class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Permissão</th>
                        <th>Criação</th>
                        <th>Atualização</th>
                        <th>Ações</th>
                    </tr>
                    @if(count($users) > 0)
                    @foreach($users as $user)
                    @if($user->is_deleted === null)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->permission === 0 ? 'Editor' : 'Admin'}}</td>
                        <td>{{date('d/m/Y H:i:s', strtotime($user->created_at))}}</td>
                        <td>{{$user->updated_at === null ? '---' : date('d/m/Y H:i:s', strtotime($user->updated_at))}}</td>
                        <td>
                            <a href="{{route('users.edit', ['user'=>$user->id])}}" class="btn btn-primary">Editar</a>
                            @if($user->id != $isLogged)
                            <a href="{{route('excluir', ['id'=>$user->id])}}" class="btn btn-danger btDelUser" data-toggle="modal" data-target="#exampleModal">Excluir</button>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endif
                </table>
                {{$users->links()}}
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
  @section('js') <script type="text/javascript" src="{{asset('js/main.js')}}"></script>@endsection