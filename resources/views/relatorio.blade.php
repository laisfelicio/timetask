@extends('layouts.base', ["current" => "Usuarios"])

@section('body')
<div class = "card border">
    <div class = "card-body">
        <h5 class = "card-title"> Relatórios </h5>
        
        <div class="card border-dark" style = "height: 500px; width: 500px">
            <canvas id="myChart"></canvas>
        </div>
        
    </div>
</div>
@endsection

@section('javascript')
<script>
    
    
    var statusG = @json($status);
    var totais = {!! json_encode($totais) !!};
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: statusG,
            datasets: [{
                data: totais,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
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
            maintainAspectRatio: false
        }
    });
    </script>
@endsection