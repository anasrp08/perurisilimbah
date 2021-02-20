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
                        aria-selected="true">Dashboard Kuota & Kapasitas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                        href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                        aria-selected="false">Dashboard Penghasil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-mutasi-tab" data-toggle="pill"
                        href="#custom-tabs-one-mutasi" role="tab" aria-controls="custom-tabs-one-mutasi"
                        aria-selected="false">Dashboard Neraca</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-kadaluarsa-tab" data-toggle="pill"
                        href="#custom-tabs-one-kadaluarsa" role="tab" aria-controls="custom-tabs-one-kadaluarsa"
                        aria-selected="false">Daftar Kadaluarsa</a>
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

                    <div class="row">
                        @include('dashboard.penghasil')


                    </div>
                    <div class="row">

                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-mutasi" role="tabpanel"
                    aria-labelledby="custom-tabs-one-mutasi-tab" style="position: relative;">

                    <div class="row">
                        @include('dashboard.graf_mutasi')


                    </div>

                </div>
                <div class="tab-pane fade" id="custom-tabs-one-kadaluarsa" role="tabpanel"
                    aria-labelledby="custom-tabs-one-kadaluarsa-tab" style="position: relative;">

                    <div class="row">
                        @include('dashboard.kadaluarsa')


                    </div>

                </div>




            </div>
        </div>


