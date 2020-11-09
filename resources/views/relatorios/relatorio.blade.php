@extends('layouts.baseAt', ["current" => "relatorios", "titulo" => "Relatórios"])

@section('body')
<div class = "card border">
    <div class="card-header card-header-text card-header-rose">
        <div class="card-text">
          <h4 class="card-title">Relatórios</h4>
        </div>
    </div>
    <div class = "card-body">
        <div class = "row">
            <div class="col-sm-6">
                <div class="card border-dark" style = "height: 400px; width: 400px">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Projetos/Status</h4>
                    </div>
                    <div class = "card-body">
                        <canvas id="graficoProjetoStatus"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="card border-dark" style = "height: 400px; width: 400px">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Tarefa/Status</h4>
                    </div>
                    <div class = "card-body">
                        <canvas id="graficoTarefaStatus"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class = "row">
            <div class="col-sm-12">
                <div class="card border-dark" style = "height: 400px; width: 400px">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Finalizados/Mes</h4>
                    </div>
                    <div class = "card-body">
                        <canvas id="graficoFinalizadasMes"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

@section('javascript')
<script>
    
    
    var statusG = @json($statusProjetos);
    var totais = {!! json_encode($totaisProjetos) !!};
    var ctx = document.getElementById('graficoProjetoStatus').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        scaleLabel: {
            display:false
        },
        data: {
            
            labels: statusG,
            datasets: [{
                label: 'Quantidade de projetos',
                data: totais,
                backgroundColor: [
                    'rgba(13, 118, 0, 0.2)',
                    'rgba(204, 51, 255, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 0, 102, 0.2)'
                ],
                borderColor: [
                    'rgba(13, 118, 0, 1)',
                    'rgba(204, 51, 255, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 0, 102, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legends:{
                display:false
            },
            maintainAspectRatio: false
        }
    });

    var statusG = @json($statusTarefas);
    var totais = {!! json_encode($totaisTarefas) !!};
    var ctx = document.getElementById('graficoTarefaStatus').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        scaleLabel: {
            display:false
        },
        data: {
            
            labels: statusG,
            datasets: [{
                label: 'Quantidade de tarefas',
                data: totais,
                backgroundColor: [
                    'rgba(13, 118, 0, 0.2)',
                    'rgba(204, 51, 255, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 0, 102, 0.2)'
                ],
                borderColor: [
                    'rgba(13, 118, 0, 1)',
                    'rgba(204, 51, 255, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 0, 102, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legends:{
                display:false
            },
            maintainAspectRatio: false
        }
    });


    var statusG = @json($meses);
    var totais = {!! json_encode($totaisEntregues) !!};
    var ctx = document.getElementById('graficoFinalizadasMes').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        scaleLabel: {
            display:false
        },
        data: {
            
            labels: statusG,
            datasets: [{
                label: 'Quantidade de tarefas entregues',
                data: totais,
                backgroundColor: [
                    'rgba(13, 118, 0, 0.2)'
                ],
                borderColor: [
                    'rgba(13, 118, 0, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            legends:{
                display:false
            },
            maintainAspectRatio: false
        }
    });
    </script>
@endsection