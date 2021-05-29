@extends('admin.layout.master')

@section('style')
@endsection

@section('content')

<div class="col-md-6 offset-md-2">
<div class="card">
<div class="card-header"><h4> compare Spends  of {{$year1}} and {{$year2}} by {{$namevalue}}.</h4></div><div class="card-body">
<canvas id="myChart" style="width:500px; height:300px; font-size:20px;"></canvas>
</div></div>
</div>








@endsection

@section('script')
<script>
    var year1 =<?php echo $name1; ?>;
    
    
    var data_amount1 = <?php echo $value1; ?>;
    var data_amount2 = <?php echo $value2; ?>;

    var barChartData = {
        labels: year1,
        datasets: [{
            label: 'spends of <?php echo $year1; ?>',
            backgroundColor: "rgba(151,187,205,0.5)",
            data: data_amount1
        },
        {
            label: 'spends of <?php echo $year2; ?>',
            backgroundColor: "rgba(200,0,0,0.5)",
            data: data_amount2
        }]
    };


    window.onload = function() {
        var ctx = document.getElementById("myChart").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    },
                },
                
                responsive: true,
                title: {
                    display: true,
                    text: 'comparison of two year Spend by <?php echo $namevalue; ?>'
                }
            }
        });


    };
</script>

@endsection