@extends('layouts.app')

@section('content')
{{-- <div class="container"> --}}
<section class="col-lg-12 connectedSortable">
    <div class="card card-primary card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                        href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                        aria-selected="true">Dashboard 1</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                        href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                        aria-selected="false">Dashboard 2</a>
                </li>

            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                    aria-labelledby="custom-tabs-one-home-tab">
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
                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                    aria-labelledby="custom-tabs-one-profile-tab" style="position: relative;">
                    {{-- <div class="row"> --}}
                    <!-- Left col -->
                    <div class="row">
                        <!-- Left col -->
                        @include('dashboard.penghasil')
                        {{-- @include('dashboard.unit_kerja_penghasil') --}}


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

<script>
    $(document).ready(function () {
        // $('#period').daterangepicker()
        var cair = createPieChart(document.getElementById('cair'), "Cair", 0)
        var sludge = createPieChart(document.getElementById('sludge'), "Sludge", 1)
        var sk = createPieChart(document.getElementById('sk'), "Sampah Kontaminasi", 2)
        $('#period').datepicker({
            uiLibrary: 'bootstrap4',
            todayHighlight: true,
            format: "mm/yyyy",
            defaultDate: new Date(),
            viewMode: "months",
            minViewMode: "months"
        });
        $('#period').val(moment().format('MM/YYYY'))

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


        function createPieChart(ctx, title, meta) {

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
        var myChart = new Chart(document.getElementById("penghasil_all"), {
                type: 'bar',
                data: {
                    labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
                        "Agustus",
                        "September", "Oktober", "November", "Desember"
                    ],
                    datasets: [{
                            label: "Jumlah Limbah",
                            backgroundColor: "#007bff",
                            data: ''
                        },
                         
                    ]
                },
                options: {
                 
                }
            });
         
        var tps1 = createGauge('tps1', 'TPS I', 'm3', 'kapasitas', 150, 20, 75, 120)

        var tps2 = createGauge('tps2', 'TPS II', 'JB', 'kapasitas', 125, 20, 65, 90)

        var tps3 = createGauge('tps3', 'TPS III', 'JB', 'kapasitas', 125, 20, 65, 90)

        var tps4 = createGauge('tps4', 'TPS IV', '-', 'kapasitas', 50955, 50, 30000, 45000)

        var tps5 = createGauge('tps5', 'Kolam Limbah Cair', '-', 'kapasitas', 250, 40, 150, 220)


        // var tps6 = createGauge('tps6','TPS VI','m3','kapasitas')


        function createGauge(id, title, satuan, satuan2, maxkapasitas, thicklength, save, warning) {
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
                exporting: {
                    enabled: false
                },
                credits: {
                    enabled: false
                },

                // the value axis
                yAxis: {
                    min: 0,
                    max: maxkapasitas,

                    minorTickInterval: 'auto',
                    minorTickWidth: 2,
                    minorTickLength: 10,
                    minorTickPosition: 'inside',
                    minorTickColor: '#666',

                    tickPixelInterval: thicklength,
                    tickWidth: 1,
                    tickPosition: 'inside',
                    tickLength: 15,
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
                        to: save,
                        color: '#55BF3B' // green
                    }, {
                        from: save,
                        to: warning,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: warning,
                        to: maxkapasitas,
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
        var paramData = {

            period: $('#period').val(),
            unit_kerja: $('#limbahasal').val(),
            namalimbah:$('#namalimbah').val()
        }
        getDataGrafik(paramData)
        
        $('#limbahasal').on('change', function () {
            var paramData = {

                period: $('#period').val(),
                unit_kerja: $('#limbahasal').val(),
                namalimbah:$('#namalimbah').val()
            }
            getDataGrafik(paramData)
            // updateChart(chart, value,paramData)

        })
        $('#period').on('change', function () {
            var paramData = {
                period: $('#period').val(),
                unit_kerja: $('#limbahasal').val(),
                namalimbah:$('#namalimbah').val()
            }
            getDataGrafik(paramData)
            // updateChart(chart, value,paramData)

        })
        $('#namalimbah').on('change', function () {
            var paramData = {
                period: $('#period').val(),
                unit_kerja: $('#limbahasal').val(),
                namalimbah:$('#namalimbah').val()
            }
            getDataGrafik(paramData)
            // updateChart(chart, value,paramData)

        })


        function updateChart(chart, value, paramData) {
            if (!chart.renderer.forExport) {
                var point = chart.series[0].points[0]
                point.update(value)

                 
            }
        }

        function getDataGrafik(paramData) {

            $.ajax({
                url: "{{ route('dashboard.data') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "accept": "application/json",
                    "Access-Control-Allow-Origin": "*"
                },
                data: paramData,
                dataType: "json",

                success: function (data) {
                    var dataPenghasil = data.dataPenghasil
                    var dataKuota = data.dataKuota
                    var dataKapasitas = data.dataKapasitas
                    var dataKadaluarsa = data.dataKadaluarsa 

                    updateData(cair, ["Konsumsi", "Sisa"], [dataKuota[0].konsumsi, dataKuota[0]
                        .sisa])
                    updateData(sludge, ["Konsumsi", "Sisa"], [dataKuota[1].konsumsi, dataKuota[1]
                        .sisa
                    ])
                    updateData(sk, ["Konsumsi", "Sisa"], [dataKuota[2].konsumsi, dataKuota[2].sisa])
                    updateDataBar(myChart, dataPenghasil)

                    updateChart(tps1, dataKapasitas[0].saldo, 150)
                    updateChart(tps2, dataKapasitas[1].saldo, 125)
                    updateChart(tps3, dataKapasitas[2].saldo, 125)
                    updateChart(tps4, dataKapasitas[3].saldo, 50955)
                    updateChart(tps5, dataKapasitas[4].saldo, 250)
                    
                }
            });
        }

        $('#datakadaluarsa').DataTable({
                ajax: {
                url: "{{ route('dashboard.kadaluarsa') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {}
            },
                columns: [{
                        data: "namalimbah",
                        name:"namalimbah"
                    },
                    {
                        data: "jumlah",
                        name:"jumlah",
                        

                    },
                    {
                        data: "created_at",
                        name:"created_at",
                        render: function (data, type, row) {

                            if (data == null || data == "-" || data == "0000-00-00 00:00:00" || data == "NULL") {
                                // console.log(data)    
                                return '<span>-</span>'

                            } else {
                                return moment(data).format('DD/MM/YYYY');
                            }


                        }

                    },
                    {
                        data: "kadaluarsa",
                        name:"kadaluarsa",
                        render: function (data, type, row) {
                            if (data == null || data == "-" || data ==
                                "0000-00-00 00:00:00" ||
                                data == "NULL") {
                                return '<span>-</span>'
                            } else {
                                return moment(data).format('DD/MM/YYYY');
                            }

                        }
                    },
                    {
                        data: "namatps",
                        name:"namatps"
                    },
                    {
                        data: "jumlah",
                        name:"jumlah"
                    },
                    {
                        data: "kadaluarsa",
                        name:"kadaluarsa",
                        render: function (data, type, row) {
                            var curDate = moment().format('DD')
                            var curMonth = moment().format('MM')
                            var curYear = moment().format('YYYY')
                            var date3 = moment(curDate, 'DD/MM/YYYY').add(3,
                                'days');
                            var date7 = moment(curDate, 'DD/MM/YYYY').add(7,
                                'days');

                            var a = moment([curYear, curMonth, curDate]);
                            var b = moment([moment(data).format('YYYY'), moment(
                                    data).format('MM'), moment(data)
                                .format('DD')
                            ]);
                            var difference = b.diff(a, 'days') // 1
                            //diff di query berbeda dengan dif di moment js
                            
                            if (difference == 4) {
                                return '<span class="badge badge-danger">Bahaya</span>'
                            } else if(difference == 8) {
                                return '<span class="badge badge-warning">Waspada</span>'
                            }else{
                                return '-'
                            }

                        }

                    }
                ]
            })
        

        function updateData(chart, labels, data) {
            chart.data.labels = labels
            chart.data.datasets[0].backgroundColor = ["#f44336", "#4caf50"]
            chart.data.datasets[0].data = data
            chart.update();
        }

        function updateDataBar(chart, data) {
            // chart.data.labels = labels
            // chart.data.datasets[0].backgroundColor = ["#ff5722"]
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
