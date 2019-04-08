@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Sua Empresa
                    <span class="float-right">{{ isset($empresa->nome) ? ($empresa->nome) : '' }}</span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <form method="post" action="/admin/empresa/create">
                            {{ csrf_field() }}
                            <input type="hidden" value="put" name="_method">
                            <div class="form-group">
                                <label class="col-form-label" for="cnpj">Cnpj</label>
                                <input class="form-control" type="text" name="cnpj" value="{{$empresa->cnpj}}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="nome">Nome</label>
                                <input class="form-control" type="text" name="nome" value="{{$empresa->nome}}">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="nome">Descrição</label>
                                <textarea class="form-control" type="text" name="descricao">{{$empresa->descricao}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="nome">Logo</label>
                                <input class="form-control" type="text" name="logo" value="{{$empresa->logo}}">
                            </div>
                            <input type="submit" value="Salvar" class="btn btn-success">
                        </form>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
