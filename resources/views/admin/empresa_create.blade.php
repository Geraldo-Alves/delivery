@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crie sua Empresa
                    <span class="float-right">{{ isset($empresa->nome) ? isset($empresa->id) : '' }}</span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="">
                        {{ csrf_field() }}
                        <input type="hidden" value="put" name="_method">
                        <div class="form-group">
                            <label class="col-form-label" for="cnpj">Cnpj</label>
                            <input class="form-control" type="text" name="cnpj">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="nome">Nome</label>
                            <input class="form-control" type="text" name="nome">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="nome">Descrição</label>
                            <textarea class="form-control" type="text" name="descricao"></textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="nome">Logo</label>
                            <input class="form-control" type="text" name="logo">
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
