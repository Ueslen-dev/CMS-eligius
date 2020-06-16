@extends('adminlte::page')
@section('title', 'Atualizar Perfil')
@section('content_header')
    <h1>Atualizar perfil</h1>
@endsection
@section('content')
 <section class="card">
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
        <form action="{{route('profile.update')}}" method="POST">
          @method('PUT')
            @csrf
            <div class="row mb-3">
                <div class="col">
                  <input type="text" name="name" class="form-control @error('name')is-invalid @enderror" placeholder="Nome do usuário" value="{{ $user->name }}">
                </div>
                <div class="col">
                  <input readonly type="email" name="email" class="form-control @error('email')is-invalid @enderror" placeholder="E-mail do usuário" value="{{ $user->email }}">
                </div>
                <div class="col">
                    <select id="inputState" class="form-control" name="permission">
                      @if($user->permission === 0)
                        <option selected value="{{ $user->permission }}">Editor</option>
                        <option value="1">Admin</option>
                        @else
                        <option value="0">Editor</option>
                        <option selected value="{{ $user->permission }}">Admin</option>
                        @endif
                    </select>
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <input type="password" name="password" class="form-control @error('password')is-invalid @enderror" placeholder="Senha do usuário">
                </div>
                <div class="col mb-3">
                  <input type="password" name="password_confirmation" class="form-control @error('password_confirmation')is-invalid @enderror" placeholder="Confirme a senha">
                </div>
              </div>
            <input type="submit" value="Atualizar usuário" class="col-12 btn btn-primary">
        </form>
    </div>
 </section>
@endsection
