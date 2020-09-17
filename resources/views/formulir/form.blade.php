<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title> </title>
</head>

<body>
    <style type="text/css">
        .page-break {
            page-break-after: always;
        }

        table.center {
            margin-left: auto;
            margin-right: auto;
        }

        .table1 {
            border: 2px solid black;
            text-align: center;
            border-collapse: collapse;
        }

        table tr td,
        table tr th {
            font-size: 12pt;

        }

        td.tblbawah {
            border: 2px solid black;
            text-align: center;
            padding: 10px;
            width: 120px;
        }

        div.a {
            text-indent: 30px;
        }

        td.logokanan {
            text-align: right;
            align-content: right;
            padding-left: 50px;
            padding-right: 20px;

        }

        td.logokiri {
            text-align: left;
            align-content: left;
            padding-right: 50px;
            padding-left: 20px;
        }

        td.header {
            font-size: 20pt;
            text-align: center;
            font-weight: bold;

        }

        td.titlecenter {
            font-size: 40pt;
            text-align: center;
            font-weight: bold;

            border: 4px solid #000000;
        }

        td.headerow2left {
            font-size: 13pt;
            text-align: right;
            padding: 10px;
        }

        td.headerow2right {
            font-size: 13pt;
            text-align: left;
            padding: 10px;
        }

        td.headerow3left {
            font-size: 13pt;
            text-align: left;
            padding-bottom: 10px;
        }

        td.headerow3center {
            font-size: 13pt;
            text-align: left;
            padding-bottom: 10px;
        }

        td.headerow3right {
            font-size: 13pt;
            text-align: left;
            padding-bottom: 10px;
        }

        /* garis header */
        hr.new1 {
            border: 1px solid black;
        }

        /* table hasil uji */
        table.hasiluji,
        th.headeruji,
        td.itemuji {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th.headeruji,
        td.itemuji {
            font-size: 12pt;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right: 5px;
            text-align: center;
        }
        td.namalimbah {
            font-size: 12pt;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right: 5px;
            text-align: left;
        }
        td.no {
            font-size: 12pt;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right: 5px;
            /* border: 1px solid black; */
            border-right-style: solid;
            border-right-width: thin;
            border-left-style: solid;
            border-left-width: thin;
            text-align: center;
        }
        td.no {
            font-size: 12pt;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right: 5px;
            /* border: 1px solid black; */
            border-right-style: solid;
            border-right-width: thin;
            border-left-style: inset;
            border-right-width: thin;
            text-align: center;
        }
        td.keterangan {
            font-size: 12pt;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right: 5px;
            /* border: 1px solid black; */
            border-right-style: solid;
            border-right-width: thin;
            
            text-align: left;
        }

        
        td.ttdbottom {
            font-size: 12pt;
            /* padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 10px;
            padding-right: 10px; */
            text-align: left;
            /* border: 1px solid black;
            border-collapse: collapse; */
        }

        td.tblbawah1 {
            border: 2px solid black;
            text-align: center;
            padding: 10px;
            width: 100px;
        }

        td.row3 {
            text-align: justify;
            padding-top: 20px;
            padding-bottom: 10px;

            /* padding: 10px; */

        }

        td.rincian {
            text-align: justify;
            padding-top: 20px;
            padding-bottom: 10px;

            /* padding: 10px; */

        }

        td.row3right {
            text-align: center;
            padding-top: 10px;
            padding-bottom: 10px;
            font-weight: bold;
            /* padding: 10px; */

        }

        td.row2 {
            font-size: 20pt;
            text-align: center;
            font-weight: bold;

        }

        td.row6 {
            font-size: 12pt;
            text-align: right;
            margin-top: 2px;
            /* font-weight: bold; */
            /* vertical-align: baseline; */

        }

        th.ttd {
            font-size: 12pt;
            text-align: center;
            padding-bottom: 100px;
            border: 1px solid black;
            border-collapse: collapse;
            /* font-weight: bold; */
            /* vertical-align: baseline; */

        }

        div.bg-image {
            background-image: url(/img/perurilogo.jpg);
            background-position: center;
            background-size: cover;
        }

        .background {
            position: absolute;
            z-index: 0;
            background: white;
            display: block;
            min-height: 50%;
            min-width: 50%;
            color: yellow;
        }
        .background1 {
            position: absolute;
            z-index: 0;
            background: white;
            display: block; 
            color: yellow;
        }


        #bg-text {
            color: lightgrey;
            font-size: 120px;
            transform: rotate(300deg);
            -webkit-transform: rotate(300deg);
        }

        #content {
            position: absolute;
            z-index: 1;
        }

    </style>

    <div id="background"> 
         <img class='background'src="{{ public_path('/img/perurilogo.jpg') }}" alt="AdminLTE Logo" width="700px" height="800px" 
    style="opacity: .10;margin-top: 100px;">

    <img class='background1' src="{{ public_path('/img/validbiru1.png') }}" alt="AdminLTE Logo" width="250px" height="75px" 
       style="opacity: .5;margin-top: 100px;margin-left:200px;bottom: 150;transform: rotate(-30deg)">
    </div> 
    <div id='content'> 
        <table class="table">
            <tr>
                <td class='logokiri' colspan="4">
                    <img src="{{ public_path('/img/perurilogo.jpg') }}" alt="AdminLTE Logo" width="100px" height="70px"
                        style="opacity: .8">
                </td>
                <td class="titlecenter" colspan="4">
                    FORMULIR
                </td>
                <td class='logokanan' colspan="4">
                    <img src="{{ public_path('/img/SGS.png') }}" alt="AdminLTE Logo" width="120px" height="75px"
                        style="opacity: .8">
                </td>
            </tr>

            <tr>
                <td class="headerow2left" colspan="5">
                    Nomor :
                </td>

                <td class="headerow2right" colspan="4">
                    {{$no_surat}}
                </td>
            </tr>
            <tr>
                <td class="headerow2left" colspan="5">
                    Tanggal :
                </td>

                <td class="headerow2right" colspan="4">
                    {{$tanggal}}
                </td>
            </tr>
        </table>

        <table class="table2">


            <tr>
                <td class="headerow3left" colspan="3">
                    Nama Limbah
                </td>
                <td class="headerow3center" colspan="1">
                    :
                </td>
                <td class="headerow3right" colspan="4">
                    {{$jenislimbah}}
                </td>

            </tr>
            <tr>
                <td class="headerow3left" colspan="3">
                    Jenis Limbah
                </td>
                <td class="headerow3center" colspan="1">
                    :
                </td>
                <td class="headerow3right" colspan="4">
                    {{$jenislimbah}}
                </td>

            </tr>
            <tr>
                <td class="headerow3left" colspan="3">
                    Unit Penghasil Limbah
                </td>
                <td class="headerow3center" colspan="1">
                    :
                </td>
                <td class="headerow3right" colspan="4">
                    {{$penghasil}}
                </td>

            </tr>
            <tr>
                <td class="headerow3left" colspan="3">
                    Dikirim Ke
                </td>
                <td class="headerow3center" colspan="1">
                    :
                </td>
                <td class="headerow3right" colspan="4">
                    {{$dikirimke}}
                </td>

            </tr>
            <tr>
                <td class="headerow3left" colspan="3">
                    Maksud
                </td>
                <td class="headerow3center" colspan="1">
                    :
                </td>
                <td class="headerow3right" colspan="4">
            {{$maksud}}
                </td>

            </tr>
            {{-- <tr>
            <td colspan="4">
                
            </td>
           
        </tr> --}}
        </table>
        <hr class="new1">
       
        <table class="table1" style="width: 100%;">

            <tr>

                <th class="headeruji" style='width:3%;' colspan="1">No.</th>
                <th class="headeruji" colspan="5">Nama Barang</th>
                <th class="headeruji" style='width:15%;' colspan="2">Jumlah</th>
                <th class="headeruji" style='width:20%;' colspan="2">Keterangan</th>


            </tr>
            @foreach($listlimbah as $data)
            <tr>

                <td class="no">{{$loop->iteration}}</td>
                <td class="namalimbah" colspan="5">{{$data->namalimbah}}</td>
                <td class="no" colspan="2">{{$data->jumlah}}</td>
                <td class="keterangan" colspan="2">{{$data->keterangan}}</td>


            </tr>
            @endforeach
            {{$length= 29 - count($listlimbah)}}
            
            @for ($i = 0; $i <$length ; $i++)
            <tr>

                <td class="no"></td>
                <td class="namalimbah" colspan="5"></td>
                <td class="no" colspan="2"></td>
                <td class="keterangan" colspan="2"></td>


            </tr>
