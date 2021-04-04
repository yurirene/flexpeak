<html lang="pt-br">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
        @yield('css')
        <title>Fábrica de Perfumes</title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <a class="navbar-brand" href="#">Perfumaria</a>
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{route("report.index")}}">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("inventory.index")}}">Estoque</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("operation.index")}}">Operações do Estoque</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("recipe.index")}}">Fórmulas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("production.index")}}">Produção</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("report.report")}}">Relatórios</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container">
            <div class="row mt-5 mb-5">
                <div class="col-md-8 mx-auto">
                    @if($errors->any())
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                            
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if(session('message'))
                    <div class="alert alert-{{session('type')}} alert-dismissible" role="alert">
                        {{session('message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-md-12 mx-auto">
                    @yield('content')
                </div>
            </div>
            
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
        <script src="/js/jquery.mask.js" ></script>
        <script src="/js/main.js" ></script>
        @yield('script')
    </body>
</html>