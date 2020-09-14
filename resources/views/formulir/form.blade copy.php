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

        td.header {
            font-size: 15pt;
            text-align: center;
            font-weight: bold;
        }

        td.header2 {
            font-size: 13pt;
            text-align: center;
        }

        hr.new1 {
            border: 2px solid black;
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
            font-size: 10pt;
            padding-left: 2px;
            text-align: center;
        }

    </style>



    <table class="table">
        <tr>
            <td class="header" colspan="4">
                TIM IDENTIFIKASI KEASLIAN PITA CUKAI
            </td>
        </tr>
        <tr>
            <td class="header" colspan="4">
                KONSORSIUM PENYEDIA PITA CUKAI
            </td>
        </tr>
        <tr>
            <td class="header2" colspan="4">
                Perum Percetakan Uang RI
            </td>
        </tr>
        <tr>
            <td class="header2" colspan="4">
                PT. Pura Nusapersada
            </td>
        </tr>
        <tr>
            <td class="header2" colspan="4">
                PT. Kertas Padalarang
            </td>
        </tr>
        <tr>
            <td class="header2" colspan="4">
                <hr class="new1">
            </td>

        </tr>


        <tr>
            <td class="header2" colspan="4" style=" font-weight: bold;  padding-top:10px;">
                <u>BERITA ACARA</u>
            </td>


        </tr>
        <tr>
            <td class="header2" colspan="4" style="  font-weight: bold; padding-top:10px;">
                <u> HASIL PENGUJIAN KEASLIAN PITA CUKAI</u>
            </td>

        </tr>

        <tr>
            <td class="header2" colspan="4" style="  font-weight: bold; ">
                Nomor : {{ $noBa }}
            </td>


        </tr>
        <tr>
            <td class="row3" colspan="4">
                <div class="a">
                    Pada hari ini <b>{{ $day }}</b> tanggal <b>{{ $tgl }}</b> bulan <b>{{ $bln }}</b> tahun
                    <b>{{ $thn }}</b> bertempat di {{ $tempat }}, {{$tempatttd}} yang bertandatangan dibawah ini:
                </div>
            </td>


        </tr>
        <tr>
            <td colspan="2" style="text-align:right;font-weight: bold;padding-right:50px;">

                Nama <br>
                NP/NIK

            </td>
            <td colspan="2" style="text-align:left;font-weight: bold;">

                : {{ $nama }} <br>
                : {{ $nik }}</p>

            </td>



        </tr>

        <tr>
            <td class="row3" colspan="4">
                <div class="a">
                    Berdasarkan Surat Keputusan Bersama tentang Tim Identifikasi Keaslian Pita Cukai Nomor :
                    {{ $skepPeruri }}, Nomor : {{$skepPura}}, Nomor : {{$skepPTKP}} dan surat {{ $kntrpemohon }} Nomor
                    : {{ $srtpemohon }} tanggal {{ $tglsrt }}{{$katasrtbantuan}} perihal {{ $perihal }}, telah melakukan pengujian keaslian {{ $jenispita->keterangan }} ({{$jenispita->jenis_pikai}}) dengan perincian sebagai berikut:

                </div>
            </td>


        </tr>
        {{-- <tr>
            <td class="row3" colspan="4">
                
                <div class="a">
                    

                </div>
            </td>


        </tr> --}}

       
    </table>
        {{-- hasil rincian --}}
        <table class="hasiluji">
            <tr>
                <th class="headeruji" rowspan="2">No.</th>
                <th class="headeruji" rowspan="2">Jumlah Sample</th>
                <th class="headeruji" colspan='4'>Informasi Kemasan BKC</th>
                <th class="headeruji" colspan='8'>Informasi Jenis Pita Cukai</th>
            </tr>
            <tr>

                <th class="headeruji">Merk</th>
                <th class="headeruji">Isi</th>
                <th class="headeruji">Jenis BKC</th>
                <th class="headeruji">Pabrik/Importir</th>
                <th class="headeruji">Jenis BKC</th>
                <th class="headeruji">Seri</th>
                <th class="headeruji">Personalisasi</th>
                <th class="headeruji">HJE</th>
                <th class="headeruji">Tarif</th>
                <th class="headeruji">Isi</th>
                <th class="headeruji">Warna</th>
                <th class="headeruji">TA</th>

            </tr>
            @foreach($datauji as $isiColumn)
            <tr>

                <td class="itemuji">

                    {{$loop->iteration}}.

                </td>
                <td class="itemuji">
                    {{$isiColumn->jumlah_sample}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->merk_bkckemasan}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->isi_bkcemasan}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->jenis_bkckemasan}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->pabrik_bkc}}
                </td>
                {{-- informasi piki
      
    jenisbkcpikai--}}
                <td class="itemuji">
                    {{$isiColumn->jenis_bkcpikai}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->seri_pikai}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->personalisasi}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->hje_pikai}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->tarif_pikai}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->isi_pikai}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->warna_pikai}}
                </td>
                <td class="itemuji">
                    {{$isiColumn->desain_tahun}}
                </td>


            </tr>
            @endforeach
        </table>

        {{-- hasil kesimpulan --}}
        <table class="table">
          
            <tr>
                <td class="row3" colspan="7">
                    <div class="a">
                        Berdasarkan hasil penelitian identifikasi terhadap sampel pita cukai tersebut secara kasat mata, dengan alat bantu kaca pembesar, lampu ultraviolet, dan alat elektronis dapat disimpulkan bahwa:
    
                    </div>
                </td> 
            </tr>
            @foreach($kesimpulan as $isikesimpulan)
            <tr>
                {{-- <td class="row6">
                    {{-- <div class="a"> --}}
                        {{-- {{$loop->iteration}}. --}}
                    {{-- </div> 
                </td>  --}}
                <td class="row3" colspan="7">
                    <div class="a">
                        {{$loop->iteration}}. <span></span><?php echo htmlspecialchars_decode($isikesimpulan);?>
                         
                    </div>
                </td> 
            </tr>
            @endforeach
        

       
    </table>

    <div class="page-break">
    </div>
    <table class="table">
      
        <tr>
            <td >

            </td>
       
        <td colspan="2" style="text-align:right;padding-left:350px; padding-top:50px;" >
            Tim Ahli Identifikasi Keaslian Pita Cukai
        </td>
       


    </tr>
    <tr>
        <td  >

        </td>
         
        <td colspan="2" style="font-weight: bold; text-align:right;padding-top:100px; padding-right:50px;">
            <u>{{ $nama }}</u>


        </td>

    </tr>
    <tr>
        <td >

        </td>
        <td colspan="2" style="font-weight: bold; text-align:right; padding-right:70px;">

            <p>NP/NIK. {{ $nik }}</p>

        </td>

    </tr>
    </table>
{{-- <h1>Page 2</h1> --}}



    <script>
        $(document).ready(function () {
            var dataJadwal = JSON.parse(window.localStorage.getItem('itemJadwal'))
            console.log(dataJadwal)

        })

    </script>
</body>

</html>
