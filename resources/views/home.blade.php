@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/tabstyle_home.css') }}" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12" id="home">

        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="/payment">Pagamentos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
