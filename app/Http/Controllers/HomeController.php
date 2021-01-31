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
        // dd(DB::table('cemori.tbl_status')->get());
        // dd(Laratrust::hasRole('Pengawas'));
        // dd(Laratrust::hasRole('operator')); 
        if (Laratrust::hasRole('admin') || Laratrust::hasRole('operator')) {

            //     // $getYear = DB::table('desain_tahun')->orderBy('tahun','desc')->get();
            //     // $year=[];
            //     // for($i=0;$i<count($getYear);$i++){
            //     //     array_push($year,$getYear[$i]->tahun);
            //     //     if($getYear[$i]->tahun == '2019'){ 
            //     //     break;
            //     //     }
            //     // }
            //     // dd($year);
            //     // $book = Book::all();

            //     // $member = Role::where('name', 'member')->first()->users;

            //     // $borrow = BorrowLog::all();
            //     // return view('dashboard.admin', compact('author', 'book', 'member', 'borrow'));

            //     return view('dashboard.admin',[
            //         // 'year'=>$year
            //     ]);
            $penghasilLimbah=DB::table('md_penghasillimbah')->get();
            $namaLimbah=DB::table('md_namalimbah')->get();
            UpdKaryawanHelper::updatePegawai();
            return view('dashboard.dashboard',[
                'penghasilLimbah'=>$penghasilLimbah,
                'namaLimbah'=>$namaLimbah
                ] 
            );
            
        } else if(Laratrust::hasRole('unit kerja') ) {
            UpdKaryawanHelper::updatePegawai();
            // return view('pemohon.create', QueryHelper::getDropDown());
            return redirect()->route('pemohon.entri', QueryHelper::getDropDown());
        }else if(Laratrust::hasRole('pengawas')) {
            
            UpdKaryawanHelper::updatePegawai();
            return redirect()->route('pemohon.listview', QueryHelper::getDropDown());
            // return view('pemohon.list', QueryHelper::getDropDown());
        }


        // return view('home');
    }

    public function getNotifikasi()
    {
        // $countKadaluarsa=DB::table('tr_packing')
        // ->where()
    }
    public function dashboardKuotaLimbah($period){ 
        // $date=DateTime::createFromFormat("m/Y", $period);
        // $month= $date->format('m');
        // $year=$date->format('Y'); 

        $dataKuota=DB::table('md_kuota')->where('tahun',$period)->get();  

        return $dataKuota;
    }
    public function dashboardKapasitas($request){

        $dataKapasitas=DB::table('md_tps')->get(); 

        return $dataKapasitas;
    }
    public function dashboardPenghasil($request){

        // $date=DateTime::createFromFormat("m/Y", $request->period);
        // $month= $date->format('m');
        // $year=$date->format('Y'); 
        $dataChart=[];
       
        for($i=1;$i<=12;$i++){
            $dataPenghasil[$i]=DB::table('tr_headermutasi')
            ->join('md_namalimbah','tr_headermutasi.idlimbah','md_namalimbah.id')
            ->join('md_penghasillimbah','tr_headermutasi.idasallimbah','md_penghasillimbah.id')
            ->select(DB::raw('sum(tr_headermutasi.jumlah) as jumlah'))
            ->whereYear('tr_headermutasi.created_at', $request->period)
            ->whereMonth('tr_headermutasi.created_at', $i)
            // ->whereYear('tr_headermutasi.created_at', '2020')
            // ->whereMonth('tr_headermutasi.created_at', $i)
            ->where('tr_headermutasi.idasallimbah', $request->unit_kerja)
            ->where('tr_headermutasi.idlimbah', $request->namalimbah) 
            ->first(); 
            

            if($dataPenghasil[$i]->jumlah == null){
                $dataPenghasil[$i]->jumlah=0;
            }    
            array_push($dataChart,(int)$dataPenghasil[$i]->jumlah); 

        } 
        return $dataChart;
    }
    public function querySaldoMutasi($year,$month,$status,$namalimbah){
        $resultData=DB::table('tr_detailmutasi')
        ->join('md_namalimbah','tr_detailmutasi.idlimbah','md_namalimbah.id')
        
        ->select(DB::raw('sum(tr_detailmutasi.jumlah) as jumlah'))

        ->whereYear('tr_detailmutasi.created_at', $year)
        ->whereMonth('tr_detailmutasi.created_at', $month) 
        ->whereIn('tr_detailmutasi.idstatus', $status)
        ->where('tr_detailmutasi.idlimbah', $namalimbah) 
        ->first();  
        if($resultData->jumlah == null){
            $resultData->jumlah=0;
        }    

        return $resultData->jumlah;
    }
    public function dashboardNeraca($request){

        // $date=DateTime::createFromFormat("m/Y", $request->period);
        // $month= $date->format('m');
        // $year=$date->format('Y'); 
        $arrMasuk=[];
        $arrKeluar=[];
        $arrSisa=[];
       
        for($i=1;$i<=12;$i++){

            $jumlahMasuk[$i]=$this->querySaldoMutasi($request->period,$i,['2'], $request->namalimbah);
          
            // DB::table('tr_detailmutasi')
            // ->join('md_namalimbah','tr_detailmutasi.idlimbah','md_namalimbah.id')
            
            // ->select(DB::raw('sum(tr_detailmutasi.jumlah) as jumlah'))

            // ->whereYear('tr_detailmutasi.created_at', $request->period)
            // ->whereMonth('tr_detailmutasi.created_at', $i) 
            // ->where('tr_detailmutasi.idstatus', '2')
            // ->where('tr_detailmutasi.idlimbah', $request->namalimbah) 
            // ->first();  
            // if($dataMasuk[$i]->jumlah == null){
            //     $dataMasuk[$i]->jumlah=0;
            // }    

            $jumlahKeluar[$i]=$this->querySaldoMutasi($request->period,$i,['5','6','7','8','9'], $request->namalimbah);
            // DB::table('tr_detailmutasi')
            // ->join('md_namalimbah','tr_detailmutasi.idlimbah','md_namalimbah.id')
            
            // ->select(DB::raw('sum(tr_detailmutasi.jumlah) as jumlah'))

            // ->whereYear('tr_detailmutasi.created_at', $request->period)
            // ->whereMonth('tr_detailmutasi.created_at', $i) 
            // ->whereIn('tr_detailmutasi.idstatus', ['5','6','7','8','9'])
            // ->where('tr_detailmutasi.idlimbah', $request->namalimbah) 
            // ->first();  
            // if($dataKeluar[$i]->jumlah == null){
            //     $dataKeluar[$i]->jumlah=0;
            // }    
            $jumlahSisa[$i]=null;
            if($i>0){
                //jika bulan ke 2 sampe 12 ambil bulan sebelumnya
                $dataMasuk=$this->querySaldoMutasi(
                    $request->period,
                    $i-1,
                    ['2'],
                    $request->namalimbah
                );
                $dataKeluar=$this->querySaldoMutasi(
                    $request->period,
                    $i-1,
                    ['5','6','7','8','9'],
                    $request->namalimbah
                );
                // dd($jumlahMasuk);
                $jumlahSisa[$i]=(int)$dataMasuk - (int)$dataKeluar;
            }else{
                //jika bulan awal tahun ambil sisa dari tahun dan bulan sebelumnya
                $dataMasuk=$this->querySaldoMutasi(
                    (int)$request->period-1,
                    '12',
                    ['2'],
                    $request->namalimbah
                );
                $dataKeluar=$this->querySaldoMutasi(
                    (int)$request->period-1,
                    '12',
                    ['5','6','7','8','9'],
                    $request->namalimbah
                );
                $jumlahSisa[$i]=(int)$dataMasuk - (int)$dataKeluar;
            }
            




            array_push($arrMasuk,(int)$jumlahMasuk[$i]); 
            array_push($arrKeluar,(int)$jumlahKeluar[$i]); 
            array_push($arrSisa,(int)$jumlahSisa[$i]); 

        } 
        return response()->json([
            'saldoMasuk'=>$arrMasuk,
            'saldoKeluar'=>$arrKeluar,
            'sisaSaldo'=>$arrSisa
            ]);
    }
    public function dashboardToBeKadaluarsa(){

        $dataKadaluarsa=DB::table('tr_packing')
        ->join('md_namalimbah','tr_packing.idlimbah','md_namalimbah.id')
        ->join('tr_statusmutasi','tr_statusmutasi.id','tr_packing.idmutasi')
        ->join('md_tps','tr_packing.idtps','md_tps.id')
        ->select('md_namalimbah.namalimbah','tr_packing.created_at','tr_packing.kadaluarsa','md_tps.namatps',DB::raw('sum(tr_statusmutasi.jumlah) as jumlah'))
        ->where('tr_packing.kadaluarsa',Carbon::today()->addDays(3))
        ->orWhere('tr_packing.kadaluarsa',Carbon::today()->addDays(7))
        ->groupBy('tr_packing.kadaluarsa')->get();
        // ->whereRaw('DATE(tr_packing.kadaluarsa) = DATE(NOW()) + INTERVAL 3 DAY OR DATE(tr_packing.kadaluarsa) = DATE(NOW()) + INTERVAL 7 DAY' )->get(); 
        
        return $dataKadaluarsa;

    }
    public function dashboardToBeKadaluarsa1(){

        $dataKadaluarsa=DB::table('tr_packing')
        ->join('md_namalimbah','tr_packing.idlimbah','md_namalimbah.id')
        ->join('tr_headermutasi','tr_headermutasi.id','tr_packing.idmutasi')
        ->join('md_tps','tr_packing.idtps','md_tps.id')
        ->select('md_namalimbah.namalimbah','tr_packing.created_at','tr_packing.kadaluarsa','md_tps.namatps',DB::raw('sum(tr_headermutasi.jumlah) as jumlah'))
        ->where('tr_packing.kadaluarsa',Carbon::today()->addDays(3))
        ->orWhere('tr_packing.kadaluarsa',Carbon::today()->addDays(7))
        ->groupBy('tr_packing.kadaluarsa')->get();
        // dd($dataKadaluarsa);
        // return $dataKadaluarsa;
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
    public function dataNeraca(Request $request)
    {
        $dataNeraca=$this->dashboardNeraca($request);
        return $dataNeraca;
    }
    public function dataPenghasil(Request $request)
    {
        $dataPenghasil=$this->dashboardPenghasil($request);
        return $dataPenghasil;
    }
    
    public function dataDashboard(Request $request)
    {
        // dd($request->all()); 
      
        $dataKadaluarsa=$this->dashboardToBeKadaluarsa();
        $dataNotifikasi=$this->dashboardToBeKadaluarsa(); 
        $arrNotifikasi=new \stdClass(); 
        $arrIsi=[];
        
        // $dataIsi=$dataNotifikasi->groupBy('kadaluarsa')->keys()->toArray();
        $dataNotif=$dataNotifikasi->groupBy('kadaluarsa')->values()->toArray();
        // $datavalues=$dataPenghasil->keyBy('jumlah')->keys();
        for($i=0;$i<count($dataNotif);$i++){
            // $arrNotifikasi->isi=count($dataNotif[$i]);
            array_push($arrIsi,count($dataNotif[$i]));
            // dd($dataJumlah);

        }
        $arrNotifikasi->keys=$dataNotifikasi->groupBy('kadaluarsa')->keys()->toArray();
        $arrNotifikasi->values=$arrIsi; 
        $dataKapasitas=$this->dashboardKapasitas($request);
 
        return response()->json([ 
            'dataKapasitas'=>$dataKapasitas, 
            'dataKadaluarsa'=>$dataKadaluarsa, 
            'dataNotifikasi'=>$arrNotifikasi, 
            ]);
    }
    public function persentage($kapasitasjumlah,$presentage){

        $dataCalculate=round(($kapasitasjumlah * (int)$presentage) / (int)100);
        // dd( $dataCalculate);

        return $dataCalculate;

    }
    public function dataNotifikasi(Request $request)
    {
         
        $arrNotifikasi=new \stdClass(); 
        $arrKadaluarsa3=new \stdClass(); 
        $arrKadaluarsa7=new \stdClass(); 
        $arrIsi=[];
        $notifKapasitas=new \stdClass(); 
        $arrKapasitas=[];

        $dataNotifikasi=$this->dashboardToBeKadaluarsa(); 

        $dataKapasitas=DB::table('md_tps')
        ->get();
        // dd($dataKapasitas);

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
                // $notifKapasitas->saldo=$saldo;
                // $notifKapasitas->tps=$dataKapasitas[$i]->namatps;
                // $notifKapasitas->status='Waspada';
             
                array_push($arrKapasitas,$notifKapasitas);
                // dd($arrKapasitas);

            }else if($saldo >= $this->persentage($kapasitasjumlah,90)){
                $notifKapasitas=array(
                    'saldo'=>$saldo,
                    'tps'=>$dataKapasitas[$i]->namatps,
                    'status'=>'Bahaya',
                    'kapasitas'=>$dataKapasitas[$i]->kapasitasjumlah,
                );
                // $notifKapasitas->saldo=$saldo;
                // $notifKapasitas->tps=$dataKapasitas[$i]->namatps;
                // $notifKapasitas->status='Bahaya';

                array_push($arrKapasitas,$notifKapasitas); 
                // dd($notifKapasitas);
            }else{
                $notifKapasitas=null;
                // array_push($arrKapasitas,$notifKapasitas);
            }

            

        } 

        if(count($dataNotifikasi) == 0){
            $arrNotifikasi=null;
        }else{
           
            
            // $dataIsi=$dataNotifikasi->groupBy('kadaluarsa')->keys()->toArray();
            // $dataNotif=$dataNotifikasi->groupBy('kadaluarsa')->values();
          
            // $datavalues=$dataPenghasil->keyBy('jumlah')->keys();
        //    dd($dataNotif);
            for($i=0;$i<count($dataNotifikasi);$i++){ 
                // dd($dataNotif);
                $date3=date('Y-m-d', strtotime("+ 3 day",strtotime($dataNotifikasi[$i]->kadaluarsa)));
                $date7=date('Y-m-d', strtotime("+ 7 day",strtotime($dataNotifikasi[$i]->kadaluarsa)));
                
               if($dataNotifikasi[$i]->kadaluarsa == $date3){
                $arrKadaluarsa3=array(
                    'tanggal'=>$dataNotifikasi[$i]->kadaluarsa,
                    'jumlah'=>0,
                    'status'=>'Waspada'
                );
               }else if($dataNotifikasi[$i]->kadaluarsa == $date7){
                $arrKadaluarsa7=array(
                    'tanggal'=>$dataNotifikasi[$i]->kadaluarsa,
                    'jumlah'=>0,
                    'status'=>'Bahaya'
                );
               }
                

                

                array_push($arrIsi,$arrKadaluarsa3);
                array_push($arrIsi,$arrKadaluarsa7);
                // dd($dataJumlah);
    
            }
            $arrNotifikasi->keys=$dataNotifikasi->groupBy('kadaluarsa')->keys()->toArray();
            $arrNotifikasi->values=$arrIsi;
        }
        
        
         
        return response()->json([ 
            'dataNotifikasi'=>$arrNotifikasi, 
            'notifikasiKapasitas'=>$arrKapasitas, 
            ]);
    }
}
