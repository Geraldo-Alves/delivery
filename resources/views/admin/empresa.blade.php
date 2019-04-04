@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Sua Empresa
                    <span class="float-right">{{ isset($empresa->nome) ? isset($empresa->nome) : '' }}</span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="put" action="empresa">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-form-label" for="nome">Nome</label>
                            <input class="form-control" type="text" name="nome" value="{{ $empresa->nome }}">
                        </div>
                    </form>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
