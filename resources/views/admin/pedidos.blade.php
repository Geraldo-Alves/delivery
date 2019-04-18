@extends('layouts.admin')

@section('content')

    <link href="{{ asset('css/tabstyle.css') }}" rel="stylesheet">
<div class="container">
    <input type="hidden" id="csrf_token" value="{{  csrf_token() }}">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Pedidos</div>

                <div id="pedidos">

                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        $csrf_token = document.getElementById("csrf_token").value;
        window.csrf_token = $csrf_token;
    </script>
@endsection