</section>

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
        var abu= createPieChart(document.getElementById('abu'), "Sampah Abu", 2)
        var lamputl = createPieChart(document.getElementById('lamputl'), "Sampah Lampu TL, Catridge Printer, PCB", 2)
        var namalimbah = null
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('#tahun').val(moment().format('YYYY')).change()
        $('#tahun_kuota').val(moment().format('YYYY')).change()
        $('#tahun_neraca').val(moment().format('YYYY')).change()
        var paramKuota = {

            period: $('#tahun_kuota').val()
        }
        getDataKuota(paramKuota)

        $('#display_penghasil').click(function () {
            var paramData = {

                period: $('#tahun').val(),
                unit_kerja: $('#limbahasal').val(),
                namalimbah: $('#namalimbah').val()
            } 
            getDataPenghasil(paramData)
        })
        $('#display_kuota').click(function () {
            var paramData = {

                period: $('#tahun_kuota').val()
            }
            getDataKuota(paramData)
        })
        $('#display_neraca').click(function () {
            var paramData = {

                period: $('#tahun_neraca').val(),
                namalimbah: $('#namalimbah_neraca').val()
            }
            getDataNeraca(paramData)
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
        var satuanNeraca=null
        var chartNeraca = new Chart(document.getElementById("graf_mutasi"), {
            type: 'bar',
            data: {
                labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
                    "Agustus",
                    "September", "Oktober", "November", "Desember"
                ],
                datasets: [{
                        label: "Masuk",
                        backgroundColor: "#007bff",
                        data: ''
                    },
                    {
                        label: "Keluar",
                        backgroundColor: "#28a745",
                        data: ''
                    },
                    {
                        label: "Sisa",
                        backgroundColor: "#dc3545",
                        data: ''
                    }

                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                                

                                return value + ' ' + satuanNeraca;
                            }
                        }
                    }]
                },
                // tooltips: {
                //     callbacks: {
                //         // title: function (tooltipItem, data) {
                //         //     return data['labels'][tooltipItem[0]['index']];
                //         // },
                //         label: function (tooltipItem, data) {
                //             var formattedjumlah = data['datasets'][0]['data'][tooltipItem['index']]
                //             // console.log(namalimbah)
                //             // var finalValue = null
                //             // var satuan = null
                //             // if (namalimbah == 1 || namalimbah == 2 || namalimbah == 3 ||
                //             //     namalimbah == 17 || namalimbah == 20) {
                //             //     finalValue = parseInt(formattedjumlah) / parseInt(1000)
                //             //     satuan = 'm3'
                //             // } else {
                //             //     finalValue = parseInt(formattedjumlah) / parseInt(1000)
                //             //     satuan = 'ton'
                //             // }
                //             console.log(tooltipItem)
                //             return data + ' ' + satuanNeraca
                //             // return data['datasets'];
                //         },
                //         // afterLabel: function (tooltipItem, data) {
                //         //     var dataset = data['datasets'][0];


                //         //     return "Presentase: " + '(' + dataset + '%)';
                //         //     // return data;
                //         // }
                //     },

                // }
            }
        });
        var satuanDashboard=null
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
                scales: {
                    yAxes: [{
                        ticks: {
                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                                var finalValue = null
                                var satuan = null
                                // if (namalimbah == 1 || namalimbah == 2 || namalimbah == 3 ||
                                //     namalimbah == 17 || namalimbah == 20) {
                                //     // finalValue=parseInt(formattedjumlah) / parseInt(1000)
                                //     satuan = 'm3'
                                // } else {
                                //     // finalValue=parseInt(formattedjumlah) / parseInt(1000)
                                //     satuan = 'ton'
                                // }

                                return value + ' ' + satuanDashboard;
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        // title: function (tooltipItem, data) {
                        //     return data['labels'][tooltipItem[0]['index']];
                        // },
                        label: function (tooltipItem, data) {
                            var formattedjumlah = data['datasets'][0]['data'][tooltipItem['index']]
                            console.log(namalimbah)
                            var finalValue = null
                            var satuan = null
                            if (namalimbah == 1 || namalimbah == 2 || namalimbah == 3 ||
                                namalimbah == 17 || namalimbah == 20) {
                                finalValue = parseInt(formattedjumlah) / parseInt(1000)
                                satuan = 'm3'
                            } else {
                                finalValue = parseInt(formattedjumlah) / parseInt(1000)
                                satuan = 'ton'
                            }
                            return formattedjumlah + ' ' + satuan
                            // return data['datasets'];
                        },
                        // afterLabel: function (tooltipItem, data) {
                        //     var dataset = data['datasets'][0];


                        //     return "Presentase: " + '(' + dataset + '%)';
                        //     // return data;
                        // }
                    },

                }
            }
        });


        var tps1 = createGauge('tps1', 'TPS B3 I', 'm2', 'Kapasitas', 540, 50, 405, 486)

        var tps2 = createGauge('tps2', 'TPS ABU', 'm3', 'Kapasitas', 72, 30, 54, 65)

        var tps3 = createGauge('tps3', 'TPS CAIR', 'm3', 'Kapasitas', 230, 30, 173, 207)

        var tps4 = createGauge('tps4', 'TPS SK, Sludge, Bata', 'm2', 'kapasitas', 228, 30, 171, 205)

        // var tps5 = createGauge('tps5', 'Kolam Limbah Cair', '-', 'kapasitas', 250, 40, 150, 220)


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
        var paramKapasitas = {

            period:moment().format('YYYY'), 

        }
        getDataKapasitas(paramKapasitas)

        function updateChart(chart, value, paramData) {
            if (!chart.renderer.forExport) {
                var point = chart.series[0].points[0]
                point.update(value)


            }
        }

        function getDataNeraca(paramData) {
            $.ajax({
                url: "{{ route('dashboard.neraca') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "accept": "application/json",
                    "Access-Control-Allow-Origin": "*"
                },
                data: paramData,
                dataType: "json",

                success: function (data) {
                    console.log(data)
                    var saldoMasuk = data.saldoMasuk
                    var saldoKeluar = data.saldoKeluar
                    var sisaSaldo = data.sisaSaldo
                    satuanNeraca = data.satuan.satuan
                    chartNeraca.data.datasets[0].data = saldoMasuk
                    chartNeraca.data.datasets[1].data = saldoKeluar
                    chartNeraca.data.datasets[2].data = sisaSaldo
                    chartNeraca.update();


                }
            });
        }

        function getDataKuota(paramData) {
            $.ajax({
                url: "{{ route('dashboard.kuota') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "accept": "application/json",
                    "Access-Control-Allow-Origin": "*"
                },
                data: paramData,
                dataType: "json",

                success: function (data) {
                    var dataKuota = data.dataKuota

                    updateData(cair, ["Konsumsi", "Sisa"], [dataKuota[0].konsumsi, dataKuota[0].sisa
                    ])
                    updateData(sludge, ["Konsumsi", "Sisa"], [dataKuota[1].konsumsi, dataKuota[1].sisa
                    ])
                    updateData(sk, ["Konsumsi", "Sisa"], [dataKuota[2].konsumsi, dataKuota[2].sisa])
                    updateData(sk, ["Konsumsi", "Sisa"], [dataKuota[2].konsumsi, dataKuota[2].sisa])
                    updateData(sk, ["Konsumsi", "Sisa"], [dataKuota[2].konsumsi, dataKuota[2].sisa])

                }
            });
        }

        function getDataPenghasil(paramData) {

            $.ajax({
                url: "{{ route('dashboard.penghasil') }}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "accept": "application/json",
                    "Access-Control-Allow-Origin": "*"
                },
                data: paramData,
                dataType: "json",

                success: function (data) {  
                    console.log(data)
                    var dataPenghasil=data.dataPenghasil
                    satuanDashboard=data.satuan.satuan
                    updateDataBar(myChart, dataPenghasil)  
                }
            });
        }

        function getDataKapasitas(paramData) {

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
                    console.log(data)
                    var dataKapasitas = data.dataKapasitas 
                    updateChart(tps1, dataKapasitas[0].saldo, dataKapasitas[0].kapasitasjumlah)
                    updateChart(tps2, dataKapasitas[1].saldo, dataKapasitas[1].kapasitasjumlah)
                    updateChart(tps3, dataKapasitas[2].saldo, dataKapasitas[2].kapasitasjumlah)
                    updateChart(tps4, dataKapasitas[3].saldo, dataKapasitas[3].kapasitasjumlah)
                    // updateChart(tps5, dataKapasitas[4].saldo, dataKapasitas[4].kapasitasjumlah)

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
                    name: "namalimbah"
                },
                {
                    data: "jumlah",
                    name: "jumlah",


                },
                {
                    data: "created_at",
                    name: "created_at",
                    render: function (data, type, row) {

                        if (data == null || data == "-" || data == "0000-00-00 00:00:00" ||
                            data == "NULL") {
                            // console.log(data)    
                            return '<span>-</span>'

                        } else {
                            return moment(data).format('DD/MM/YYYY');
                        }


                    }

                },
                {
                    data: "created_at",
                    name: "created_at",
                    render: function (data, type, row) {


                        return moment().format('DD/MM/YYYY');



                    }

                },
                {
                    data: "kadaluarsa",
                    name: "kadaluarsa",
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
                    name: "namatps"
                },

                {
                    data: "kadaluarsa",
                    name: "kadaluarsa",
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

                        if (difference == 3) {
                            return '<span class="badge badge-danger">Bahaya</span>'
                        } else if (difference == 7) {
                            return '<span class="badge badge-warning">Waspada</span>'
                        } else {
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
