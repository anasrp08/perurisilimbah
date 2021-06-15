<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Helpers\AppHelper;
use App\Helpers\QueryHelper;
use App\Helpers\AuthHelper;

use Redirect;
use Validator;
use Response;
use DB;
use PDF;
use Exception;

class FormLimbahController extends Controller
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
    public function searchIdAsalLimbah($userSeksi)
    { 
        $data = DB::table('md_penghasillimbah')
        ->where('seksi','like','%'.$userSeksi.'%')->first();

        return $data->id;
    }
    public function index(Request $request)
    { 
        if (request()->ajax()) {
            $queryData = DB::table('tr_detailmutasi')
                ->join('tr_headermutasi', 'tr_headermutasi.id', '=', 'tr_detailmutasi.idmutasi')
                ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
                ->join('md_jenislimbah', 'tr_headermutasi.idjenislimbah', '=', 'md_jenislimbah.id')
                ->select(
                    'tr_headermutasi.*',
                    'tr_detailmutasi.idmutasi',
					'tr_detailmutasi.tgl as tgl_proses',
                    'md_penghasillimbah.seksi',
                    'md_jenislimbah.jenislimbah',
					'md_namalimbah.namalimbah'
                )
                ->where('tr_detailmutasi.idstatus','1')
                // ->groupBy('tr_headermutasi.id_transaksi')
                ->orderBy('tr_headermutasi.tgl', 'desc');
				// ->orderBy('tr_headermutasi.idasallimbah', 'desc');
 
            if($request->idasallimbah == 'admin' || $request->idasallimbah == 'operator' || $request->idasallimbah == 'pengawas'){
 
            }else{
                $queryData = $queryData 
                ->where('tr_detailmutasi.idasallimbah',$request->idasallimbah);   
            }
            if (!empty($request->f_date)) {

                $splitDate2 = explode(" - ", $request->f_date);
                $queryData->whereBetween('tr_headermutasi.tgl', array(AppHelper::convertDateYmd($splitDate2[0]),  AppHelper::convertDateYmd($splitDate2[1])));
            } 
            if (!empty($request->namalimbah)) {
                
                $queryData->where('tr_headermutasi.idlimbah',$request->namalimbah );
            } 
            if (!empty($request->limbahasal)) {
 
                $queryData->where('tr_headermutasi.idasallimbah',$request->limbahasal);
            }  

            $queryData = $queryData->get(); 
            return datatables()->of($queryData)
                
                ->addIndexColumn()
                ->addColumn('action', 'action_butt_download')
                ->rawColumns(['action'])

                ->make(true);
        }
        return view('formulir.list', []);
    }


    public function viewIndex()
    {
        
        $jenisLimbah=DB::table('md_jenislimbah')->get();
        $namaLimbah=DB::table('md_namalimbah')->get(); 
        $penghasilLimbah=DB::table('md_penghasillimbah')->get();
       
        return view('formulir.list', [
            'username' => AuthHelper::getAuthUser()[0],
            'jenisLimbah' => $jenisLimbah,
            'namaLimbah' => $namaLimbah,
            'penghasilLimbah' => $penghasilLimbah,
            
        ]);
    }


    public function viewIndexBAPemusnahan()
    {
        $np = DB::table('tbl_np')->get();
        $jenisLimbah=DB::table('md_jenislimbah')->get();
        $namaLimbah=DB::table('md_namalimbah')->get(); 
        $penghasilLimbah=DB::table('md_penghasillimbah')->get();

        return view('formulir_pemusnahan.list', [
            'username' => AuthHelper::getAuthUser()[0],
            'np' => $np,
            'jenisLimbah' => $jenisLimbah,
            'namaLimbah' => $namaLimbah,
            'penghasilLimbah' => $penghasilLimbah,
        ]);
    }
    public function getLimbahIsProsesLgsg()
    {
        $limbahSecurity= DB::table('md_namalimbah')
        ->whereIn('is_lgsg_proses',['1','2'])
        ->pluck('id');

        return $limbahSecurity;
    }
    public function IndexBAPemusnahan(Request $request)
    {

        // $getIdLimbah=$this->searchIdAsalLimbah($request->idasallimbah); 
        if (request()->ajax()) {
            $queryData = DB::table('tr_validasi_ba')
                ->join('tr_headermutasi', 'tr_headermutasi.id', '=', 'tr_validasi_ba.id_mutasi')
                ->join('tr_detailmutasi','tr_detailmutasi.id','tr_validasi_ba.id_detail')
                ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
                ->join('md_jenislimbah', 'tr_headermutasi.idjenislimbah', '=', 'md_jenislimbah.id')
                ->join('md_statusmutasi', 'md_statusmutasi.id', '=', 'tr_detailmutasi.idstatus')
               
                ->select(
                    'tr_detailmutasi.*',
                    'tr_detailmutasi.idasallimbah',
                    'tr_validasi_ba.np_pemohon as pemohon_validasi',
                    'tr_validasi_ba.validated_pemohon',
                    'tr_validasi_ba.np_pengawas as pengawas_validasi',
                    'tr_validasi_ba.validated_pengawas',
                    'tr_detailmutasi.id as id_detail',
                    'tr_headermutasi.*',
                    'md_penghasillimbah.seksi',
                    'md_jenislimbah.jenislimbah',
                    'md_namalimbah.namalimbah',
                    'md_statusmutasi.keterangan as keterangan_status',
                    'tr_detailmutasi.tgl as tgl_pemrosesan',
                )
                ->whereIn('tr_detailmutasi.idstatus', ['5', '6', '7', '8', '9'])
                
                ->orderBy('tgl_pemrosesan', 'desc');
 
            if($request->idasallimbah == 'admin' || $request->idasallimbah == 'operator' || $request->idasallimbah == 'pengawas'){
 
            }else if($request->idasallimbah == '225'){
				$queryData = $queryData
                ->where('tr_detailmutasi.idasallimbah',$request->idasallimbah);
			
			
			}else { 
                $queryData = $queryData
                ->where('tr_detailmutasi.idasallimbah',$request->idasallimbah)
                ->whereIn('tr_detailmutasi.idlimbah',$this->getLimbahIsProsesLgsg());
            }
			
			
			
            if (!empty($request->f_date)) {

                $splitDate2 = explode(" - ", $request->f_date);
                $queryData->whereBetween('tr_detailmutasi.tgl', array(AppHelper::convertDateYmd($splitDate2[0]),  AppHelper::convertDateYmd($splitDate2[1])));
            } 
            if (!empty($request->namalimbah)) {
                
                $queryData->where('tr_detailmutasi.idlimbah',$request->namalimbah );
            } 
            if (!empty($request->limbahasal)) {
 
                $queryData->where('tr_detailmutasi.idasallimbah',$request->limbahasal);
            }  

            $queryData = $queryData->get(); 
            return datatables()->of($queryData)
                
                ->addIndexColumn()
                ->addColumn('action', 'action_butt_download')
                ->rawColumns(['action'])

                ->make(true);
        }
        return view('formulir.list', []);
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
        setlocale(LC_TIME, 'id');
        date_default_timezone_set('asia/jakarta');
        // dd($request->all());
        $user = Auth::user();
         
        $roleuser=$user->roles->first()->name;
        $username = AuthHelper::getAuthUser()[0]->email;
        $getRequest = json_decode($request->getContent(), true);
        $dataRequest = $getRequest['Order'];
        $countDataReq = count($dataRequest);
 
        $dataStatus = null;
        $time = date('H:i:s');
        $jmlh_pack = null;
        try {
            foreach ($dataRequest as $row) {
                if($roleuser=='unit kerja'){
                    $dataStatus = array(
                        'validated_pemohon'        => date('Y-m-d H:i:s'),
                        'np_pemohon'               => $row['np'],
                    );
                }else  if($roleuser=='pengawas'){
                    $dataStatus = array(
                        'validated_pengawas'        => date('Y-m-d H:i:s'),
                        'np_pengawas'               => $row['np'],
                    );
                }else if($roleuser=='operator'){
                    $dataStatus = array(
                        'validated_np_pengawas_lapangan'        => date('Y-m-d H:i:s'),
                        'np_pengawas_lapangan'               => $row['np'],
                    );
                }else {
                    $dataStatus = array(
                        'validated_np_pengawas_lapangan'        => date('Y-m-d H:i:s'),
                        'np_pengawas_lapangan'               => $row['np'],
                    );
                } 
                
                 
                $updateValidasiBA = DB::table('tr_validasi_ba')->where('id_detail', $row['id_detail'])->update($dataStatus, true);
            }

            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
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


    public function cetakFormulir($id,$asal)
    {

        setlocale(LC_TIME, 'id');
        $currSeksi = AuthHelper::getAuthUser()[0]->seksi;
        $dataFormulirLimbah = DB::table('tr_headermutasi')
            ->join('tr_detailmutasi', 'tr_headermutasi.id', '=', 'tr_detailmutasi.idmutasi')
            ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
            ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
            ->join('md_jenislimbah', 'tr_headermutasi.idjenislimbah', '=', 'md_jenislimbah.id')
            ->select(
                'tr_headermutasi.*',
                'tr_headermutasi.tgl as tgldibuat',
                DB::raw('SUM(tr_headermutasi.jumlah_in+tr_headermutasi.jumlah_out) as jumlah'),
                'md_jenislimbah.jenislimbah',
                'md_namalimbah.namalimbah',
                'md_penghasillimbah.seksi',
                
            )
            ->where('tr_detailmutasi.idstatus', '=', '1') 
            ->where('tr_headermutasi.id', '=', $id);

            if($asal == $currSeksi){
                $dataFormulirLimbah = $dataFormulirLimbah 
                ->where('tr_detailmutasi.idasallimbah',$asal);
            }else{ 
            }
            $dataFormulirLimbah=$dataFormulirLimbah->get(); 
            // dd($dataFormulirLimbah);
         
        $detailPenerima = $this->isEmptyValue($this->getNama($dataFormulirLimbah[0]->np_penerima));   
        $detailPengawas = $this->isEmptyValue($this->getNama($dataFormulirLimbah[0]->validated_by));  
        $detailPenyerah = $this->isEmptyValue($this->getNama($dataFormulirLimbah[0]->np_pemohon));  

        // $detailPenerima = $this->getNama($penerima->np_penerima); 
        // $detailPengawas = $this->getNama($dataFormulirLimbah[0]->validated_by);  
        // $detailPenyerah = $this->getNama($dataFormulirLimbah[0]->np_pemohon);  

        //    dd($penerima);

        // dd($dataFormulirLimbah);
        $no_surat = $dataFormulirLimbah[0]->no_surat;
        $tanggal = Carbon::parse($dataFormulirLimbah[0]->tgldibuat)->formatLocalized('%d %B %Y');
        $jenislimbah = $dataFormulirLimbah[0]->jenislimbah;
        $penghasillimbah = $dataFormulirLimbah[0]->seksi;
        $dikirimke = 'Seksi Operasional Limbah';
        $maksud = $dataFormulirLimbah[0]->maksud; 
        $listLimbah = $dataFormulirLimbah; 

        $pdf = PDF::loadview('formulir.form', [
            'no_surat' => $no_surat,
            'tanggal' => $tanggal,
            'jenislimbah' => $jenislimbah,
            'penghasil' => $penghasillimbah,
            'dikirimke' => $dikirimke,
            'maksud' => $maksud,
            'listlimbah' => $listLimbah,
            'ttdPenerima' => $detailPenerima,
            'ttdPengawas' => $detailPengawas,
            'ttdMenyerahkan' => $detailPenyerah,
           

        ])->setPaper('a4', 'portrait');
        return $pdf->stream($no_surat . ".pdf");
    }

    public function getNama($np)
    {
        $dataPegawai = DB::table('tbl_np')
            ->where('np', $np)->first(); 
        return $dataPegawai;
    }
    public function isEmptyValue($param){

        // $finalValue=null;
        if($param == null){
            return '';
        }else{
            return $param;
        }
        
    }
    public function cetakBAPemusnahan($id)
    {
 
        setlocale(LC_TIME, 'id');
        date_default_timezone_set('asia/jakarta');
        
        $dataTransaksi = DB::table('tr_detailmutasi')
            ->join('tr_headermutasi', 'tr_headermutasi.id', '=', 'tr_detailmutasi.idmutasi')
            ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
            ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
          
            ->join('md_satuan', 'tr_detailmutasi.idsatuan', '=', 'md_satuan.id')
            ->join('tr_validasi_ba', 'tr_detailmutasi.id', 'tr_validasi_ba.id_detail')
            ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', 'md_statusmutasi.id')
            
            ->select(
                'tr_headermutasi.id as idheader',
                'tr_headermutasi.no_surat',
                'tr_headermutasi.tgl as tgldibuat',
                'tr_headermutasi.no_surat',
                'tr_detailmutasi.jumlah',
                'tr_detailmutasi.idstatus',
                'tr_detailmutasi.no_ba_pemusnahan',
                'tr_detailmutasi.tgl',
                'md_namalimbah.namalimbah',
                'md_penghasillimbah.seksi',
                'tr_headermutasi.np_pemohon as header_pemohon',
               
                'tr_headermutasi.validated as header_validated',
                'tr_headermutasi.validated_by as header_validated_by',
                'tr_validasi_ba.*',
                'md_satuan.satuan',
                'md_statusmutasi.keterangan'
            )
            ->where('tr_detailmutasi.id', '=', $id)->first();

        

        $dataPengawasLapangan=DB::table('tr_detailmutasi')
        ->whereIn('tr_detailmutasi.idstatus',['5','6','7','8','9'])
        ->where('tr_detailmutasi.idmutasi',$dataTransaksi->idheader)->first();
        $detailPengawasLapangan = $this->isEmptyValue($this->getNama($dataPengawasLapangan->np_pemroses));        
        // dd($detailPengawasLapangan);
        $detailPengamanan = $this->isEmptyValue($this->getNama($dataTransaksi->np_pengawas));
        $detailPemohon = $this->isEmptyValue($this->getNama($dataTransaksi->np_pemohon));
        
        $no_ba = $dataTransaksi->no_ba_pemusnahan;
        $tanggal = Carbon::parse($dataTransaksi->tgl)->formatLocalized('%d %B %Y');
       
        $penghasillimbah = $dataTransaksi->seksi;
        $hari = Carbon::parse($dataTransaksi->tgl)->formatLocalized('%A'); 

        $pdf = PDF::loadview('formulir_pemusnahan.form', [
            'no_ba' => $no_ba,
            'tanggal' => $tanggal,
            // 'jenislimbah'=> $jenislimbah,
            'penghasil' => $penghasillimbah,
            'hari' => $hari, 
            'listlimbah' => $dataTransaksi,
            'detailPengawasLapangan' => $detailPengawasLapangan,
            'detailPengamanan' => $detailPengamanan,
            'detailPemohon' => $detailPemohon,

        ])->setPaper('a4', 'portrait');
        return $pdf->stream($no_ba . ".pdf");
    }
}
