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
        td.logokanan{
            text-align: right;
            align-content: right;
            padding-left: 50px;
            padding-right: 20px;
            
        }
        td.logokiri{
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
    </style>



    <table class="table">
        <tr>
            <td class='logokiri' colspan="4">
                <img src="{{ public_path('/img/perurilogo.jpg') }}" alt="AdminLTE Logo" width="100px" height="70px"
                    style="opacity: .8">
            </td>
            <td class="titlecenter" colspan="4">
                FORMULIR
            </td>
            <td  class='logokanan' colspan="4">
                <img src="{{ public_path('/img/SGS.png') }}" alt="AdminLTE Logo" width="120px" height="75px"  
                style="opacity: .8">
            </td>
        </tr>
       
        <tr>
            <td class="headerow2left" colspan="5">
                Nomor :
            </td>
            
            <td class="headerow2right" colspan="4">
                12312312
            </td>
        </tr>
        <tr>
            <td class="headerow2left" colspan="5">
                Tanggal :
            </td>
          
            <td class="headerow2right" colspan="4">
                08041993
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
                Limbah Sludge B3
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
                Limbah Sludge B3
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
                Limbah Sludge B3
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
                Limbah Sludge B3
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
                Limbah Sludge B3
            </td>

        </tr>
        </table>
        <table class="table3">
 
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

        
        

       
    </table>

    <div class="page-break">
    </div>
     
{{-- <h1>Page 2</h1> --}}



    <script>
        $(document).ready(function () {
           

        })

    </script>
</body>

</html>
