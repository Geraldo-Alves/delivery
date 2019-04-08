@extends('layouts.admin')

@section('content')

    <link href="{{ asset('css/tabstyle.css') }}" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Produtos por Categorias
                    <span class="float-right">{{ isset($empresa) ? $empresa->nome : '' }}</span>
                </div>

                <!-- content -->
                <div id="categoria_produtos" class="">

                </div>

                <input type="hidden" id="csrf_token" value="{{csrf_token()}}">
            </div>
        </div>
    </div>
</div>
    <script>
        $csrf_token = document.getElementById("csrf_token").value;
        window.csrf_token = $csrf_token;
    </script>
@endsection
