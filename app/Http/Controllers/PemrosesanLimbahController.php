<?php

namespace App\Http\Controllers;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str; 
use App\Helpers\AppHelper; 
use App\Helpers\UpdtSaldoHelper; 
use App\Helpers\AuthHelper; 
 
use Redirect;
use Validator;
use Response;
use DB;
use PDF;
use PDO;

class PemrosesanLimbahController extends Controller
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
    public function index(Request $request)
    {
        //
      
        // $status= DB::table('tr_mutasilimbah')->get();
        if (request()->ajax()) {
            $queryData = DB::table('tr_packing')
                ->join('tr_headermutasi','tr_packing.idmutasi','=','tr_headermutasi.id')
                // ->join('tr_headermutasi', 'tr_packing.idmutasi', '=', 'tr_headermutasi.id')
                ->join('md_namalimbah', 'tr_packing.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_tps', 'tr_packing.idtps', '=', 'md_tps.id')
                ->join('tr_statusmutasi', 'tr_packing.idmutasi', '=', 'tr_statusmutasi.idmutasi')
                ->join('md_statusmutasi', 'tr_statusmutasi.idstatus', '=', 'md_statusmutasi.id')
                ->join('md_satuan', 'tr_statusmutasi.idsatuan', '=', 'md_satuan.id')
                ->select(
                    'tr_packing.no_packing',
                    // 'tr_headermutasi.jumlah',
                    // 'md_namalimbah.namalimbah',
                    'tr_headermutasi.id_transaksi',
                    'md_tps.namatps',
                    'md_statusmutasi.keterangan',
                    'tr_packing.*',
                    'md_satuan.satuan'
                    // 'md_namalimbah.namalimbah',
                )
                ->whereIn('tr_packing.idstatus',['3','4','5','6','7'])
                ->groupBy('tr_packing.kode_pack'); 

            $queryData = $queryData->get();
            return datatables()->of($queryData)

                ->addIndexColumn()
                // ->addColumn('action', 'action_butt_pemohon')
                // ->rawColumns(['action'])

                ->make(true);
        }
        return view('pemrosesan.list', [
           
        ]);
    }
   
    public function updateSaldoKuota($tipelimbah,$jenislimbah,$jumlah){
        if($jenislimbah==1){
            if($tipelimbah=='Limbah Cair'){
                $dataKuota = DB::table('md_kuota')->where('tipe_limbah', 'Limbah Cair B3')->first();
                $konsumsi= $dataKuota->konsumsi;
                $sisa= $dataKuota->sisa;
                $konsumsi +=  $jumlah;
                $sisa -=  $jumlah;
                $dataUpdate=array(
                    'konsumsi' => $konsumsi,
                    'sisa' => $sisa

                );

                $queryUpdate = DB::table('md_kuota')->where('tipe_limbah', 'Limbah Cair B3')->update($dataUpdate);

            }else if($tipelimbah=='Sampah Kontaminasi'){
                $dataKuota = DB::table('md_kuota')->where('tipe_limbah', 'Limbah S.K')->first();
                $konsumsi= $dataKuota->konsumsi;
                $sisa= $dataKuota->sisa;
                $konsumsi +=  $jumlah;
                $sisa -=  $jumlah;
                $dataUpdate=array(
                    'konsumsi' => $konsumsi,
                    'sisa' => $sisa

                );

                $queryUpdate = DB::table('md_kuota')->where('tipe_limbah', 'Limbah S.K')->update($dataUpdate);
            }else if($tipelimbah=='Sludge'){
                $dataKuota = DB::table('md_kuota')->where('tipe_limbah', 'Limbah Sludge')->first();
                $konsumsi= $dataKuota->konsumsi;
                $sisa= $dataKuota->sisa;
                $konsumsi +=  $jumlah;
                $sisa -=  $jumlah;
                $dataUpdate=array(
                    'konsumsi' => $konsumsi,
                    'sisa' => $sisa

                );

                $queryUpdate = DB::table('md_kuota')->where('tipe_limbah', 'Limbah Sludge')->update($dataUpdate);
            }


        }else{

        }
        


    }
    public function detaillist(Request $request)
    {
        //
      
        // $status= DB::table('tr_mutasilimbah')->get();
        if (request()->ajax()) {
            $queryData = DB::table('tr_packing')
                ->join('tr_headermutasi','tr_packing.idmutasi','=','tr_headermutasi.id')
                ->join('md_namalimbah', 'tr_packing.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_tps', 'tr_packing.idtps', '=', 'md_tps.id')
                ->join('tr_statusmutasi', 'tr_packing.idmutasi', '=', 'tr_statusmutasi.idmutasi')
                ->join('md_statusmutasi', 'tr_statusmutasi.idstatus', '=', 'md_statusmutasi.id')
                ->join('md_satuan', 'tr_statusmutasi.idsatuan', '=', 'md_satuan.id')
                ->select('tr_packing.*',
                'tr_headermutasi.id_transaksi', 
                'tr_headermutasi.idlimbah',
                'tr_headermutasi.idjenislimbah',
                'tr_headermutasi.idasallimbah',
                'tr_headermutasi.idtps',
                'tr_headermutasi.tgl',
                'tr_headermutasi.idsatuan',
                'tr_headermutasi.limbah3r', 
                'md_satuan.satuan as nama_satuan',
                'tr_statusmutasi.jumlah', 

                
                'md_namalimbah.*',
                'md_tps.*',
               
                'md_satuan.satuan as nama_satuan')
                ->where('tr_packing.kode_pack','=',$request->kodepack); 

            $queryData = $queryData->get();
            // dd($queryData);
            return datatables()->of($queryData)

                ->addIndexColumn()
                ->addColumn('action', 'f_proses_out')
                ->rawColumns(['action'])

                ->make(true);
        }
         
    }
    public function proses(Request $request)
    {
        // dd($request->all());
        $username=AuthHelper::getAuthUser()[0]->email;
        $getRequest = json_decode($request->getContent(), true);

        $dataRequest = $getRequest['detail'];

        $countDataReq = count($dataRequest);
        // dd($dataRequest);
        $error = null;
        $dataDetail = null;
        $nopack = null;
        try {
            foreach ($dataRequest as $row) {
                $dataHeader=DB::table('tr_headermutasi')->where('id',$row['idmutasi'])->first();
                $dataStatus=DB::table('tr_statusmutasi')->where('idmutasi', $row['idmutasi'])->first();
                // dd($dataHeader);
                $jmlh=$dataHeader->jumlah;
                $valJumlah=(int)$row['jumlah'] - (int)$row['jmlh_proses'];
                $status=null;
                if($valJumlah == 0){
                    $status=$row['idstatus'];
                }else{
                    $status=$row['status_lama'];
                }
                $jmlhOut=(int)$dataStatus->jumlah_out + (int)$row['jmlh_proses'];
                
                $dataDetail = array(
                    'id_transaksi'      =>  $row['id_transaksi'],
                    'idmutasi'            => $row['idmutasi'],
                    'idlimbah'            => $row['idlimbah'],
                    'idjenislimbah'            => $row['idjenislimbah'],
                    'idstatus'            => $row['idstatus'],
                    'idasallimbah'            => $row['idasallimbah'],
                    'idtps'            => $row['idtps'],
                    'tgl'            => $row['tgl'],
                    'jumlah'            => $row['jmlh_proses'],
                    'idsatuan'            => $row['idsatuan'],
                    // 'jumlah_out'            => $row['jmlh_proses'], 
                    'limbah3r'            => $row['limbah3r'],
                    'created_at'        => date('Y-m-d'),
                    'np'                   =>$row['np'],
                    'created_by'            =>$username,

                );
               
                $dataStatus = array(
                    'id_transaksi'          =>  $row['id_transaksi'],
                    'idstatus'              =>  $status,
                    'updated_at'            => date('Y-m-d'),
                    'jumlah'                => $valJumlah,
                    'jumlah_out'            => $jmlhOut,
                    'idsatuan'              => $row['idsatuan'],
                    'idtps'                 => $row['idtps'],
                    'np'                    => $row['np'],
                    'changed_by'            => $username,
                );
                $dataPacking = array(
                    'id_transaksi'          =>  $row['id_transaksi'],
                    'no_packing'            =>  $row['no_packing'],
                    // 'kode_pack'            => $row['kode_pack'],
                    'idmutasi'              => $row['idmutasi'],
                    'idlimbah'              => $row['idlimbah'],
                    'idtps'                 => $row['idtps'],
                    'tipelimbah'            => $row['tipelimbah'],
                    'idstatus'              => $status,
                    'kadaluarsa'            => date('Y-m-d', strtotime("+ 90 day")),
                    'created_at'            => date('Y-m-d'),
                    'np'                   =>$row['np'],
                    'created_by'            =>$username,
                );
                $dataTPS = array('idtps' => $row['idtps'],
                'idvendor' => $row['idvendor'],
                'no_manifest' => $row['nomanifest'],
                'no_spbe' => $row['nospbe'],
                'no_kendaraan' => $row['nokendaraan'],
                );

                // dd($dataDetail);
                $insertDetail = DB::table('tr_detailmutasi')->insert($dataDetail);
                $insertStatus = DB::table('tr_statusmutasi')->where('idmutasi', $row['idmutasi'])->update($dataStatus);
                $insertPacking = DB::table('tr_packing')->where('idmutasi', $row['idmutasi'])->update($dataPacking);
                 
                
                UpdtSaldoHelper::updateKurangSaldoTPS($row['idtps'], $row['jmlh_proses']);
                UpdtSaldoHelper::updateKurangSaldoNamaLimbah($row['idlimbah'],$row['jmlh_proses']);
            }
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
    }
      

    public function viewIndex()
    {
        
        $vendor=DB::table('md_vendorlimbah')->get();
        $np=DB::table('tbl_np')->get();
        // $namaLimbah=DB::table('md_namalimbah')->get();
        // $tipeLimbah=DB::table('md_tipelimbah')->get();
        // $penghasilLimbah=DB::table('md_penghasillimbah')->get();
        // $satuanLimbah=DB::table('md_satuan')->get();
        // $tpsLimbah=DB::table('md_tps')->get();
        return view('pemrosesan.list',[
        'vendor'=>$vendor,
        'np'=>$np

            

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //
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
