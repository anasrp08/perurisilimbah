@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
    <section class="col-lg-12 connectedSortable">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
              <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Dashboard 1</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Dashboard 2</a>
                </li>
                
              </ul>
            </div>
            <div class="card-body">
              <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    <div class="row">
                        <!-- Left col -->
                        @include('dashboard.kuotalimbah')
                
                        {{-- @include('dashboard.kadaluarsa') --}}
                
                    </div>
                    <div class="row">
                        <!-- Left col -->
                        @include('dashboard.kapasitastps')
                
                
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab" style="position: relative;">
                    {{-- <div class="row"> --}}
                        <!-- Left col -->
                        <div class="row">
                            <!-- Left col -->
                            @include('dashboard.penghasil')
                    
                    
                        </div>
                        <div class="row">
                            <!-- Left col -->
                            @include('dashboard.kadaluarsa')
                    
                    
                        </div>
                        
                        
                
                    {{-- </div> --}}
                </div>
               

                
                 
              </div>
            </div>
            <!-- /.card -->

    {{-- <div class="card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="fas fa-chart-pie mr-1"></i>
            {{-- Dashboard Kapasitas & Kuota 
          </h3>
          <div class="card-tools">
            <ul class="nav nav-pills ml-auto">
              <li class="nav-item">
                <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Kapasitas</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#sales-chart" data-toggle="tab">Kadaluarsa</a>
              </li>
            </ul>
          </div>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content p-0">
            <!-- Morris chart - Sales -->
            <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                 <div class="row">
                    <!-- Left col -->
                    @include('dashboard.kuotalimbah')
             
            
                </div>
            
                <div class="row">
                    <!-- Left col -->
                    @include('dashboard.kapasitastps')
            
            
                </div>
                 
             </div>
            <div class="chart tab-pane" id="sales-chart" style="position: relative;">
                <div class="row">
                    <!-- Left col -->
                    @include('dashboard.penghasil')
            
                </div>
            </div>  
          </div>
        </div><!-- /.card-body -->
      </div> --}}
   
    
    </section>
{{-- </div> --}}

@endsection
@section('scripts')
<script src="{{ asset('/adminlte3/chartjs/Chart.bundle.min.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    $(document).ready(function () {

        // var ctx = document.getElementById('cair');
        var cair = createPieChart(document.getElementById('cair'), "Cair",0)
        var sludge = createPieChart(document.getElementById('sludge'), "Sludge",1)
        var sk = createPieChart(document.getElementById('sk'), "Sampah Kontaminasi",2)


        function createPieChart(ctx, title,meta) {

            return new Chart(ctx, {
                type: 'pie',
                data: {
                    // labels: ["Polos", "Ada"],
                    labels: '',
                    datasets: [{
                        // backgroundColor: ["#3e95cd", "#9c27b0", "#3cba9f", "#ffeb3b", "#ff5722"], 
                        backgroundColor: '',
                        data: ''
                    }]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: title
                    },
                    legend: {
                        position: 'bottom',
                    },
                    tooltips: {
                        callbacks: {
                            title: function (tooltipItem, data) {
                                return data['labels'][tooltipItem[0]['index']];
                            },
                            label: function (tooltipItem, data) {
                                // console.log(data)

                                var jumlah = data['datasets'][0]['data'][tooltipItem['index']]

                                var formattedjumlah = thousands_separators(jumlah)

                                var data = "Jumlah: " + formattedjumlah 
                                return data
                                // return data['datasets'];
                            },
                            afterLabel: function (tooltipItem, data) {
                                var dataset = data['datasets'][0];
                                // console.log(dataset['data'][tooltipItem['index']])
                                var percent = Math.round((dataset['data'][tooltipItem['index']] /
                                    dataset["_meta"][meta]['total']) * 100)
                                return "Presentase: " + '(' + percent + '%)';
                                // return data;
                            }
                        },

                        titleFontSize: 16,
                        bodyFontSize: 14,
                        displayColors: true
                    }

                }
            });
        }
        var ctx = document.getElementById("penghasil").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Seksi Proof", "Laboratorium", "Seksi Utilitas", "Seksi Cetak Nomor",
                    "Seksi Cetak Dalam", "Seksi Cetak Rata", "Seksi Pengamanan Elektronik",
                    "Seksi Penataan Hasil", "Seksi PPIC"
                ],
                datasets: [{
                        label: 'Sludge',
                        backgroundColor: "#caf270",
                        data: [12, 59, 5, 56, 58, 12, 59, 87, 45],
                    }, {
                        label: 'Abu',
                        backgroundColor: "#45c490",
                        data: [12, 59, 5, 56, 58, 12, 59, 85, 23],
                    }, {
                        label: 'Limbah cair',
                        backgroundColor: "#008d93",
                        data: [12, 59, 5, 56, 58, 12, 59, 65, 51],
                    }, {
                        label: 'Kaleng',
                        backgroundColor: "#007bff",
                        data: [12, 59, 5, 56, 58, 12, 59, 12, 74],
                    },
                    {
                        label: 'Sampah Kontaminasi',
                        backgroundColor: "#ffc107",
                        data: [12, 59, 5, 56, 58, 12, 59, 12, 74],
                    },
                    {
                        label: 'Drum',
                        backgroundColor: "#6610f2",
                        data: [12, 59, 5, 56, 58, 12, 59, 12, 74],
                    }
                ],
            },
            options: {
                tooltips: {
                    displayColors: true,
                    callbacks: {
                        mode: 'x',
                    },
                },
                scales: {
                    xAxes: [{
                        stacked: true,
                        gridLines: {
                            display: false,
                        }
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                        },
                        type: 'linear',
                    }]
                },
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    position: 'bottom'
                },
            }
        });

        var tps1 = createGauge('tps1','TPS I','m3','kapasitas')
        updateChart(tps1)
        var tps2 = createGauge('tps2','TPS II','m3','kapasitas')
        updateChart(tps2)
        var tps3 = createGauge('tps3','TPS III','m3','kapasitas')
        updateChart(tps3)
        var tps4 = createGauge('tps4','TPS IV','m3','kapasitas')
        updateChart(tps4)
        var tps5 = createGauge('tps5','TPS V','m3','kapasitas')
        updateChart(tps5)
        var tps6 = createGauge('tps6','TPS VI','m3','kapasitas')
        updateChart(tps6)

        function createGauge(id,title,satuan,satuan2) {
            return Highcharts.chart(id, {

                    chart: {
                        type: 'gauge',
                        plotBackgroundColor: null,
                        plotBackgroundImage: null,
                        plotBorderWidth: 0,
                        plotShadow: false
                    },

                    title: {
                        text: title
                    },

                    pane: {
                        startAngle: -90,
                        endAngle: 90,
                        background: null
                    },
                    exporting: { enabled: false },
                    credits: {
    enabled: false
},

                    // the value axis
                    yAxis: {
                        min: 0,
                        max: 200,

                        minorTickInterval: 'auto',
                        minorTickWidth: 1,
                        minorTickLength: 10,
                        minorTickPosition: 'inside',
                        minorTickColor: '#666',

                        tickPixelInterval: 30,
                        tickWidth: 2,
                        tickPosition: 'inside',
                        tickLength: 10,
                        tickColor: '#666',
                        labels: {
                            step: 2,
                            rotation: 'auto'
                        },
                        title: {
                            text: satuan2
                        },
                        plotBands: [{
                            from: 0,
                            to: 120,
                            color: '#55BF3B' // green
                        }, {
                            from: 120,
                            to: 160,
                            color: '#DDDF0D' // yellow
                        }, {
                            from: 160,
                            to: 200,
                            color: '#DF5353' // red
                        }]
                    },

                    series: [{
                        name: satuan2,
                        data: [80],
                        tooltip: {
                            valueSuffix: satuan
                        }
                    }]
            })
        }

            
            function updateChart(chart) {
                if (!chart.renderer.forExport) {
                    setInterval(function () {
                        var point = chart.series[0].points[0],
                            newVal,
                            inc = Math.round((Math.random() - 0.5) * 20);

                        newVal = point.y + inc;
                        if (newVal < 0 || newVal > 200) {
                            newVal = point.y - inc;
                        }

                        point.update(newVal);

                    }, 3000);
                }
            }

            

        updateData(cair, ["Terpakai", "Sisa"], [5000000000, 2000000000])
        updateData(sludge, ["Terpakai", "Sisa"], [1100000000, 10000000])
        updateData(sk, ["Terpakai", "Sisa"], [390000000, 720000000])

        function updateData(chart, labels, data) {
            chart.data.labels = labels
            chart.data.datasets[0].backgroundColor = ["#f44336", "#4caf50"]
            chart.data.datasets[0].data = data
            chart.update();
        }

        function thousands_separators(num) {
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return num_parts.join(".");

        }
        // updateData(cair, ["Polos", "Ada"], [dataPieChart[0],dataPieChart[1]])
    })

</script>
@endsection
