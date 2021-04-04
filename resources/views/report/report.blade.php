@extends('_template')
@section('css')
<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
@endsection
@section('content')

<div class="row mb-5">
    <div class="col-md-6 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="text-center">Filtrar por Data</h4>
                <form action="{{route("report.reportwithdate")}}" method="POST">
                    @csrf
                    <div class="form-inline input-daterange justify-content-center">
                        <input type="text" 
                               class="form-control datepicker col-md-3" 
                               name="start" 
                               value="{{$date['start']}}" required>
                        <div class="input-group-addon p-2"> Até </div>
                        <input type="text" 
                               class="form-control datepicker col-md-3" 
                               name="end"
                               value="{{$date['end']}}">
                        <button type="submit" class="btn btn-info ml-1">Filtrar</button>
                        <a href="{{route("report.report")}}" class="btn btn-danger ml-1">Limpar</a>
                    </div>                    
                </form>
            </div>
        </div>
        
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                Relatório: Mais Fabricado
            </div>

            <div class="card-body">
                <canvas id="myChart" width="400" style="height:20vh;"></canvas>
                <table class="table table-responsive-md table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">Nome</th>
                            <th scope="col" class="text-center">Volume Produzido</th>
                            <th scope="col" class="text-center">Qtd de Perfumes Fabricados</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mostProduced as $produced)
                        <tr>
                            <td class="text-center">{{$produced['name']}}</td>                    
                            <td class="text-center">{{$produced['volume']}} mL</td>                    
                            <td class="text-center">{{$produced['quantity']}}</td>                    
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center">Sem Dados</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                Relatório: Fragrância mais Usada
            </div>
            <div class="card-body">
                <canvas id="myChart_second" width="400" style="height:20vh;"></canvas>
                <table class="table table-responsive-md table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">Nome</th>
                            <th scope="col">Unidades Fabricadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mostUsedFragrance as $key => $fragrance)
                        <tr>
                            <td>{{$fragrance[0]["fragrance_name"]}}</td>
                            <td>{{$key}}</td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center">Sem Dados</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.1/dist/chart.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="locale/bootstrap-datepicker.pt-BR.min.js"></script>

<script>
$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: 'pt-BR'
});
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($chart["labels"]),
        datasets: [{
            label: 'Volume Fabricado(mL)',
            data: @json($chart["data"]),
            backgroundColor: @json($chart["colors"])
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
var ctx_second = document.getElementById('myChart_second').getContext('2d');
var myChart = new Chart(ctx_second, {
    type: 'bar',
    data: {
        labels: @json($chart_used["labels"]),
        datasets: [{
            label: 'Unidades Fabricadas',
            data: @json($chart_used["data"]),
            backgroundColor: @json($chart_used["colors"])
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>
@endsection