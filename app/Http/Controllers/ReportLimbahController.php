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
 
use Redirect;
use Validator;
use Response;
use DB;
use PDF;
 

class ReportLimbahController extends Controller
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
    public function viewIndexNeraca()
    {
        //
       
         
        return view('report.reportneraca',QueryHelper::getDropDown());
    }
    public function indexNeraca(Request $request)
    {
        if (request()->ajax()) {
            $queryData = DB::table('tr_detailmutasi')
                ->join('tr_headermutasi','tr_detailmutasi.idmutasi','=','tr_headermutasi.id')
                ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_tps', 'tr_headermutasi.idtps', '=', 'md_tps.id')
                ->join('md_penghasillimbah', 'tr_detailmutasi.idasallimbah', '=', 'md_penghasillimbah.id')
                ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id')
                ->select( 
                    'md_namalimbah.namalimbah',
                    'md_namalimbah.jenislimbah',
                    'md_tps.namatps',
                    'md_statusmutasi.keterangan',
                    'md_penghasillimbah.seksi',
                    'tr_detailmutasi.*', 
                ); 

            $queryData = $queryData->get();
            // dd( $queryData);
            return datatables()->of($queryData)

                ->addIndexColumn()
                // ->addColumn('action', 'action_butt_pemohon')
                // ->rawColumns(['action'])

                ->make(true);
        }
         
        return view('report.reportneraca',QueryHelper::getDropDown());
    }


    public function viewIndexKadaluarsa()
    {
        //
        
        return view('report.reportkadaluarsa',QueryHelper::getDropDown());
    }
    public function viewIndexKapasitas()
    {
        //
        
        return view('report.reportkapasitas',QueryHelper::getDropDown());
    }
    public function indexKapasitas(Request $request)
    {
        if (request()->ajax()) {
            $queryData = DB::table('md_tps'); 

            $queryData = $queryData->get();
            // dd( $queryData);
            return datatables()->of($queryData)

                ->addIndexColumn()
                // ->addColumn('action', 'action_butt_pemohon')
                // ->rawColumns(['action'])

                ->make(true);
        }
         
        // return view('report.reportkapasitas',QueryHelper::getDropDown());
    }
    public function viewIndexKontrak()
    {
        //
        
        return view('report.reportkontrakb3',QueryHelper::getDropDown());
    }
    public function viewIndexPenghasil()
    {
        //
        
        return view('report.reportpenghasil',QueryHelper::getDropDown());
    }
    public function indexPenghasil(Request $request)
    {
        if (request()->ajax()) {
            $queryData = DB::table('tr_headermutasi')
            ->join('md_namalimbah','tr_headermutasi.idlimbah','md_namalimbah.id')
            ->join('md_penghasillimbah','tr_headermutasi.idasallimbah','md_penghasillimbah.id')
            ->join('md_tps','tr_headermutasi.idtps','md_tps.id')
            ->select('md_namalimbah.namalimbah','md_namalimbah.jenislimbah','md_namalimbah.tipelimbah','md_penghasillimbah.seksi','md_tps.namatps',DB::raw('sum(tr_headermutasi.jumlah) as jumlah') )
            ->groupBy('md_penghasillimbah.seksi','md_namalimbah.namalimbah'); 
            $queryData = $queryData->get();
            // dd( $queryData);
            return datatables()->of($queryData)

                ->addIndexColumn()
                // ->addColumn('action', 'action_butt_pemohon')
                // ->rawColumns(['action'])

                ->make(true);
        }
         
        // return view('report.reportkapasitas',QueryHelper::getDropDown());
    }

    public function index(Request $request)
    {
        //
      
        // $status= DB::table('tr_mutasilimbah')->get();
        if (request()->ajax()) { 
            $queryData=DB::table('tr_mutasilimbah')
            ->join('md_namalimbah', 'tr_mutasilimbah.namalimbah', '=', 'md_namalimbah.namalimbah')
            ->select('tr_mutasilimbah.*','md_namalimbah.id as idnama','md_namalimbah.satuan','md_namalimbah.jenislimbah','md_namalimbah.fisik','md_namalimbah.saldo')
           ->orderBy('tr_mutasilimbah.created_at', 'desc');
 
            if(!empty($request->tglinput)){

                $splitDate2=explode(" - ",$request->tglinput);
                $queryData->whereBetween('tr_mutasilimbah.tgl',array(  AppHelper::convertDateYmd($splitDate2[0]),  AppHelper::convertDateYmd($splitDate2[1])));

            } 
			
            $queryData=$queryData->get(); 
            //  dd( $queryData);   
            return datatables()->of($queryData) 
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('jenislimbah'))) {
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['jenislimbah']),Str::lower($request->get('jenislimbah'))) ? true : false;
                            });
                        }
                        if(!empty($request->get('namalimbah'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains(Str::lower($row['namalimbah']), Str::lower($request->get('namalimbah'))) ? true : false;
                            });
                        }
                   
                        if(!empty($request->get('mutasi'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['mutasi'], $request->get('mutasi')) ? true : false;
                            });
                        } 
                        if(!empty($request->get('fisik'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['fisik'], $request->get('fisik')) ? true : false;
                            });
                        }
                        if(!empty($request->get('asallimbah'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['asallimbah'], $request->get('asallimbah')) ? true : false;
                            });
                        }
                        if(!empty($request->get('tpslimbah'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['tps'], $request->get('tpslimbah')) ? true : false;
                            });
                        } 
                        if(!empty($request->get('limbah3r'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['limbah3r'], $request->get('limbah3r')) ? true : false;
                            });
                        } 
                    })
                    ->addIndexColumn()
                    ->addColumn('action', 'action_butt_limbah')
                    ->rawColumns(['action'])
                    
                    ->make(true);
 
        } 
        return view('limbah.list', [
           
        ]);
    }
    public function viewEntri()
    {
        //
        $jenisLimbah=DB::table('md_jenislimbah')->get();
        $namaLimbah=DB::table('md_namalimbah')->get();
        $tipeLimbah=DB::table('md_tipelimbah')->get();
        $penghasilLimbah=DB::table('md_penghasillimbah')->get();
        $satuanLimbah=DB::table('md_satuan')->get();
        $tpsLimbah=DB::table('md_tps')->get();
        return view('limbah.create',[
            'jenisLimbah' => $jenisLimbah,
            'namaLimbah' => $namaLimbah,
            'tipeLimbah' => $tipeLimbah,
            'satuanLimbah' => $satuanLimbah,
            'tpsLimbah' => $tpsLimbah,
            'penghasilLimbah' => $penghasilLimbah,

        ]);
    }
    public function viewProses()
    {
        //
        $jenisLimbah=DB::table('md_jenislimbah')->get();
        $namaLimbah=DB::table('md_namalimbah')->get();
        $tipeLimbah=DB::table('md_tipelimbah')->get();
        $penghasilLimbah=DB::table('md_penghasillimbah')->get();
        $satuanLimbah=DB::table('md_satuan')->get();
        $tpsLimbah=DB::table('md_tps')->get();
        return view('limbah.create',[
            'jenisLimbah' => $jenisLimbah,
            'namaLimbah' => $namaLimbah,
            'tipeLimbah' => $tipeLimbah,
            'satuanLimbah' => $satuanLimbah,
            'tpsLimbah' => $tpsLimbah,
            'penghasilLimbah' => $penghasilLimbah,

        ]);
    }

    public function viewIndex()
    {
        
        $jenisLimbah=DB::table('md_jenislimbah')->get();
        $namaLimbah=DB::table('md_namalimbah')->get();
        $tipeLimbah=DB::table('md_tipelimbah')->get();
        $penghasilLimbah=DB::table('md_penghasillimbah')->get();
        $satuanLimbah=DB::table('md_satuan')->get();
        $tpsLimbah=DB::table('md_tps')->get();
        return view('limbah.list',[
            'jenisLimbah' => $jenisLimbah,
            'namaLimbah' => $namaLimbah,
            'tipeLimbah' => $tipeLimbah,
            'satuanLimbah' => $satuanLimbah,
            'tpsLimbah' => $tpsLimbah,
            'penghasilLimbah' => $penghasilLimbah,

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
 
        // dd($request->all());
        $error=null;
        $rules=array(
            'entridate' => 'required',
            'jenislimbah' => 'required',
            'namalimbah' => 'required',
            'fisiklimbah' => 'required',
            'limbahasal' => 'required',
            'jmlhlimbah' => 'required',
            'satuan' => 'required',
            'limbah3r' => 'nullable', 
        );
        $messages = array(
            'entridate.required'			=>  'Tanggal Input Harus Diisi'	,
            'jenislimbah.required'			=>  'Jenis Limbah Harus Diisi'	,
            'namalimbah.required'			=>  'Nama Limbah Harus Diisi'	, 
            'fisiklimbah.required'	        =>  'Tipe Limbah Harus Diisi'	,
            'limbahasal.required'           =>  'Limbah Asal Harus Diisi',
            'jmlhlimbah.required'           =>  'Jumlah Limbah Harus Diisi',
            'satuan.required'               =>  'Satuan Harus Diisi',
    
        );

        $error = Validator::make($request->all(), $rules, $messages); 
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'namalimbah'		=>  $request->namalimbah	,
            'tgl'			    =>  AppHelper::convertDate($request->entridate),
            'asallimbah'	    =>  $request->limbahasal	,
            'fisik'		        =>  $request->fisiklimbah	,
            'jenislimbah'       => $request->jenislimbah,
            'mutasi'            =>  'Input'	, 
            'jumlah'	        =>  (int)$request->jmlhlimbah,
            'satuan'	        =>  $request->satuan	,
            'tps'		        =>   $request->tps	,
            'limbah3r'	        =>   $request->limbah3r	,
           
        );
        $queryNamaLimbah=DB::table('md_namalimbah')->where('id','=',$request->idnamalimbah)->first();
        // dd($queryNamaLimbah);
        $jumlah=$queryNamaLimbah->saldo;
        $jumlah=$jumlah+(int)$request->jmlhlimbah;


        $updateJumlah = array ( 
            'saldo'	        =>  (int)$jumlah, 
        );
        

        try {
            $queryInsert=DB::table('tr_mutasilimbah')->insertTs($form_data,true);
            $queryUpdate=DB::table('md_namalimbah')->where('namalimbah','=',$request->namalimbah)->updateTs($updateJumlah,true);
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
         
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
        //
 $error=null;
        $rules=array(
            'entridate' => 'required',
            'jenislimbah' => 'required',
            'namalimbah' => 'required',
            'fisiklimbah' => 'required',
            'limbahasal' => 'required',
            'jmlhlimbah' => 'required',
            'satuan' => 'required',
            'limbah3r' => 'nullable', 
        );
        $messages = array(
            'entridate.required'			=>  'Tanggal Input Harus Diisi'	,
            'jenislimbah.required'			=>  'Jenis Limbah Harus Diisi'	,
            'namalimbah.required'			=>  'Nama Limbah Harus Diisi'	, 
            'fisiklimbah.required'	        =>  'Tipe Limbah Harus Diisi'	,
            'limbahasal.required'           =>  'Limbah Asal Harus Diisi',
            'jmlhlimbah.required'           =>  'Jumlah Limbah Harus Diisi',
            'satuan.required'               =>  'Satuan Harus Diisi',
    
        );

        $error = Validator::make($request->all(), $rules, $messages); 
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'namalimbah'		=>  $request->namalimbah	,
            'tgl'			    =>  AppHelper::convertDate($request->entridate),
            'asallimbah'	    =>  $request->limbahasal	,
            'fisik'		        =>  $request->fisiklimbah	,
            'jenislimbah'       =>  $request->jenislimbah,
            'mutasi'            =>  'Input'	, 
            'jumlah'	        =>  (int)$request->jmlhlimbah,
            'satuan'	        =>  $request->satuan	,
            'tps'		        =>  $request->tps	,
            'limbah3r'	        =>  $request->limbah3r	,
           
        ); 
        $queryNamaLimbah=DB::table('md_namalimbah')->where('namalimbah','=',$request->namalimbah)->first();
        // dd($queryNamaLimbah);
        $jumlah=$queryNamaLimbah->saldo;
        $jumlah=$jumlah-(int)$request->jumlahlama;
        $jumlah=$jumlah+(int)$request->jmlhlimbah;


        $updateJumlah = array ( 
            'saldo'	        =>  (int)$jumlah, 
        );
         dd($request->hidden_id);
        try { 
            $queryUpdateData=DB::table('tr_mutasilimbah')->where('id','=',$request->hidden_id)->updateTs($form_data, true);
            // dd( $queryUpdateData);
            $queryUpdate=DB::table('md_namalimbah')->where('namalimbah','=',$request->namalimbah)->updateTs($updateJumlah, true);
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

    public function getJenis($id)
    {
        $html = '';
        $seri = DB::table('seri_gol')->where('keterangan', $id)->get();
        $html .='<option value="-">-</option>';
        foreach ($seri as $seri_pikai) {
            $html .= '<option value="'.$seri_pikai->seri_gol.'">'.$seri_pikai->seri_gol.'</option>';
        }
   
    return response()->json(['html' => $html]);
        //
    }
    public function getFisik($id)
    {
        //
    }
    public function getNama(Request $request)
    {
        // dd($request->all());
        $html = '';
        $namalimbah = DB::table('md_namalimbah')
        ->where('jenislimbah', $request->jenis)
        ->where('fisik', $request->fisik)
        ->get();
        
        $html .='<option value="-">-</option>';
        foreach ($namalimbah as $nama) {
            $html .= '<option value="'.$nama->namalimbah.'">'.$nama->namalimbah.'</option>';
        }
        return response()->json(['html' => $html]);
        //
    }
    public function getSatuan(Request $request)
    {
        //
        $html = '';
        $namalimbah = DB::table('md_namalimbah')
         
        ->where('namalimbah', $request->namalimbah)
      
        ->get();
        
        $html .='<option value="-">-</option>';
        foreach ($namalimbah as $nama) {
            $html .= '<option value="'.$nama->satuan.'">'.$nama->satuan.'</option>';
        }
        return response()->json(['html' => $html]);
    }

}
