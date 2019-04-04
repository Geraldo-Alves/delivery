@extends('layouts.app')

@section('content')

    <link href="{{ asset('css/tabstyle.css') }}" rel="stylesheet">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Produtos e Categorias
                    <span class="float-right">{{ isset($empresa->nome) ? isset($empresa->nome) : '' }}</span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <!-- Tab links -->
                        <div class="tab">
                            @foreach($categorias as $categoria)
                                <button class="tablinks" onclick="produtos(event, {{$categoria->id_categoria}})">{{$categoria->nome}}</button>
                            @endforeach
                        </div>

                        <!-- Tab content -->
                        <div id="2" class="tabcontent">
                            <h3>London</h3>
                            <p>London is the capital city of England.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function produtos(evt, id_categoria) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
@endsection
