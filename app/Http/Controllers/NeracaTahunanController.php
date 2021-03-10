<?php

namespace App\Http\Controllers;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Helpers\AppHelper;
use App\Helpers\QueryHelper;
use App\Exports\NeracaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

use Redirect;
use Validator;
use Response;
use DB;
use PDF;


class NeracaTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function viewIndexNeracaTahunan()
    {

        // $namalimbah=DB::table('tr_detailmutasi')->where('konversi_kuota')
        return view('neraca_tahunan.list', [
            'tahun' => AppHelper::dataTahun()]
        );
    }
    public function downloadNeraca($month, $year)
    {


        // https://laracasts.com/discuss/channels/laravel/how-to-pass-the-sumfields-to-excel-conversion-using-maatwebsite-in-laravel
        return Excel::download(new NeracaExport($month, $year), 'Export Neraca-' . $month . '-' . $year . '.xlsx');
    }
    public function index(Request $request)
    {
        //hanya untuk membuat array tanggal per hari 
        $period = new DatePeriod(new DateTime('2021-03-01'), new DateInterval('P1D'), new DateTime('2021-03-01 +31 day'));
        $arrData = [];


        $periodIn = [];
        $periodOut = [];
        $idlimbah=[];
        array_push($idlimbah,$request->namalimbah);
        foreach ($period as $date) {
            $periodIn[$date->format("d")] = 0;
            // $periodOut[$date->format("d")] = 0; 
            $columnPeriod[] = $date->format("d");
        } 
        for ($i = 1; $i < 4; $i++) {
            $dataLimbahIn[$i] = $this->getDataPerLimbah('2021', $i, $idlimbah, ['2'], $periodIn, 'In');

            $dataLimbahOut[$i] = $this->getDataPerLimbah('2021', $i,$idlimbah, ['5', '6', '7', '8', '9'], $periodIn, 'Out');
            array_push($arrData, $dataLimbahIn[$i]);
            array_push($arrData, $dataLimbahOut[$i]); 
        } 

        array_unshift($columnPeriod, 'No.', 'Bulan', 'Awal', 'Nama Limbah', 'Kategori');
        array_push($columnPeriod, 'Jumlah', 'Total');
 
        return response()->json([
            'column' => $columnPeriod,
            'dataRow' => $arrData
        ]);
    }
    public function getDataPerLimbah($year, $month, $limbah, $status, $period, $category)
    { 
        $data =null;
        if($category=='In'){
            $data = DB::table('tr_detailmutasi')
            ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', 'md_namalimbah.id')
            ->select(DB::raw('DATE_FORMAT(tr_detailmutasi.created_at, "%d") as created_at'), DB::raw('sum(tr_detailmutasi.jumlah) as jumlah'))
            ->whereYear('tr_detailmutasi.created_at', $year)
            ->whereMonth('tr_detailmutasi.created_at', $month)
            ->whereIn('tr_detailmutasi.idstatus', $status)
            ->whereIn('tr_detailmutasi.idlimbah', $limbah)
            ->where('tr_detailmutasi.keterangan', null)
            ->groupBy('tr_detailmutasi.created_at')
            ->orderBy('tr_detailmutasi.created_at', 'asc')
            ->get();
        }else{
            $data = DB::table('tr_detailmutasi')
            ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', 'md_namalimbah.id')
            ->select(DB::raw('DATE_FORMAT(tr_detailmutasi.created_at, "%d") as created_at'), DB::raw('sum(tr_detailmutasi.jumlah) as jumlah'))
            ->whereYear('tr_detailmutasi.tgl', $year)
            ->whereMonth('tr_detailmutasi.tgl', $month)
            ->whereIn('tr_detailmutasi.idstatus', $status)
            ->whereIn('tr_detailmutasi.idlimbah', $limbah)
            ->where('tr_detailmutasi.keterangan', null)
            ->groupBy('tr_detailmutasi.created_at')
            ->orderBy('tr_detailmutasi.created_at', 'asc')
            ->get();
        }
        

            $dataSatuan = DB::table('md_namalimbah')
            ->whereIn('md_namalimbah.id', $limbah) 
            ->first();

            
        //assign data for front column
        $assignData = $this->assignDatatoDate($data, $period,$dataSatuan);
        $totalKategoriMutasi=0; 
         
        foreach($assignData as $value){
            $totalKategoriMutasi+=$value;
        }  
        //get name month
        $dateObj   = DateTime::createFromFormat('!m', $month);
     
        $monthName = $dateObj->format('F'); // March
        $namaBulan=$month; 
        switch ($namaBulan) {
            case 1 : {
                    $namaBulan = 'Januari';
                }break;
            case 2 : {
                    $namaBulan = 'Februari';
                }break;
            case 3 : {
                    $namaBulan = 'Maret';
                }break;
            case 4 : {
                    $namaBulan = 'April';
                }break;
            case 5 : {
                    $namaBulan = 'Mei';
                }break;
            case 6 : {
                    $namaBulan = "Juni";
                }break;
            case 7 : {
                    $namaBulan = 'Juli';
                }break;
            case 8 : {
                    $namaBulan = 'Agustus';
                }break;
            case 9 : {
                    $namaBulan = 'September';
                }break;
            case 10 : {
                    $namaBulan = 'Oktober';
                }break;
            case 11 : {
                    $namaBulan = 'November';
                }break;
            case 12 : {
                    $namaBulan = 'Desember';
                }break;
            default: {
                    $namaBulan = 'UnKnown';
                }break;
        }
        
    
        $namalimbah=null; 
        if(in_array(1,$limbah) ||in_array(2,$limbah)||in_array(3,$limbah) ){ 
            $namalimbah='Wiping Solution';
        }else{
            $namalimbah = DB::table('md_namalimbah')->where('id',$limbah)->first('namalimbah');
            $namalimbah=$namalimbah->namalimbah;
        }
        $dataFrontColumn =null;
        $jumlahPerKategori=null;
        $jumlahAwal=null;
        $jumlahAkhir=null;

         //tinggal front column & last column di pisahkan in OUT
        if($category=='In'){
            $jumlahAwal=$this->getJumlahAwalAkhir($year, $month, $limbah, $status,'awal','In',$dataSatuan);
            $jumlahAkhir=$this->getJumlahAwalAkhir($year, $month, $limbah, $status,'akhir','In',$dataSatuan);
            $jumlahPerKategori=round($totalKategoriMutasi, 1);
            // $this->queryJumlahAwalAkhir($year, $month, $limbah, $status,$dataSatuan);
            
        }else{
            $jumlahAwal=$this->getJumlahAwalAkhir($year, $month, $limbah, $status,'awal','Out',$dataSatuan);
            $jumlahAkhir=$this->getJumlahAwalAkhir($year, $month, $limbah, $status,'akhir','Out',$dataSatuan);
             
            $jumlahPerKategori=round($totalKategoriMutasi, 1);
            // $this->queryJumlahAwalAkhir($year, $month, $limbah, $status,$dataSatuan);
        }
        $dataFrontColumn = array($month, $namaBulan, $jumlahAwal, $namalimbah, $category);
        //assign data for last column
        $dataLastColumn = array($jumlahPerKategori, $jumlahAkhir);

        $dataRow = [];
        $dataRow = $dataFrontColumn;
        //fill array data row with assign data
        foreach ($assignData as $data) {
            array_push($dataRow, $data);
        }

        foreach ($dataLastColumn as $data) {
            array_push($dataRow, $data);
        }
 
        return $dataRow;
    }
    public function querySaldoMutasiKuotaNeraca($year, $month, $status, $namalimbah)
    { 
        $resultData = DB::table('tr_detailmutasi')
            ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', 'md_namalimbah.id')
            ->select(DB::raw('sum(tr_detailmutasi.pack) as pack'))
            ->whereYear('tr_detailmutasi.created_at', $year)
            ->whereMonth('tr_detailmutasi.created_at', $month)
            ->whereIn('tr_detailmutasi.idstatus', $status)
            ->whereIn('tr_detailmutasi.idlimbah', $namalimbah)
            ->where('tr_detailmutasi.keterangan', null)
            ->first();

        if ($resultData->pack == null) {
            $resultData->pack = 0;
        }

        return $resultData->pack;
    }
    public function getSisaSaldo($year, $month, $namalimbah)
    {

        $dataMasuk = $this->querySaldoMutasiKuotaNeraca(
            $year,
            $month,
            ['2'],
            $namalimbah
        );
        $dataKeluar = $this->querySaldoMutasiKuotaNeraca(
            $year,
            $month,
            ['5', '6', '7', '8', '9'],
            $namalimbah
        );

        if ((int)$dataKeluar == 0) {
            $jumlahSisa = 0;
        } else {
            $jumlahSisa = (int)$dataMasuk - (int)$dataKeluar;
        }
        return $jumlahSisa;
    }
    public function getDataPerTPSKuotaAnggaran($period, $tipe_kuota_limbah)
    {
        $arrMasuk = [];
        $arrKeluar = [];
        $arrSisa = [];
        $arrData = [];
        $dataNamaLimbah = DB::table('md_namalimbah')->where('tipe_kuota_limbah', $tipe_kuota_limbah)->pluck('id');

        $dataSatuan = DB::table('md_namalimbah')->where('tipe_kuota_limbah', $tipe_kuota_limbah)->first('konversi_kuota');

        for ($i = 1; $i <= 12; $i++) {
            $jumlahMasuk[$i] = $this->querySaldoMutasiKuotaNeraca($period, $i, ['2'], $dataNamaLimbah);

            $jumlahKeluar[$i] = $this->querySaldoMutasiKuotaNeraca($period, $i, ['5', '6', '7', '8', '9'], $dataNamaLimbah);
            $jumlahSisa[$i] = null;
            $jumlahSisaPrev[$i] = 0;
            if ($i > 0) {
                $jumlahSisa[$i] = $this->getSisaSaldo($period, $i, $dataNamaLimbah);
                $jumlahSisaPrev[$i] = $this->getSisaSaldo((int)$period, $i - 1, $dataNamaLimbah);
            } else {
                $jumlahSisa[$i] = $this->getSisaSaldo((int)$period - 1, $i, $dataNamaLimbah);
            }
            array_push($arrMasuk, (int)$jumlahMasuk[$i] + $jumlahSisaPrev[$i]);
            array_push($arrKeluar, (int)$jumlahKeluar[$i]);
            array_push($arrSisa, (int)$jumlahSisa[$i]);
        }
        $arrData['saldoMasuk'] = $arrMasuk;
        $arrData['saldoKeluar'] = $arrKeluar;
        $arrData['sisaSaldo'] = $arrSisa;
        $arrData['satuan'] = $dataSatuan->konversi_kuota;

        // dd($arrMasuk);
        return  $arrData;
    }
    public function dashboardNeracaKuota(Request $request)
    {
        $pPeriod = $request->period;
        $arrTPS = $request->tps;
        $arrDataPerBulan = [];
        for ($i = 1; $i <= count($arrTPS); $i++) {
            $dataTPSPerBulan = $this->getDataPerTPSKuotaAnggaran($pPeriod, $i);
            $satuan = DB::table('md_tps')->where('id', $i)->first();
            $arrDataPerBulan['kuota-' . $i] = $dataTPSPerBulan;
        }
        return response()->json([
            'dataBar' => $arrDataPerBulan
        ]);
    }
   
    
    public function queryJumlahAwalAkhir($year, $month, $limbah, $status,$dataSatuan)
    {
        $jumlah=0;
        $data= DB::table('tr_detailmutasi')
            ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', 'md_namalimbah.id')
            ->select(DB::raw('sum(tr_detailmutasi.jumlah) as jumlah'))
            ->whereYear('tr_detailmutasi.created_at', $year)
            ->whereMonth('tr_detailmutasi.created_at', $month)
            ->whereIn('tr_detailmutasi.idstatus', $status)
            ->whereIn('tr_detailmutasi.idlimbah', $limbah)
            ->where('tr_detailmutasi.keterangan', null)  
            ->first();
            if($data->jumlah == null){

            }else{
                $jumlah=$data->jumlah;
            }
            
            // return $jumlah;
            return $this->convertSatuan($jumlah, $dataSatuan);

    }
    public function getJumlahAwalAkhir($currYear, $currMonth, $limbah, $status,$mode,$mutasi,$dataSatuan)
    {
        $prevYear=$currYear - 1;
        $prevMonth=null;
        $filterMonth=$currMonth;
        $data =null;
        $dataIn=0;
        $dataOut=0;
        $total=0;
        
        //nilai saldo awal
        if($mode=='awal'){
            //ambil data di tahun sebelumnya jika bulan januari 
            if($currMonth < '2'){
                $prevMonth='12';
                $dataIn=$this->queryJumlahAwalAkhir($prevYear, $prevMonth, $limbah, ['2'],$dataSatuan);
                $dataOut=$this->queryJumlahAwalAkhir($prevYear, $prevMonth, $limbah, ['5','6','7','8','9'],$dataSatuan);
                if($dataIn == 0){
                    $total=0;
                }else{ 
                    $total=(int) $dataIn - (int) $dataOut; 
                }
                //ambil data bulan sebelumnya di tahun yang sama
            }else { 
                $prevMonth=$currMonth-1;

                $dataPrevIn=$this->queryJumlahAwalAkhir($currYear, $prevMonth, $limbah, ['2'],$dataSatuan);
                $dataPrevOut=$this->queryJumlahAwalAkhir($currYear, $prevMonth, $limbah, ['5','6','7','8','9'],$dataSatuan);
                if( $dataIn==0){
                    $total=0;
                }else{ 
                    $total=(int) $dataPrevIn - (int) $dataPrevOut; 
                }
                
            }

            
            return $total;
        }else if($mode=='akhir'){
            if($currMonth < '2'){
                $prevMonth='12';
                $dataIn=$this->queryJumlahAwalAkhir($prevYear, $prevMonth, $limbah, ['2'],$dataSatuan);
                $dataOut=$this->queryJumlahAwalAkhir($prevYear, $prevMonth, $limbah, ['5','6','7','8','9'],$dataSatuan);
                if($dataIn == 0){
                    $totalPrev=0;
                }else{ 
                    $totalPrev=(int) $dataIn - (int) $dataOut; 
                }
                //ambil data bulan sebelumnya di tahun yang sama
            }else { 
                $prevMonth=$currMonth-1;

                $dataPrevIn=$this->queryJumlahAwalAkhir($currYear, $prevMonth, $limbah, ['2'],$dataSatuan);
                $dataPrevOut=$this->queryJumlahAwalAkhir($currYear, $prevMonth, $limbah, ['5','6','7','8','9'],$dataSatuan);
                if( $dataIn==0){
                    $totalPrev=0;
                }else{ 
                    $totalPrev=(int) $dataPrevIn - (int) $dataPrevOut; 
                }
                
            } 


            $dataCurrIn=$this->queryJumlahAwalAkhir($currYear, $currMonth, $limbah, ['2'],$dataSatuan);
            $dataCurrOut=$this->queryJumlahAwalAkhir($currYear, $currMonth, $limbah, ['5','6','7','8','9'],$dataSatuan);
            // dd($totalPrev);
            $total=$dataCurrIn+$totalPrev-$dataCurrOut; 
        
            return $total;
        }
       

        
    }
    public function assignDatatoDate($dataQuery, $arrPeriode,$dataSatuan)
    {
        $arrPerDate = [];
        //assign data query to each date
        foreach ($dataQuery as $data) {     
            $resultConvert=$this->convertSatuan($data->jumlah,$dataSatuan);
            // $arrPeriode[$data->created_at] = $data->jumlah;
            $arrPeriode[$data->created_at] =  $resultConvert;
        }
        //convert dataQuery to only value in array
        foreach ($arrPeriode as $data) {
            array_push($arrPerDate, $data);
        } 
        return $arrPerDate;
    }
    public function convertSatuan($data, $dataSatuan)
    {
        $valPembagi=$dataSatuan->konversi_satuan_kecil;
        // dd($data);
        $resulConvert= (float)$data * (float)$valPembagi;
        $jmlhFinal=round($resulConvert, 1); 
        // dd($jmlhFinal);
        return $jmlhFinal;
        
    }

   


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