@endfor
            {{-- @if(count($listlimbah))
            @endif --}}
            {{-- 14 --}}
            
            

        </table>
        <div style="bottom:50;">
        <table class="table1" style="width: 95,9%;position: absolute;bottom:150;">

            <tr>
                <th class="ttd" colspan="4">Yang Menerima,</th>
                <th class="ttd" colspan="4">Pengawas,</th>
                <th class="ttd" colspan="4">Yang Menyerahkan,</th>

            </tr>
            <tr>
                {{-- <td class="itemuji"> --}}
                <td class="ttdbottom" style=width:1rem;">
                    Nama
                </td>
                <td class="ttdbottom" style=width:0.5rem;">
                    :
                </td>
                <td class="ttdbottom" colspan="2" style=" border-collapse: collapse; border: 1px solid black;">
                    Anas
                </td>
                {{-- </td> --}}
                {{-- <td class="itemuji"> --}}
                <td class="ttdbottom" style=width:1rem;">
                    Nama
                </td>
                <td class="ttdbottom" style=width:0.5rem;">
                    :
                </td>
                <td class="ttdbottom" colspan="2" style=" border-collapse: collapse; border: 1px solid black;">
                    Anas
                </td>
                {{-- </td> --}}
                {{-- <td class="itemuji"> --}}
                <td class="ttdbottom" style=width:1rem;">
                    Nama
                </td>
                <td class="ttdbottom" style=width:0.5rem;">
                    :
                </td>
                <td class="ttdbottom" colspan="2" style=" border-collapse: collapse; border: 1px solid black;">
                    Anas
                </td>
                {{-- </td> --}}

            </tr>
            <tr>
                {{-- <td class="itemuji"> --}}
                <td class="ttdbottom" style=width:1rem;">
                    NP
                </td>
                <td class="ttdbottom" style=width:0.5rem;">
                    :
                </td>
                <td class="ttdbottom" colspan="2" style=" border-collapse: collapse; border: 1px solid black;">
                    {{$ttdPenerima}}
                </td>
                {{-- </td> --}}
                {{-- <td class="itemuji"> --}}
                <td class="ttdbottom" style=width:1rem;">
                    NP
                </td>
                <td class="ttdbottom" style=width:0.5rem;">
                    :
                </td>
                <td class="ttdbottom" colspan="2" style=" border-collapse: collapse; border: 1px solid black;">
                    {{$ttdPengawas}}
                </td>
                {{-- </td> --}}
                {{-- <td class="itemuji"> --}}
                <td class="ttdbottom" style=width:1rem;">
                    NP
                </td>
                <td class="ttdbottom" style=width:0.5rem;">
                    :
                </td>
                <td class="ttdbottom" colspan="2" style=" border-collapse: collapse; border: 1px solid black;">
                    {{$ttdMenyerahkan}}
                </td>
                {{-- </td> --}}

            </tr>
            <tr>
                {{-- <td class="itemuji"> --}}
                <td class="ttdbottom" style=width:1rem;">
                    Unit Kerja
                </td>
                <td class="ttdbottom" style=width:0.5rem;">
                    :
                </td>
                <td class="ttdbottom" colspan="2" style=" border-collapse: collapse; border: 1px solid black;">
                    Seksi Operasional Limbah
                </td>
                {{-- </td> --}}
                {{-- <td class="itemuji"> --}}
                <td class="ttdbottom" style=width:1rem;">
                    Unit Kerja
                </td>
                <td class="ttdbottom" style=width:0.5rem;">
                    :
                </td>
                <td class="ttdbottom" colspan="2" style=" border-collapse: collapse; border: 1px solid black;">
                    Seksi Operasional Limbah
                </td>
                {{-- </td> --}}
                {{-- <td class="itemuji"> --}}
                <td class="ttdbottom" style=width:1rem;">
                    Unit Kerja
                </td>
                <td class="ttdbottom" style=width:0.5rem;">
                    :
                </td>
                <td class="ttdbottom" colspan="2" style=" border-collapse: collapse; border: 1px solid black;">
                    Seksi Operasional Limbah
                </td>
                {{-- </td> --}}

            </tr>



        </table>
        </div>
        
    <div class="page-break">
    </div>

    {{-- <h1>Page 2</h1> --}}



    <script>
        $(document).ready(function () {


        })

    </script>
</body>

</html>
