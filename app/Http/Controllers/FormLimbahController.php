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
            $queryData=DB::table('tr_headermutasi')
            ->join('tr_detailmutasi', 'tr_headermutasi.id', '=', 'tr_detailmutasi.idmutasi')
            ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
            ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
            ->join('md_jenislimbah', 'tr_headermutasi.idjenislimbah', '=', 'md_jenislimbah.id')
            ->select('tr_headermutasi.*',
            'md_penghasillimbah.seksi',
            'md_jenislimbah.jenislimbah',
           )
        //    ->where('tr_detailmutasi.np','')
           ->where('tr_detailmutasi.idstatus','!=','1')
        //    ->whereNotNull('tr_headermutasi.validated')
           ->groupBy('tr_headermutasi.id_transaksi')
           ->orderBy('tr_headermutasi.no_surat', 'asc');
 
            // if(!empty($request->tglinput)){

            //     $splitDate2=explode(" - ",$request->tglinput);
            //     $queryData->whereBetween('tr_mutasilimbah.tgl',array(  AppHelper::convertDateYmd($splitDate2[0]),  AppHelper::convertDateYmd($splitDate2[1])));

            // } 
			
            $queryData=$queryData->get(); 
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
        return view('formulir.list', [
           
        ]);
    }
    

    public function viewIndex()
    { 
         
        return view('formulir.list',[
            'username'=>AuthHelper::getAuthUser()[0]
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
 

    public function cetakFormulir($id)
    {
      
        setlocale(LC_TIME, 'id');
       
        $dataFormulirLimbah=DB::table('tr_headermutasi')
            ->join('tr_detailmutasi', 'tr_headermutasi.id', '=', 'tr_detailmutasi.idmutasi')
            ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
            ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
            ->join('md_jenislimbah', 'tr_headermutasi.idjenislimbah', '=', 'md_jenislimbah.id')
            ->select('tr_headermutasi.no_surat',
            'tr_headermutasi.created_at as tgldibuat',
            'tr_headermutasi.jumlah',
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
           ->where('tr_detailmutasi.idstatus','=','2')
           ->where('tr_headermutasi.id_transaksi','=',$id)->get(); 
        //    dd($id);
           $penerima=DB::table('tr_detailmutasi')
           ->where('id_transaksi','=',$id)
           ->where('idstatus','2')->first(); 
        //    dd();

           $detailPenerima=DB::table('tbl_np')
           ->where('np','=',$penerima->np_penerima)->first();
           $detailPengawas=DB::table('tbl_np')
           ->where('np','=',$dataFormulirLimbah[0]->validated_by)->first();
           $detailPenyerah=DB::table('tbl_np')
           ->where('np','=',$dataFormulirLimbah[0]->np_pemohon)->first();

        //    dd($penerima);

        // dd($dataFormulirLimbah);
        $no_surat=$dataFormulirLimbah[0]->no_surat;
        $tanggal=Carbon::parse($dataFormulirLimbah[0]->tgldibuat)->formatLocalized('%d %B %Y');
        $jenislimbah=$dataFormulirLimbah[0]->jenislimbah;
        $penghasillimbah=$dataFormulirLimbah[0]->seksi;
        $dikirimke='Seksi Operasional Limbah';
        $maksud=$dataFormulirLimbah[0]->maksud; 
        // $ttdPenerima=$penerima->np;
        // $ttdPengawas=$dataFormulirLimbah[0]->validated_by;
        // $ttdMenyerahkan=$dataFormulirLimbah[0]->np;
        $listLimbah=$dataFormulirLimbah;
        // dd($listLimbah);

        $pdf = PDF::loadview('formulir.form',[
            'no_surat'=>$no_surat,
            'tanggal'=> $tanggal,
            'jenislimbah'=> $jenislimbah,
            'penghasil'=> $penghasillimbah,
            'dikirimke'=> $dikirimke,
            'maksud'=> $maksud,
            'listlimbah'=>$listLimbah,
            'ttdPenerima'=> $detailPenerima,
            'ttdPengawas'=> $detailPengawas,
            'ttdMenyerahkan'=> $detailPenyerah, 
            
        ])->setPaper('a4','portrait'); 
        return $pdf->stream($no_surat.".pdf"); 
    }

}
