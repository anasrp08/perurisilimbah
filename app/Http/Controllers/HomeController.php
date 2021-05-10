<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laratrust\LaratrustFacade as Laratrust;
use App\Helpers\QueryHelper; 
use App\Helpers\UpdKaryawanHelper; 
use App\Http\Requests;
use App\Jadwal;
use App\Helpers\AppHelper;
use App\Helpers\AuthHelper;
use App\Role;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDO;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        // $passwd=[];
        // $passwd[1]=bcrypt('11000');
        // $passwd[2]=bcrypt('12000');
        // $passwd[3]=bcrypt('13000');
        // $passwd[4]=bcrypt('14000');
        // $passwd[5]=bcrypt('21000');
        // $passwd[6]=bcrypt('22000');
        // $passwd[7]=bcrypt('23000');
        // $passwd[8]=bcrypt('31A11');
        // $passwd[9]=bcrypt('31A12');
        // $passwd[10]=bcrypt('31A21');
        // $passwd[11]=bcrypt('31A22');
        // $passwd[12]=bcrypt('31A31');
        // $passwd[13]=bcrypt('31A32');
        // $passwd[14]=bcrypt('31B00');
        // $passwd[15]=bcrypt('31B41');
        // $passwd[16]=bcrypt('31B42');
        // $passwd[17]=bcrypt('31B43');
        // $passwd[18]=bcrypt('31B44');
        // $passwd[19]=bcrypt('31D00');
        // $passwd[20]=bcrypt('32A00');
        // $passwd[21]=bcrypt('32B10');
        // $passwd[22]=bcrypt('32B20');
        // $passwd[23]=bcrypt('32B30');
        // $passwd[24]=bcrypt('32B40');
        // $passwd[25]=bcrypt('32C11');
        // $passwd[26]=bcrypt('32C12');
        // $passwd[27]=bcrypt('32C21');
        // $passwd[28]=bcrypt('32C22');
        // $passwd[29]=bcrypt('32C23');
        // $passwd[30]=bcrypt('32C31');
        // $passwd[31]=bcrypt('32C32');
        // $passwd[32]=bcrypt('32C33');
        // $passwd[33]=bcrypt('32C34');
        // $passwd[34]=bcrypt('32D11');
        // $passwd[35]=bcrypt('32D12');
        // $passwd[36]=bcrypt('32D21');
        // $passwd[37]=bcrypt('32D22');
        // $passwd[38]=bcrypt('32D31');
        // $passwd[39]=bcrypt('32D32');
        // $passwd[40]=bcrypt('32E11');
        // $passwd[41]=bcrypt('32E12');
        // $passwd[42]=bcrypt('32E13');
        // $passwd[43]=bcrypt('32E14');
        // $passwd[44]=bcrypt('32E15');
        // $passwd[45]=bcrypt('32E21');
        // $passwd[46]=bcrypt('32E22');
        // $passwd[47]=bcrypt('32E23');
        // $passwd[48]=bcrypt('32E24');
        // $passwd[49]=bcrypt('32E31');
        // $passwd[50]=bcrypt('32E32');
        // $passwd[51]=bcrypt('32E33');
        // $passwd[52]=bcrypt('32E41');
        // $passwd[53]=bcrypt('32E42');
        // $passwd[54]=bcrypt('32E43');
        // $passwd[55]=bcrypt('32E51');
        // $passwd[56]=bcrypt('32E52');
        // $passwd[57]=bcrypt('32E61');
        // $passwd[58]=bcrypt('32E62');
        // $passwd[59]=bcrypt('32E63');
        // $passwd[60]=bcrypt('32F11');
        // $passwd[61]=bcrypt('32F12');
        // $passwd[62]=bcrypt('32F13');
        // $passwd[63]=bcrypt('32F21');
        // $passwd[64]=bcrypt('32F22');
        // $passwd[65]=bcrypt('32F31');
        // $passwd[66]=bcrypt('32F32');
        // $passwd[67]=bcrypt('32G00');
        // $passwd[68]=bcrypt('33A00');
        // $passwd[69]=bcrypt('33B00');
        // $passwd[70]=bcrypt('33C11');
        // $passwd[71]=bcrypt('33C21');
        // $passwd[72]=bcrypt('33C22');
        // $passwd[73]=bcrypt('33C31');
        // $passwd[74]=bcrypt('33C32');
        // $passwd[75]=bcrypt('33C41');
        // $passwd[76]=bcrypt('33C42');
        // $passwd[77]=bcrypt('33C51');
        // $passwd[78]=bcrypt('33C52');
        // $passwd[79]=bcrypt('33C53');
        // $passwd[80]=bcrypt('33C61');
        // $passwd[81]=bcrypt('33C62');
        // $passwd[82]=bcrypt('33D11');
        // $passwd[83]=bcrypt('33D12');
        // $passwd[84]=bcrypt('33D13');
        // $passwd[85]=bcrypt('33D14');
        // $passwd[86]=bcrypt('33D21');
        // $passwd[87]=bcrypt('33D22');
        // $passwd[88]=bcrypt('33D23');
        // $passwd[89]=bcrypt('33D31');
        // $passwd[90]=bcrypt('33D32');
        // $passwd[91]=bcrypt('33D33');
        // $passwd[92]=bcrypt('33D34');
        // $passwd[93]=bcrypt('33D41');
        // $passwd[94]=bcrypt('33D42');
        // $passwd[95]=bcrypt('35B10');
        // $passwd[96]=bcrypt('35B20');
        // $passwd[97]=bcrypt('41000');
        // $passwd[98]=bcrypt('42000');
        // $passwd[99]=bcrypt('43000');
        // $passwd[100]=bcrypt('44000');
        // $passwd[101]=bcrypt('51000');
        // $passwd[102]=bcrypt('52000');
        // $passwd[103]=bcrypt('53000');
        // dd($passwd);
        $user = Auth::user();
         
        $roleuser=$user;
        // dd(Laratrust::hasRole('unit kerja'));
        $userUnit=AuthHelper::getAuthUser()[0];
       
        if (Laratrust::hasRole('admin')) {
 
            $penghasilLimbah=DB::table('md_penghasillimbah')->get();
            $namaLimbah=DB::table('md_namalimbah')->get();
            AppHelper::dataTahun();
            UpdKaryawanHelper::updatePegawai();
            return view('dashboard.dashboard',[
                'penghasilLimbah'=>$penghasilLimbah,
                'namaLimbah'=>$namaLimbah,
                'tahun'=> AppHelper::dataTahun()
                ] 
            );
            
        } else if(Laratrust::hasRole('unit kerja')) {
           
            UpdKaryawanHelper::updatePegawai();
            $queryHelper=QueryHelper::getDropDown();
            // array_push($queryHelper,array('namaseksi'=>$penghasilLimbah));
            // return view('pemohon.create', QueryHelper::getDropDown());
            // return redirect()->route('pemohon.entri',  QueryHelper::getDropDown());
            return view('pemohon.create', QueryHelper::getDropDown());
        }else if(Laratrust::hasRole('pengawas') || Laratrust::hasRole('operator')) {
            
            UpdKaryawanHelper::updatePegawai();
            $vendor = DB::table('md_vendorlimbah')->groupBy('namavendor')->get();
            $jenisLimbah=DB::table('md_jenislimbah')->get();
            $namaLimbah=DB::table('md_namalimbah')->get();
            $tipeLimbah=DB::table('md_tipelimbah')->get();
            $penghasilLimbah=DB::table('md_penghasillimbah')->get();
            $satuanLimbah=DB::table('md_satuan')->orderBy('id','desc')->get();
            $tpsLimbah=DB::table('md_tps')->get();
            $np=DB::table('tbl_np')->get();
            $status=DB::table('md_statusmutasi')->get();
            // return redirect()->route('pemohon.listview', QueryHelper::getDropDown());
            return view('pemohon.list', [
            'np'=>$np,
            'vendor'=> $vendor,
            'jenisLimbah' => $jenisLimbah,
            'namaLimbah' => $namaLimbah,
            'tipeLimbah' => $tipeLimbah,
            'satuanLimbah' => $satuanLimbah,
            'tpsLimbah' => $tpsLimbah,
            'penghasilLimbah' => $penghasilLimbah,
            'status'=>$status,
            'username' => AuthHelper::getAuthUser()[0]]
        );
        }else{
            // return redirect()->route('pemohon.entri', QueryHelper::getDropDown());
        }
 
    }
   
    public function dataDashboard(Request $request)
    {
       
        $dataKadaluarsa=$this->dashboardToBeKadaluarsa();
        $dataNotifikasi=$this->dashboardToBeKadaluarsa(); 
        $arrNotifikasi=new \stdClass(); 
        $arrIsi=[];
        
        // $dataIsi=$dataNotifikasi->groupBy('kadaluarsa')->keys()->toArray();
        $dataNotif=$dataNotifikasi->groupBy('tgl_kadaluarsa')->values()->toArray(); 
        for($i=0;$i<count($dataNotif);$i++){
            // $arrNotifikasi->isi=count($dataNotif[$i]);
            array_push($arrIsi,count($dataNotif[$i]));
            // dd($dataJumlah);

        }
        $arrNotifikasi->keys=$dataNotifikasi->groupBy('tgl_kadaluarsa')->keys()->toArray();
        $arrNotifikasi->values=$arrIsi; 
        $dataKapasitas=$this->dashboardKapasitas($request);
 
        return response()->json([ 
            'dataKapasitas'=>$dataKapasitas, 
            'dataKadaluarsa'=>$dataKadaluarsa, 
            'dataNotifikasi'=>$arrNotifikasi, 
            ]);
    }
     //dashboard TPS
     public function dashboardKapasitas($request){

        $dataKapasitas=DB::table('md_tps')->get();
        foreach($dataKapasitas as $row){
            if($row->namatps=='TPS CAIR'){
                $row->saldo=(int)$row->saldo_satuan_kecil / 1000;

            }else{
                $row->saldo=round($row->saldo, 2 );
            }
            
        }


        return $dataKapasitas;
    }
    //daftar list kadaluarsa
    public function dashboardToBeKadaluarsa(){

        $dataKadaluarsa=DB::table('tr_headermutasi')
        ->join('md_namalimbah','tr_headermutasi.idlimbah','md_namalimbah.id')
        // ->join('tr_statusmutasi','tr_statusmutasi.id','tr_packing.idmutasi')
        ->join('md_tps','tr_headermutasi.idtps','md_tps.id')
        ->select('md_namalimbah.namalimbah','tr_headermutasi.tgl','tr_headermutasi.jumlah_in','tr_headermutasi.tgl_kadaluarsa','md_tps.namatps')
        
        ->where('tr_headermutasi.jumlah_in','!=',0)
        ->where('tr_headermutasi.idjenislimbah','1')
        ->whereIn('tr_headermutasi.tgl_kadaluarsa',[Carbon::today()->addDays(3),Carbon::today()->addDays(7),Carbon::today()])
        // ->Where('tr_headermutasi.tgl_kadaluarsa',Carbon::today()->addDays(7))
        // ->Where('tr_headermutasi.tgl_kadaluarsa',Carbon::today())
        ->groupBy('tr_headermutasi.tgl_kadaluarsa','tr_headermutasi.idlimbah')->get();
        // ->whereRaw('DATE(tr_packing.kadaluarsa) = DATE(NOW()) + INTERVAL 3 DAY OR DATE(tr_packing.kadaluarsa) = DATE(NOW()) + INTERVAL 7 DAY' )->get(); 
        
        return $dataKadaluarsa;

    }
    public function dashboardToBeKadaluarsa1(){ 
      
        $dateNow3=Carbon::today()->addDays(3)->toDateString();
        $dateNow7=Carbon::today()->addDays(7)->toDateString();
         
        $date = date("Y-m-d");
        $date3 = strtotime($date."+ 3 days");
        // dd(date("Y-m-d",$date3));
        $dataKadaluarsa=DB::table('tr_headermutasi')
        ->join('md_namalimbah','tr_headermutasi.idlimbah','md_namalimbah.id') 
        ->join('md_tps','tr_headermutasi.idtps','md_tps.id')
        ->select(
            'md_namalimbah.namalimbah',
        'tr_headermutasi.tgl',
        'tr_headermutasi.jumlah_in',
        'tr_headermutasi.tgl_kadaluarsa',
        'md_tps.namatps'
        )
        
        ->where('tr_headermutasi.jumlah_in','!=',0)
        ->where('tr_headermutasi.idjenislimbah','1')
        ->whereIn('tr_headermutasi.idstatus',['1','2','3']) 
        ->whereBetween('tr_headermutasi.tgl_kadaluarsa',[$dateNow3, $dateNow7]) 
        ->orderBy('tr_headermutasi.tgl_kadaluarsa','asc')->get();
        // dd($dataKadaluarsa);
        return datatables()->of($dataKadaluarsa)

        // ->addIndexColumn()
        // ->addColumn('action', 'action_butt_pemohon')
        // ->rawColumns(['action'])

        ->make(true);

    }
    public function dataKuota(Request $request)
    {
        $dataKuota=$this->dashboardKuotaLimbah($request->period);
        return response()->json([
            'dataKuota'=>$dataKuota
            ]);
    }
    public function dashboardKuotaLimbah($period){ 
        // $date=DateTime::createFromFormat("m/Y", $period);
        // $month= $date->format('m');
        // $year=$date->format('Y'); 

        $dataKuota=DB::table('md_kuota')->where('tahun',$period)->get();  

        return $dataKuota;
    }

    public function getNotifikasi()
    {
        // $countKadaluarsa=DB::table('tr_packing')
        // ->where()
    }
    //Dashboard Neraca Kuota Anggaran
    public function dashboardNeracaKuota(Request $request){
        $pPeriod=$request->period;
        $arrTPS=$request->tps; 
        $arrDataPerBulan=[];
        for($i=1;$i<=count($arrTPS);$i++){
            $dataTPSPerBulan=$this->getDataPerTPSKuotaAnggaran($pPeriod,$i);
            $satuan=DB::table('md_tps')->where('id',$i)->first(); 
            $arrDataPerBulan['kuota-'.$i]=$dataTPSPerBulan;    
        }   
        return response()->json([
            'dataBar'=>$arrDataPerBulan 
            ]);

    }
    public function getDataPerTPSKuotaAnggaran($period,$tipe_kuota_limbah){
        $arrMasuk=[];
        $arrKeluar=[];
        $arrSisa=[];
        $arrData=[];
        $arrAllSisa=[];
        $dataNamaLimbah=DB::table('md_namalimbah')->where('tipe_kuota_limbah',$tipe_kuota_limbah)->pluck('id');
        // dd($dataNamaLimbah);
        $dataSatuan=DB::table('md_namalimbah')->where('tipe_kuota_limbah',$tipe_kuota_limbah)->first('konversi_kuota');
          
        for($i=1;$i<=12;$i++){   
            $jumlahMasuk[$i]=$this->querySaldoMutasiKuotaNeraca($period,$i,['1'], $dataNamaLimbah);
             
            $jumlahKeluar[$i]=$this->querySaldoMutasiKuotaNeraca($period,$i,['5','6','7','8','9'],$dataNamaLimbah);
            
            $jumlahSisa[$i]=null;
            $jumlahSisaPrev[$i]=0;
           
            //jika bulan lebih dari 0
            if($i>1){ 
                //  $jumlahSisa[$i]=$this->getSisaSaldo($period,$i,$dataNamaLimbah); 
                // dd($jumlahMasuk[$i]);
               
                //  $jumlahSisaPrev[$i]=$this->getSisaSaldo((int)$period,$i-1,$dataNamaLimbah);
                //  dd($i-2);
                 $jumlahMasuk[$i]= (int)$jumlahMasuk[$i] + (int) $arrAllSisa[$i-2];
                //  if($jumlahKeluar[$i]==0){
                //     $jumlahKeluar[$i]=$jumlahMasuk[$i];
                // }
                 $jumlahSisa[$i]=$jumlahMasuk[$i] - $jumlahKeluar[$i];
                 array_push($arrAllSisa,(int)$jumlahSisa[$i]); 
                
            }else{ 

                // $jumlahSisa[$i]=$this->getSisaSaldo($period,'1',['35']); 
                
                
                $jumlahSisaPrev[$i]=$this->getSisaSaldo((int)$period-1,12,$dataNamaLimbah);
                $jumlahMasuk[$i]= (int)$jumlahMasuk[$i] + (int) $jumlahSisaPrev[$i];
                // if($jumlahKeluar[$i]==0){
                //     $jumlahKeluar[$i]=0;
                // } 
                $jumlahSisa[$i]=$jumlahMasuk[$i] - $jumlahKeluar[$i];
 
                array_push($arrAllSisa,(int)$jumlahSisa[$i]); 
                // dd( $sisa);
                
                
            }
            $currMonth=date('m'); 
            //isi 0 untuk bulan yg depan depan
            if($i > ltrim($currMonth, '0')){
                array_push($arrMasuk,0); 
                array_push($arrKeluar,0); 
                array_push($arrSisa,0);
            }else{
                array_push($arrMasuk,(int)$jumlahMasuk[$i]); 
                array_push($arrKeluar,(int)$jumlahKeluar[$i]); 
                array_push($arrSisa,(int)$jumlahSisa[$i]);
            }
            
             
            

        }  
        $arrData['saldoMasuk']=$arrMasuk;
        $arrData['saldoKeluar']=$arrKeluar;
        $arrData['sisaSaldo']=$arrSisa;
        $arrData['satuan']=$dataSatuan->konversi_kuota;
        
        // dd($arrMasuk);
        return  $arrData;
    }
   
    public function querySaldoMutasiKuotaNeraca($year,$month,$status,$namalimbah){
         
        $resultData=DB::table('tr_detailmutasi')
        ->join('md_namalimbah','tr_detailmutasi.idlimbah','md_namalimbah.id') 
        ->select(DB::raw('sum(tr_detailmutasi.jumlah) as jumlah')) 
        ->whereYear('tr_detailmutasi.tgl', $year)
        ->whereMonth('tr_detailmutasi.tgl', $month) 
        ->whereIn('tr_detailmutasi.idstatus', $status)
        ->whereIn('tr_detailmutasi.idlimbah', $namalimbah) 
        // ->where('tr_detailmutasi.keterangan', null)
        ->first(); 
        
        $dataMasterLimbah=DB::table('md_namalimbah')->whereIn('id',$namalimbah)->first();
        // $satuanKecil=$dataMasterLimbah->satuan;
        $konversSatuan=$dataMasterLimbah->konversi_satuan_kecil;
        
        if($resultData->jumlah == null){
            $resultData->jumlah=0;
        }    
 
       
        // $valConvert= (float)$resultData->jumlah * (float)$konversSatuan;
        // $finalValue=round($valConvert, 1); 

        $finalValue=$resultData->jumlah;
          


        return $finalValue;
    }
    public function getSisaSaldo($year,$month,$namalimbah){

        $dataMasuk=$this->querySaldoMutasiKuotaNeraca(
            $year,
            $month,
            ['1'],
            $namalimbah
        );
        
        $dataKeluar=$this->querySaldoMutasiKuotaNeraca(
            $year,
            $month,
            ['5','6','7','8','9'],
            $namalimbah
        ); 
        
       
        // if((int)$dataKeluar==0){
        //     $jumlahSisa=0;
        // }else{
            $jumlahSisa=(int)$dataMasuk - (int)$dataKeluar;
        // }  
        return abs($jumlahSisa);
    }
    //dashboard neraca lain-lain
    public function dataNeraca(Request $request)
    {
        $dataNeraca=$this->dashboardNeraca($request);
        return $dataNeraca;
    }
    public function dashboardNeraca($request){
 
        $arrMasuk=[];
        $arrKeluar=[];
        $arrSisa=[];
        for($i=1;$i<=12;$i++){ 
            $jumlahMasuk[$i]=$this->querySaldoMutasi($request->period,$i,['1'], [$request->namalimbah]);
            $jumlahKeluar[$i]=$this->querySaldoMutasi($request->period,$i,['5','6','7','8','9'], [$request->namalimbah]);
            $jumlahSisa[$i]=null;
            $jumlahSisaPrev[$i]=null;
            if($i>0){ 
                $jumlahSisa[$i]=$this->getSisaSaldo($request->period,$i,[$request->namalimbah]); 
                $jumlahSisaPrev[$i]=$this->getSisaSaldo((int)$request->period,$i-1,[$request->namalimbah]);
           }else{ 
               $jumlahSisa[$i]=$this->getSisaSaldo((int)$request->period-1,$i,[$request->namalimbah]);
           }
            array_push($arrMasuk,(int)$jumlahMasuk[$i]+$jumlahSisaPrev[$i]); 
            array_push($arrKeluar,(int)$jumlahKeluar[$i]); 
            array_push($arrSisa,(int)$jumlahSisa[$i]); 
        } 
        $satuan=DB::table('md_namalimbah')->where('id',$request->namalimbah)
        ->first('satuan'); 
        return response()->json([
            'saldoMasuk'=>$arrMasuk,
            'saldoKeluar'=>$arrKeluar,
            'sisaSaldo'=>$arrSisa,
            'satuan'=>$satuan
            ]);
    }
    public function querySaldoMutasi($year,$month,$status,$namalimbah){
       
        // $mutasi=null;
        // if($modeMutasi == 'masuk'){
        //     $mutasi='pack_in';
        // }else{
        //     $mutasi='pack_out';
        // }
        $resultData=DB::table('tr_detailmutasi')
        ->join('md_namalimbah','tr_detailmutasi.idlimbah','md_namalimbah.id') 
        ->select(DB::raw('sum(tr_detailmutasi.pack)as pack'))
        ->whereYear('tr_detailmutasi.tgl', $year)
        ->whereMonth('tr_detailmutasi.tgl', $month) 
        ->whereIn('tr_detailmutasi.idstatus', $status)
        ->whereIn('tr_detailmutasi.idlimbah', [$namalimbah]) 
        // ->where('tr_detailmutasi.keterangan', null)
        ->first();  
        // dd($resultData);
        if($resultData->pack == null){
            $resultData->pack=0;
        }     
        return $resultData->pack;
    }
    

    public function dataPenghasil(Request $request)
    {
        $dataPenghasil=$this->dashboardPenghasil($request);
        $satuan=DB::table('md_namalimbah')->where('id',$request->namalimbah)
        ->first('satuan');
        return response()->json([
            'dataPenghasil'=>$dataPenghasil,
            'satuan'=>$satuan
            ]); 
    }
    public function dashboardPenghasil($request){

        // $date=DateTime::createFromFormat("m/Y", $request->period);
        // $month= $date->format('m');
        // $year=$date->format('Y'); 
        $dataChart=[]; 
       
        for($i=1;$i<=12;$i++){
            $dataPenghasil[$i]=DB::table('tr_detailmutasi')
            ->join('md_namalimbah','tr_detailmutasi.idlimbah','md_namalimbah.id')
            ->join('md_penghasillimbah','tr_detailmutasi.idasallimbah','md_penghasillimbah.id')
            ->select(DB::raw('sum(tr_detailmutasi.jumlah) as jumlah'))
            ->whereYear('tr_detailmutasi.tgl', $request->period)
            ->whereMonth('tr_detailmutasi.tgl', $i)
            // ->whereYear('tr_headermutasi.created_at', '2020')
            // ->whereMonth('tr_headermutasi.created_at', $i)
            ->where('tr_detailmutasi.idasallimbah', $request->unit_kerja)
            ->where('tr_detailmutasi.idlimbah', $request->namalimbah) 
            ->where('tr_detailmutasi.idstatus', '1')
            // ->where('tr_detailmutasi.keterangan', '!=','proses langsung')
            ->first();   

            if($dataPenghasil[$i]->jumlah == null){
                $dataPenghasil[$i]->jumlah=0;
            }    
            array_push($dataChart,(int)$dataPenghasil[$i]->jumlah); 

        } 
        return $dataChart;
    }
    public function persentage($kapasitasjumlah,$presentage){

        $dataCalculate=round(($kapasitasjumlah * (int)$presentage) / (int)100);
        // dd( $dataCalculate);

        return $dataCalculate;

    }
    public function dataNotifikasi(Request $request)
    {
        $user = Auth::user();
         
        $roleuser=$user->roles->first()->name;
         
        $arrNotifikasi=new \stdClass(); 
        $arrKadaluarsa3=new \stdClass(); 
        $arrKadaluarsa7=new \stdClass(); 
        $arrIsi=[];
        $notifKapasitas=new \stdClass(); 
        $arrKapasitas=[]; 

        $dataNotifikasi=$this->dashboardToBeKadaluarsa(); 
        // dd($dataNotifikasi);

        $dataKapasitas=DB::table('md_tps')
        ->get(); 
        for($i=0;$i<count($dataKapasitas);$i++){

            $saldo=(int)$dataKapasitas[$i]->saldo;
            
            $kapasitasjumlah=(int)$dataKapasitas[$i]->kapasitasjumlah;
            // dd($saldo >= $this->persentage($kapasitasjumlah,90));
            if($saldo >= $this->persentage($kapasitasjumlah,75) && $saldo <= $this->persentage($kapasitasjumlah,90)){
                $notifKapasitas=array(
                    'saldo'=>$saldo,
                    'tps'=>$dataKapasitas[$i]->namatps,
                    'status'=>'Waspada',
                    'kapasitas'=>$dataKapasitas[$i]->kapasitasjumlah,
                ); 
                array_push($arrKapasitas,$notifKapasitas); 

            }else if($saldo >= $this->persentage($kapasitasjumlah,90)){
                $notifKapasitas=array(
                    'saldo'=>$saldo,
                    'tps'=>$dataKapasitas[$i]->namatps,
                    'status'=>'Bahaya',
                    'kapasitas'=>$dataKapasitas[$i]->kapasitasjumlah,
                ); 

                array_push($arrKapasitas,$notifKapasitas);  
            }else{
                $notifKapasitas=null; 
            }

        } 
        $jumlahKadaluarsa3hari=0;
        $jumlahKadaluarsa7hari=0;
        if(count($dataNotifikasi) == 0){
            $arrNotifikasi=null;
        }else{ 
            for($i=0;$i<count($dataNotifikasi);$i++){ 
                // dd($dataNotif);
                $date3=date('Y-m-d', strtotime("+ 3 day",strtotime("now"))); 
                $date7=date('Y-m-d', strtotime("+ 7 day",strtotime("now")));
                
               if($dataNotifikasi[$i]->tgl_kadaluarsa == $date3){
                $jumlahKadaluarsa3hari++;
                $arrKadaluarsa3=array(
                    'tanggal'=>$dataNotifikasi[$i]->tgl_kadaluarsa,
                    'jumlah'=>$jumlahKadaluarsa3hari,
                    'status'=>'Waspada'
                );
                array_push($arrIsi,$arrKadaluarsa3);

               }else if($dataNotifikasi[$i]->tgl_kadaluarsa == $date7){
                $jumlahKadaluarsa7hari++;
                $arrKadaluarsa7=array(
                    'tanggal'=>$dataNotifikasi[$i]->tgl_kadaluarsa,
                    'jumlah'=> $jumlahKadaluarsa7hari,
                    'status'=>'Bahaya'
                );
                array_push($arrIsi,$arrKadaluarsa7);
               } 
    
            }
            $arrNotifikasi->keys=$dataNotifikasi->groupBy('tgl_kadaluarsa')->keys()->toArray();
            $arrNotifikasi->values=$arrIsi;
            // dd($arrIsi);
        }
        
        return response()->json([ 
            'dataNotifikasi'=>$arrNotifikasi, 
            'notifikasiKapasitas'=>$arrKapasitas, 
            'role'=>$roleuser
            ]);
    }
    public function notifikasiMasuk(Request $request){
        
        $user = Auth::user();
         
        $roleuser=$user->roles->first()->name;

        $userUnit=AuthHelper::getAuthUser()[0];
       
        $resultData=DB::table('tr_headermutasi'); 
        
        if($roleuser=='pengawas'){
            $resultData= $resultData->where('tr_headermutasi.validated_by', null)
                ->where('tr_headermutasi.idstatus', '!=','11')->distinct('id');;
        }else{
            $resultData= $resultData->where('tr_headermutasi.idstatus', '1')
            ->where('tr_headermutasi.np_penerima',null);
        }
        $resultData=$resultData->get()->count(); 
         
        $dataBAPemusnahan=DB::table('tr_validasi_ba')
        ->join('tr_detailmutasi','tr_detailmutasi.id','tr_validasi_ba.id_detail');
        if($roleuser=='pengawas'){
            $dataBAPemusnahan= $dataBAPemusnahan->where('tr_validasi_ba.np_pengawas',null);
        }else{
            // dd($userUnit->seksi);
            $dataBAPemusnahan= $dataBAPemusnahan
            ->where('tr_detailmutasi.idasallimbah',$userUnit->seksi)
            ->where('tr_validasi_ba.np_pemohon',null);
        }
        
        
        $dataBAPemusnahan= $dataBAPemusnahan->get()->count(); 
        // dd($dataBAPemusnahan);

        
        return response()->json([ 
            'notifMasuk'=>$resultData, 
            'notifValidasiBA'=>$dataBAPemusnahan,
            'role'=>$roleuser
            
            ]);
    }
}
