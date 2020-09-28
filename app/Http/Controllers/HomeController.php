<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laratrust\LaratrustFacade as Laratrust;
use App\Helpers\QueryHelper; 
use App\Helpers\UpdKaryawanHelper; 
use App\Http\Requests;
use App\Jadwal;
use App\Helpers\AppHelper;
use App\Role;
use DB;
use Illuminate\Support\Facades\Auth;
use PDO;

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
            UpdKaryawanHelper::updatePegawai();
            return view('dashboard.dashboard');
            
        } else if(Laratrust::hasRole('unit kerja') ) {
            UpdKaryawanHelper::updatePegawai();
            // return view('pemohon.create', QueryHelper::getDropDown());
            return redirect()->route('pemohon.entri', QueryHelper::getDropDown());
        }else if(Laratrust::hasRole('pengawas') ) {
            // dd('tes');
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
    public function dashboardKuotaLimbah($tahun){ 
        $dataKuota=DB::table('md_kuota')->where('tahun',$tahun)->get(); 

        // $arrKuota=new \stdClass();
        

        // // $datatoArray=$dataPenghasil->groupBy('seksi');
        // $datalabel=$dataKuota->keyBy('seksi')->keys();
        // $datavalues=$dataPenghasil->keyBy('jumlah')->keys();
        // // dd($datavalues);
        // $arrKuota->labels=$datalabel;
        // $arrKuota->values=$datavalues;

        return $dataKuota;
    }
    public function dashboardKapasitas(){

        $dataKapasitas=DB::table('md_tps')->get(); 

        return $dataKapasitas;
    }
    public function dashboardPenghasil(){

        $dataPenghasil=DB::table('tr_headermutasi')
        ->join('md_namalimbah','tr_headermutasi.idlimbah','md_namalimbah.id')
        ->join('md_penghasillimbah','tr_headermutasi.idasallimbah','md_penghasillimbah.id')
        ->select(DB::raw('sum(tr_headermutasi.jumlah) as jumlah'),'md_penghasillimbah.seksi')
        ->where('tr_headermutasi.created_at','2020-09-25')
        ->groupBy('md_penghasillimbah.seksi')
        ->get(); 

        $arrPenghasil=new \stdClass();
        

        // $datatoArray=$dataPenghasil->groupBy('seksi');
        $datalabel=$dataPenghasil->keyBy('seksi')->keys();
        $datavalues=$dataPenghasil->keyBy('jumlah')->keys();
        // dd($datavalues);
        $arrPenghasil->labels=$datalabel;
        $arrPenghasil->values=$datavalues;
//         $dataValue=$datatoArray->values();
//         $dataSludge=[];
//         $dataAbu=[];
//         $dataCair=[];
//         $dataSK=[];
//         $dataKaleng=[];
//         $dataDrum=[];
//         $addArr=new \stdClass();

// // dd(count($dataValue[1]));
//         for($i=0;$i<count($datalabel);$i++){
            
//             if(count($dataValue[$i]) != 6){
//                 // dd((int)6-count($dataValue[$i]));
//                 // dd(6-count($dataValue[$i]));
//                 $tipeLimbah=$dataValue[$i]->keyBy('tipelimbah');
//                 // dd($tipeLimbah->keys());
                
//                 for($j=0;$j< 6 - count($dataValue[$i]);$j++){
                     
//                     if(!$tipeLimbah->search('Kaleng')){
//                         // dd($tipeLimbah->search('Kaleng'));
//                         $addArr->jumlah=0; 
//                         $addArr->tipelimbah='Kaleng'; 
//                         $dataValue[$i]->push($addArr);
//                     }else if(!$tipeLimbah->keys('Limbah Cair')){
//                         $addArr->jumlah=0; 
//                         $addArr->tipelimbah='Limbah Cair';
//                         $dataValue[$i]->push($addArr);
//                     }else if(!$tipeLimbah->keys('Abu')){
//                         $addArr->jumlah=0; 
//                         $addArr->tipelimbah='Abu';
//                         $dataValue[$i]->push($addArr);
//                     } else if(!$tipeLimbah->keys('Sludge')){
//                         $addArr->jumlah=0; 
//                         $addArr->tipelimbah='Sludge';
//                         $dataValue[$i]->push($addArr);
//                     }else if(!$tipeLimbah->keys('Drum')){
//                         $addArr->jumlah=0; 
//                         $addArr->tipelimbah='Drum';
//                         $dataValue[$i]->push($addArr);
//                     }else if(!$tipeLimbah->keys('Sampah Kontaminasi')){
//                         $addArr->jumlah=0; 
//                         $addArr->tipelimbah='Sampah Kontaminasi';
//                         $dataValue[$i]->push($addArr);
//                     }
                    

//                 }


//             }


//             // if(){

//             // }

//         }

        // dd($arrPenghasil);
        return $arrPenghasil;
    }
    public function dashboardToBeKadaluarsa(){

        $dataKadaluarsa=DB::table('tr_packing')
        ->join('md_namalimbah','tr_packing.idlimbah','md_namalimbah.id')
        ->join('md_tps','tr_packing.idtps','md_tps.id')
        ->select('md_namalimbah.namalimbah','tr_packing.created_at','tr_packing.kadaluarsa','md_tps.namatps')
        ->whereRaw('DATE(kadaluarsa) = DATE_ADD(CURDATE(), INTERVAL 7 DAY) OR DATE(kadaluarsa) = DATE_ADD(CURDATE(), INTERVAL 3 DAY)')->get(); 
        // dd($dataKadaluarsa);
        return $dataKadaluarsa;

    }
    public function dataDashboard(Request $request)
    {
         
        $dataKuota=$this->dashboardKuotaLimbah($request->tahun);
        $dataKadaluarsa=$this->dashboardToBeKadaluarsa();  
        $dataKapasitas=$this->dashboardKapasitas();

        $dataPenghasil=$this->dashboardPenghasil();
        // $dataKadaluarsa=$this->dashboardToBeKadaluarsa(); 
        return response()->json([
            'dataKuota'=>$dataKuota,
            'dataKapasitas'=>$dataKapasitas,
            'dataPenghasil'=>$dataPenghasil,
            'dataKadaluarsa'=>$dataKadaluarsa, 
            ]);
    }
}
