<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title> </title>
</head>

<body>
    <style type="text/css">
        .page-break {
            page-break-before: always;
        }
        /* div.breakNow {
            page-break-after: always;
        } */

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
            font-size: 15pt;
            text-align: center;
            font-weight: bold;

            border: 4px solid #000000;
        }

        td.headerow2left {
            font-size: 13pt;
            text-align: right;
            padding-right: 70px;
            /* border:2px solid black; */
            margin-left: 10rem;

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
            text-align: center;
             border: 1px solid black;
        }

        td.no {
            font-size: 12pt;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right: 5px;
            border: 1px solid black;
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
            border: 1px solid black;
            border-right-style: solid;
            border-right-width: thin;

            text-align: center;
        }
        td.validasi{
            font-size: 12pt;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right: 5px;
            /* border-bottom: 1px solid black; */
            border-right-style: solid;
            border-right-width: thin;

            text-align: center;
        }
        td.validasi1{
            font-size: 12pt;
            padding-top: 5px;
            padding-bottom: 5px;
            padding-left: 5px;
            padding-right: 5px;
            border-bottom: 1px solid black;
            border-right-style: solid;
            border-right-width: thin;

            text-align: center;
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
    <img class='background' src="{{ public_path('/img/perurilogo.jpg') }}" alt="AdminLTE Logo" width="700px"
        height="800px" style="opacity: .10;margin-top: 100px;">

    <img class='background1' src="{{ public_path('/img/validbiru1.png') }}" alt="AdminLTE Logo" width="250px"
        height="75px" style="opacity: .5;margin-top: 100px;margin-left:200px;bottom: 150;transform: rotate(-30deg)">
</div>
    <div id='content'>
        <table class="table">
            <tr>
                <td class='logokiri' colspan="4">
                    <img src="{{ public_path('/img/perurilogo.jpg') }}" alt="AdminLTE Logo" width="100px" height="70px"
                        style="opacity: .8">
                </td>
                <td class="titlecenter" colspan="4">
                    BERITA ACARA PEMUSNAHAN LIMBAH
                </td>
                <td class='logokanan' colspan="4">
                    <img src="{{ public_path('/img/SGS.png') }}" alt="AdminLTE Logo" width="120px" height="75px"
                        style="opacity: .8">
                </td>
            </tr>

            <tr>
                <td class="headerow2left" colspan="9">
                    Nomor :{{$no_ba}}
                </td>


                {{-- <td class="headerow2right" colspan="3">
                    {{$no_ba}}
                </td> --}}
            </tr>
            {{-- <tr>
                <td class="headerow2left" colspan="6">
                    Tanggal :
                </td>

                <td class="headerow2right" colspan="5">
                    {{$tanggal}}
                </td>
            </tr> --}}
        </table>

        <table class="table2">

            <tr>
                <td class="headerow3left" colspan="3">
                    Pada Hari Ini
                </td>
                <td class="headerow3center" colspan="1">
                    :
                </td>
                <td class="headerow3right" colspan="4">
                    {{$hari}}
                </td>

            </tr>
 
            <tr>
                <td class="headerow3left" colspan="3">
                    Tanggal
                </td>
                <td class="headerow3center" colspan="1">
                    :
                </td>
                <td class="headerow3right" colspan="4">
                    {{$tanggal}}
                </td>

            </tr>
             
        </table>
        <hr class="new1">  
        <p style="padding-bottom: 2rem;"> I. Telah Dilaksanakan Pemusnahan Limbah: </p>
        <table class="table1" style="width: 100%;padding-bottom: 2rem;">
           
            <tr>
                <th class="headeruji" style='width:3%;' colspan="1">No.</th>
                <th class="headeruji" colspan="5">Nama Limbah</th>
                <th class="headeruji" style='width:15%;' colspan="2">Jumlah</th>
                <th class="headeruji" style='width:20%;' colspan="2">Satuan</th>
                <th class="headeruji" style='width:20%;' colspan="2">No. Dokumen</th>
            </tr>
            {{-- @php($i=1) --}}
            <tbody>
                {{-- @foreach($listlimbah as $data)  --}}
                <tr>
                    {{-- $loop->iteration --}}
                    <td class="no">1</td>
                    <td class="namalimbah" colspan="5">{{$listlimbah->namalimbah}}</td>
                    <td class="no" colspan="2">{{$listlimbah->jumlah}}</td>
                    <td class="keterangan" colspan="2">{{$listlimbah->satuan}}</td>
                    <td class="keterangan" colspan="2">{{$listlimbah->no_surat}}</td>
                </tr>
                
                
                {{-- @if( $i % 20 == 0 ) --}}
            </tbody>
        </table>
        <p > II. Pemusnahan Dilakukan Dengan Cara: </p>
        <table class="table1" style="width: 100%;padding-bottom: 2rem;">
            <tbody> 
                <tr>
                    <td class="no">Proses Pemusnahan Dilakukan Dengan {{$listlimbah->keterangan}} </td>
                </tr>
                 
            </tbody>
        </table>
        <p  > III. Petugas Pelaksana: </p>
        <table class="table1" style="width: 100%;padding-bottom: 2rem;">
            <tbody> 
                <tr>
                    <th class="headeruji" style='width:3%;' colspan="1">No.</th>
                    <th class="headeruji" colspan="2">Petugas</th>
                    <th class="headeruji" colspan="3">Nama</th>
                    <th class="headeruji" style='width:20%;' colspan="2">NP</th>
                    {{-- <th class="headeruji" style='width:20%;' colspan="2">No. Dokumen</th> --}}
                </tr>
                <tr>
                    {{-- $loop->iteration --}}
                    <td class="no">1</td>
                    <td class="namalimbah" colspan="2">Pengawas Lapangan</td>
                    <td class="no" colspan="3">{{$detailPengawasLapangan->nama}}</td>
                    <td class="keterangan" colspan="2">{{$detailPengawasLapangan->np}}</td>
                    {{-- <td class="keterangan" colspan="2">{{$listlimbah->no_surat}}</td> --}}
                </tr>
                 
            </tbody>
        </table>
        <p style="position: absolute;
        bottom: 16rem;"> IV. Pihak Pihak Yang Menyaksikan: </p>
        <table class="table1" style="width: 100%;position: absolute;bottom: 15rem;">
            <tbody> 
                <tr>
                    <th class="headeruji" style='width:3%;' rowspan="1">No.</th>
                    <th class="headeruji" colspan="2">Nama</th>
                    <th class="headeruji" colspan="3">Unit Kerja</th>
                    <th class="headeruji" style='width:20%;' colspan="2">Tanda Tangan</th> 
                </tr>
                <tr> 
                    <td class="no" rowspan="2">1</td>
                    <td class="namalimbah" colspan="2">{{$detailPemohon->nama}}</td>
                    <td class="no" colspan="3" rowspan="2">{{$listlimbah->seksi}}</td>
                    <td class="validasi" rowspan="1" colspan="2" ></td> 
                </tr>
               <tr> 
                    <td class="namalimbah" colspan="2">Unit Penghasil Limbah</td> 
                    <td class="validasi1" colspan="2" style="font-size: 10px;position: absolute;
                    bottom: 10px;">{{$listlimbah->validated_pemohon}}</td> 
                </tr>
                <tr> 
                    <td class="no" rowspan="2">2</td>
                    <td class="namalimbah" colspan="2">{{$detailPengamanan->nama}}</td>
                    <td class="no" colspan="3" rowspan="2">Seksi Pamsiknilmat</td>
                    <td class="validasi" rowspan="1" colspan="2"></td> 
                </tr>
               <tr> 
                    <td class="namalimbah" colspan="2">Pengamanan</td> 
                    <td class="validasi1" colspan="2" style="font-size: 10px;position: absolute;
                    bottom: 10px;">{{$listlimbah->validated_pengawas}}</td> 
                </tr>
                <tr> 
                    <td class="no" rowspan="2">3</td>
                    <td class="namalimbah" colspan="2">{{$detailPengawasLapangan->nama}}</td>
                    <td class="no" colspan="3" rowspan="2">Operasional Limbah</td>
                    <td class="validasi" rowspan="1" colspan="2"></td> 
                </tr>
               <tr> 
                    <td class="namalimbah" colspan="2">Pengawas Lapangan</td> 
                    <td class="validasi1" colspan="2" style="font-size: 10px;position: absolute;
                    bottom: 10px;">{{$listlimbah->validated_np_pengawas_lapangan}}</td> 
                </tr>
                
                 
            </tbody>
        </table>
        {{-- <div class="page-break">   --}}
            <div id="background">
                {{-- <img class='background' src="{{ public_path('/img/perurilogo.jpg') }}" alt="AdminLTE Logo" width="700px"
                    height="800px" style="opacity: .10;margin-top: 100px;"> --}}
        
                <img class='background1' src="{{ public_path('/img/validbiru1.png') }}" alt="AdminLTE Logo" width="250px"
                    height="75px" style="opacity: .5;margin-top: 100px;margin-left:200px;bottom: 150;transform: rotate(-30deg)">
            </div>
        {{-- </div> --}}
         

        
    </div>

 
    <script>
        $(document).ready(function () {


        })

    </script>
</body>

</html>
