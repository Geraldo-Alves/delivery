@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard
                    <span class="float-right">{{ isset($empresa->nome) ? $empresa->nome : '' }}</span>
                </div>

                <div class="card-body">
                    <a href="admin/empresa">Empresa</a>
                    </a>
                </div>
                <div class="card-body">
                    <a href="admin/produtos">Produtos</a>
                    </a>
                </div>
                <div class="card-body">
                    <a href="produtos">Pedidos</a>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
