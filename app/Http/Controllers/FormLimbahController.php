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

    public function index(Request $request)
    {

        if (request()->ajax()) {
            $queryData = DB::table('tr_headermutasi')
                ->join('tr_detailmutasi', 'tr_headermutasi.id', '=', 'tr_detailmutasi.idmutasi')
                ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
                ->join('md_jenislimbah', 'tr_headermutasi.idjenislimbah', '=', 'md_jenislimbah.id')
                ->select(
                    'tr_headermutasi.*',
                    'md_penghasillimbah.seksi',
                    'md_jenislimbah.jenislimbah',
                )
                ->where('tr_detailmutasi.idstatus', '!=', '1')
                ->groupBy('tr_headermutasi.id_transaksi')
                ->orderBy('tr_headermutasi.no_surat', 'asc');

            // if(!empty($request->tglinput)){

            //     $splitDate2=explode(" - ",$request->tglinput);
            //     $queryData->whereBetween('tr_mutasilimbah.tgl',array(  AppHelper::convertDateYmd($splitDate2[0]),  AppHelper::convertDateYmd($splitDate2[1])));

            // } 
            if($request->idasallimbah == 'admin' || $request->idasallimbah == 'operator' || $request->idasallimbah == 'pengawas'){
 
            }else{
                $queryData = $queryData
                ->where('tr_detailmutasi.idasallimbah',$request->idasallimbah);
                
            }

            $queryData = $queryData->get();
            //  dd( $queryData);   
            return datatables()->of($queryData)
                // ->filter(function ($instance) use ($request) {
                //     if (!empty($request->get('jenislimbah'))) {
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains(Str::lower($row['jenislimbah']),Str::lower($request->get('jenislimbah'))) ? true : false;
                //         });
                //     }
                //     if(!empty($request->get('namalimbah'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains(Str::lower($row['namalimbah']), Str::lower($request->get('namalimbah'))) ? true : false;
                //         });
                //     }

                //     if(!empty($request->get('mutasi'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['mutasi'], $request->get('mutasi')) ? true : false;
                //         });
                //     } 
                //     if(!empty($request->get('fisik'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['fisik'], $request->get('fisik')) ? true : false;
                //         });
                //     }
                //     if(!empty($request->get('asallimbah'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['asallimbah'], $request->get('asallimbah')) ? true : false;
                //         });
                //     }
                //     if(!empty($request->get('tpslimbah'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['tps'], $request->get('tpslimbah')) ? true : false;
                //         });
                //     } 
                //     if(!empty($request->get('limbah3r'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['limbah3r'], $request->get('limbah3r')) ? true : false;
                //         });
                //     } 
                // })
                ->addIndexColumn()
                ->addColumn('action', 'action_butt_download')
                ->rawColumns(['action'])

                ->make(true);
        }
        return view('formulir.list', []);
    }


    public function viewIndex()
    {

        return view('formulir.list', [
            'username' => AuthHelper::getAuthUser()[0]
        ]);
    }


    public function viewIndexBAPemusnahan()
    {
        $np = DB::table('tbl_np')->get();

        return view('formulir_pemusnahan.list', [
            'username' => AuthHelper::getAuthUser()[0],
            'np' => $np
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

       

        if (request()->ajax()) {
            $queryData = DB::table('tr_detailmutasi')
                ->join('tr_headermutasi', 'tr_headermutasi.id', '=', 'tr_detailmutasi.idmutasi')
                ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
                ->join('md_jenislimbah', 'tr_headermutasi.idjenislimbah', '=', 'md_jenislimbah.id')
                ->join('md_statusmutasi', 'md_statusmutasi.id', '=', 'tr_detailmutasi.idstatus')
                ->join('tr_validasi_ba','tr_detailmutasi.id','tr_validasi_ba.id_detail')
                ->select(
                    'tr_detailmutasi.*',
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
 
            }else{
                $queryData = $queryData
                ->where('tr_detailmutasi.idasallimbah',$request->idasallimbah)
                ->whereIn('tr_detailmutasi.idlimbah',$this->getLimbahIsProsesLgsg());
            }

            $queryData = $queryData->get(); 
            return datatables()->of($queryData)
                // ->filter(function ($instance) use ($request) {
                //     if (!empty($request->get('jenislimbah'))) {
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains(Str::lower($row['jenislimbah']),Str::lower($request->get('jenislimbah'))) ? true : false;
                //         });
                //     }
                //     if(!empty($request->get('namalimbah'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains(Str::lower($row['namalimbah']), Str::lower($request->get('namalimbah'))) ? true : false;
                //         });
                //     }

                //     if(!empty($request->get('mutasi'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['mutasi'], $request->get('mutasi')) ? true : false;
                //         });
                //     } 
                //     if(!empty($request->get('fisik'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['fisik'], $request->get('fisik')) ? true : false;
                //         });
                //     }
                //     if(!empty($request->get('asallimbah'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['asallimbah'], $request->get('asallimbah')) ? true : false;
                //         });
                //     }
                //     if(!empty($request->get('tpslimbah'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['tps'], $request->get('tpslimbah')) ? true : false;
                //         });
                //     } 
                //     if(!empty($request->get('limbah3r'))){
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['limbah3r'], $request->get('limbah3r')) ? true : false;
                //         });
                //     } 
                // })
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


    public function cetakFormulir($id)
    {

        setlocale(LC_TIME, 'id');

        $dataFormulirLimbah = DB::table('tr_headermutasi')
            ->join('tr_detailmutasi', 'tr_headermutasi.id', '=', 'tr_detailmutasi.idmutasi')
            ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
            ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
            ->join('md_jenislimbah', 'tr_headermutasi.idjenislimbah', '=', 'md_jenislimbah.id')
            ->select(
                'tr_headermutasi.no_surat',
                'tr_headermutasi.created_at as tgldibuat',
                'tr_headermutasi.jumlah_in',
                'tr_headermutasi.keterangan',
                'tr_headermutasi.maksud',
                'md_jenislimbah.jenislimbah',
                'md_namalimbah.namalimbah',
                'md_penghasillimbah.seksi',
                'tr_headermutasi.maksud',
                'tr_headermutasi.np_pemohon',
                'tr_headermutasi.validated',
                'tr_headermutasi.validated_by',
            )
            ->where('tr_detailmutasi.idstatus', '=', '2')
            ->where('tr_headermutasi.id_transaksi', '=', $id)->get();
        //    dd($id);
        $penerima = DB::table('tr_detailmutasi')
            ->where('id_transaksi', '=', $id)
            ->where('idstatus', '2')->first();
        //    dd();

        $detailPenerima = DB::table('tbl_np')
            ->where('np', '=', $penerima->np_penerima)->first();
        $detailPengawas = DB::table('tbl_np')
            ->where('np', '=', $dataFormulirLimbah[0]->validated_by)->first();
        $detailPenyerah = DB::table('tbl_np')
            ->where('np', '=', $dataFormulirLimbah[0]->np_pemohon)->first();

        //    dd($penerima);

        // dd($dataFormulirLimbah);
        $no_surat = $dataFormulirLimbah[0]->no_surat;
        $tanggal = Carbon::parse($dataFormulirLimbah[0]->tgldibuat)->formatLocalized('%d %B %Y');
        $jenislimbah = $dataFormulirLimbah[0]->jenislimbah;
        $penghasillimbah = $dataFormulirLimbah[0]->seksi;
        $dikirimke = 'Seksi Operasional Limbah';
        $maksud = $dataFormulirLimbah[0]->maksud;
        // $ttdPenerima=$penerima->np;
        // $ttdPengawas=$dataFormulirLimbah[0]->validated_by;
        // $ttdMenyerahkan=$dataFormulirLimbah[0]->np;
        $listLimbah = $dataFormulirLimbah;
        // dd($listLimbah);

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

        


        $detailPengawasLapangan = $this->getNama($dataTransaksi->np_pengawas_lapangan);
        $detailPengamanan = $this->getNama($dataTransaksi->np_pengawas);
        $detailPemohon = $this->getNama($dataTransaksi->np_pemohon);
        
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
