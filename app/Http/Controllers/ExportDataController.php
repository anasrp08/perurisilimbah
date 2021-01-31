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
use App\Exports\NeracaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

use Redirect;
use Validator;
use Response;
use DB;
use PDF;


class ExportDataController extends Controller
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
        

        return view('report.reportneraca', QueryHelper::getDropDown());
    }
    public function downloadNeraca($month,$year)
    {
 
    //     $queryData = DB::table('tr_detailmutasi')
    //     ->join('tr_headermutasi', 'tr_detailmutasi.idmutasi', '=', 'tr_headermutasi.id')
    //     ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', '=', 'md_namalimbah.id') 
    //     ->join('md_penghasillimbah', 'tr_detailmutasi.idasallimbah', '=', 'md_penghasillimbah.id')
    //     ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id')
    //     ->join('md_satuan', 'md_satuan.id', '=', 'tr_detailmutasi.idsatuan')
    //     ->select(
    //         // 'tr_headermutasi.id',
    //         'tr_headermutasi.tgl',
    //         'md_namalimbah.namalimbah', 
    //         'tr_detailmutasi.jumlah',
    //         'md_satuan.satuan',
    //         'md_namalimbah.jenislimbah', 
    //         'md_statusmutasi.keterangan as keterangan_mutasi',
            
    //         'md_penghasillimbah.seksi',
    //         // 'tr_detailmutasi.*'
    //         // DB::raw('SUM(tr_detailmutasi.jumlah) as jumlah2'),
           
    //         'tr_detailmutasi.created_at',
    //         'tr_detailmutasi.np'
    //     )
    //     ->whereMonth('tr_detailmutasi.created_at', '=',   $this->month)
    //     ->whereYear('tr_detailmutasi.created_at', '=',   $this->year)    
    //     ->whereIn('tr_detailmutasi.idstatus', ['5','6','7','8','9'])
    //     ->orderBy('tr_detailmutasi.created_at','desc'); 
 

    //     $queryData = $queryData->get();
    //     foreach($sales as $e)
    // {
    //     $sales_array[] = array(
    //        ' Date'=>$e->date,
    //             ' Time'=>$e->time,
    //             ' No of litre'=>$e->no_of_litre,
    //             ' note'=>$e->note,
    //     );
    //     $total += $e->no_of_litre;
    // }
    // $sales_array[] = array(
    //    ' Date'=>$e->'',
    //             ' Time'=>$e->'',
    //             ' No of litre'=>$e->'',
    //             ' note'=>$e->'',
    //    'Total'=> $total
    // );
    //     return Excel::create('salesdet',function($excel) use ($sales_array) {
    //         $excel->sheet('mySheet', function($sheet) use ($sales_array)
    //         {
    //             $sheet->fromArray($sales_array);
    //         });
    //     })->download($type);
    // https://laracasts.com/discuss/channels/laravel/how-to-pass-the-sumfields-to-excel-conversion-using-maatwebsite-in-laravel
        return Excel::download(new NeracaExport($month,$year), 'neraca.xlsx');
    }
    public function indexNeraca(Request $request)
    { 
        // dd($request->period);
        if (request()->ajax()) {
            $splitPeriod = explode("/",$request->period);
            $currMonth= $splitPeriod[0];
            $currYear= $splitPeriod[1];
            
            $date=DateTime::createFromFormat("m/Y", $request->period);
            $date= $date->format('Y-m');
            $prevPeriod=date('m-Y', strtotime(date($date)." -1 month"));
            $splitPrevPeriod = explode("-",$prevPeriod);
            $prevMonth= $splitPrevPeriod[0];
            $prevYear= $splitPrevPeriod[1];

           
            $filterStatus=null;
            if($request->mutasi=='masuk'){
                $filterStatus=['2'];
            }else{
                $filterStatus=['5', '6', '7', '8', '9'];
            }
            $queryData = DB::table('tr_detailmutasi')
                ->join('tr_headermutasi', 'tr_detailmutasi.idmutasi', '=', 'tr_headermutasi.id')
                ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', '=', 'md_namalimbah.id') 
                ->join('md_penghasillimbah', 'tr_detailmutasi.idasallimbah', '=', 'md_penghasillimbah.id')
                ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id')
                ->join('md_satuan', 'md_satuan.id', '=', 'tr_detailmutasi.idsatuan')
                ->select(
                    'md_namalimbah.namalimbah',
                    'md_namalimbah.keterangan as isWiping',
                    'md_namalimbah.jenislimbah', 
                    'md_statusmutasi.keterangan as keterangan_mutasi',
                    'md_statusmutasi.mutasi',
                    'md_penghasillimbah.seksi',
                    'tr_detailmutasi.*',
                    'md_satuan.satuan',
                    DB::raw('SUM(tr_detailmutasi.jumlah) as jumlah2'),
                    
                )
                ->whereMonth('tr_detailmutasi.created_at', '=',  $currMonth)
                ->whereYear('tr_detailmutasi.created_at', '=',  $currYear)    
                ->whereIn('tr_detailmutasi.idstatus',  $filterStatus)
                //filter yang bukan wiping solution
                ->whereNotIn('tr_detailmutasi.idlimbah', ['1', '2', '3']) 
                ->groupBy('tr_detailmutasi.idstatus', 'tr_detailmutasi.idlimbah');

            $queryData = $queryData->get();
            //penggabungan limbah cair B3
            $dataLimbahCair = DB::table('tr_detailmutasi')
            ->join('tr_headermutasi', 'tr_detailmutasi.idmutasi', '=', 'tr_headermutasi.id')
            ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', '=', 'md_namalimbah.id')
            // ->join('md_tps', 'tr_headermutasi.idtps', '=', 'md_tps.id')
            ->join('md_penghasillimbah', 'tr_detailmutasi.idasallimbah', '=', 'md_penghasillimbah.id')
            ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id')
            ->join('md_satuan', 'md_satuan.id', '=', 'tr_detailmutasi.idsatuan')
            ->select(
                'md_namalimbah.namalimbah',
                'md_namalimbah.keterangan as isWiping',
                'md_namalimbah.jenislimbah', 
                'md_statusmutasi.keterangan as keterangan_mutasi',
                'md_statusmutasi.mutasi',
                'md_penghasillimbah.seksi',
                'tr_detailmutasi.*',
                'md_satuan.satuan',
                DB::raw('SUM(tr_detailmutasi.jumlah) as jumlah2'),                
            )
            ->whereMonth('tr_detailmutasi.created_at', '=',  $currMonth)
            ->whereYear('tr_detailmutasi.created_at', '=',  $currYear)    
            ->whereIn('tr_detailmutasi.idstatus',  $filterStatus)
            ->whereIn('tr_detailmutasi.idlimbah', ['1', '2', '3'])
            ->groupBy('tr_detailmutasi.idstatus', 'md_namalimbah.keterangan');
 

        $dataLimbahCair = $dataLimbahCair->get();

        $sorted=null;
        if($dataLimbahCair->count()==0){
            $sorted=$dataLimbahCair;
        }else{
            $dataLimbahCair[0]->namalimbah='Limbah Cair Wiping Solution';
            //merged 2 colection with id limbah 1,2,3 to Limbah cair Wiping solution
            $queryData = $queryData->merge($dataLimbahCair);

            $period=$request->period;
            
                $queryData = collect($queryData);
                //sort by idlimbah
                $sorted=$queryData->sortBy('idlimbah');
               
                $transactionsWithTotalCharge = $sorted->map(function ($transaction) use($prevMonth,$prevYear) {
                    // $transactionsWithTotalCharge = $queryData->each(function ($transaction, $key) {
                    // $prevPeriod=(int)$period - 1;
                    $limbahMasuk=null;
                    $limbahKeluar=null;
                    if($transaction->isWiping == 'WS'){
                    //    dd($prevMonth);
                        $limbahMasuk = DB::table('tr_detailmutasi')
                        // ->where('idlimbah', $transaction->idlimbah)
                        ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id')
                        
                        ->whereMonth('tr_detailmutasi.created_at', '=',  $prevMonth)
                        ->whereYear('tr_detailmutasi.created_at', '=',  $prevYear)   
                        ->where('md_statusmutasi.mutasi', 'Masuk')
                        ->whereIn('tr_detailmutasi.idlimbah', ['1', '2', '3'])
                        ->sum('tr_detailmutasi.jumlah');
                        $limbahKeluar = DB::table('tr_detailmutasi')
                        // ->where('idlimbah', $transaction->idlimbah)
                        ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id') 
                        ->whereMonth('tr_detailmutasi.created_at', '=',  $prevMonth)
                        ->whereYear('tr_detailmutasi.created_at', '=',  $prevYear)   
                        ->whereIn('tr_detailmutasi.idlimbah', ['1', '2', '3'])
                        ->where('md_statusmutasi.mutasi', 'Proses')
                        ->sum('jumlah'); 
                    }else{
                        $limbahMasuk = DB::table('tr_detailmutasi')->where('idlimbah', $transaction->idlimbah)
                        ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id')
                        
                        ->whereMonth('tr_detailmutasi.created_at', '=',  $prevMonth)
                        ->whereYear('tr_detailmutasi.created_at', '=',  $prevYear)   
                        ->where('md_statusmutasi.mutasi', 'Masuk')
                        ->sum('tr_detailmutasi.jumlah');
    
                        $limbahKeluar = DB::table('tr_detailmutasi')->where('idlimbah', $transaction->idlimbah)
                        ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id')
                      
                        ->whereMonth('tr_detailmutasi.created_at', '=',  $prevMonth)
                        ->whereYear('tr_detailmutasi.created_at', '=',  $prevYear)   
                        ->where('md_statusmutasi.mutasi', 'Proses')->sum('jumlah');
                        //dari master data limbah
                        
                    }
                    $sisaSaldoLimbah = DB::table('md_namalimbah')->where('id', $transaction->idlimbah)->first();
                        
                    $sisaSaldo = (int)$limbahMasuk - (int)$limbahKeluar; 
                    
                   //check if negative value
                    if($sisaSaldo < 0){
                        $transaction->sisaSaldo=0;
                    }else{
                        $transaction->sisaSaldo = $sisaSaldo;
                    }

                    $transaction->saldoLimbah = $sisaSaldoLimbah->saldo;  
                     
                    return $transaction;
                });
        }
        


            // foreach($transactionsWithTotalCharge as $transaction) {
            //     // dd($transaction); 
            //     dd($transaction->sisaSaldo); 
            // }
            // dd($queryData);

 
            return datatables()->of($sorted)

                ->addIndexColumn()
                // ->addColumn('action', 'action_butt_pemohon')
                // ->rawColumns(['action'])

                ->make(true);
        }

        return view('report.reportneraca', QueryHelper::getDropDown());
    }

    public function viewKuota()
    {
        //

        return view('report.reportkadaluarsa', QueryHelper::getDropDown());
    }
    public function viewIndexKadaluarsa()
    {
        return view('report.reportkadaluarsa', QueryHelper::getDropDown());
    }
    public function viewIndexKapasitas()
    {
        //

        return view('report.reportkapasitas', QueryHelper::getDropDown());
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
        // dd('tes');

        return view('report.reportkontrakb3', QueryHelper::getDropDown());
    }
    public function indexKontrak(Request $request)
    {
        if (request()->ajax()) {
            $queryData = DB::table('md_kuota')
                ->join('md_tipelimbah', 'md_tipelimbah.id', 'md_kuota.tipe_limbah')
                ->select('md_tipelimbah.tipelimbah', 'md_kuota.id', 'md_kuota.tipe_limbah', 'md_kuota.jumlah', 'md_kuota.konsumsi', 'md_kuota.sisa', 'md_kuota.tahun', 'md_kuota.np')->get();
            return datatables()->of($queryData)

                ->addIndexColumn()
                ->addColumn('action', 'action_butt_anggaran')
                ->rawColumns(['action'])

                ->make(true);
        }
    }
    public function viewIndexPenghasil()
    {
        //

        return view('report.reportpenghasil', QueryHelper::getDropDown());
    }
    public function indexPenghasil(Request $request)
    {
        if (request()->ajax()) {
            $queryData = DB::table('tr_headermutasi')
                ->join('md_namalimbah', 'tr_headermutasi.idlimbah', 'md_namalimbah.id')
                ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', 'md_penghasillimbah.id')
                ->join('md_tps', 'tr_headermutasi.idtps', 'md_tps.id')
                ->select('md_namalimbah.namalimbah', 'md_namalimbah.jenislimbah', 'md_namalimbah.tipelimbah', 'md_penghasillimbah.seksi', 'md_tps.namatps', DB::raw('sum(tr_headermutasi.jumlah) as jumlah'))
                ->groupBy('md_penghasillimbah.seksi', 'md_namalimbah.namalimbah');
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
            $queryData = DB::table('tr_mutasilimbah')
                ->join('md_namalimbah', 'tr_mutasilimbah.namalimbah', '=', 'md_namalimbah.namalimbah')
                ->select('tr_mutasilimbah.*', 'md_namalimbah.id as idnama', 'md_namalimbah.satuan', 'md_namalimbah.jenislimbah', 'md_namalimbah.fisik', 'md_namalimbah.saldo')
                ->orderBy('tr_mutasilimbah.created_at', 'desc');

            if (!empty($request->tglinput)) {

                $splitDate2 = explode(" - ", $request->tglinput);
                $queryData->whereBetween('tr_mutasilimbah.tgl', array(AppHelper::convertDateYmd($splitDate2[0]),  AppHelper::convertDateYmd($splitDate2[1])));
            }
            $queryData = $queryData->get();
            return datatables()->of($queryData)
                ->filter(function ($instance) use ($request) {
                    if (!empty($request->get('jenislimbah'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['jenislimbah']), Str::lower($request->get('jenislimbah'))) ? true : false;
                        });
                    }
                    if (!empty($request->get('namalimbah'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains(Str::lower($row['namalimbah']), Str::lower($request->get('namalimbah'))) ? true : false;
                        });
                    }

                    if (!empty($request->get('mutasi'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['mutasi'], $request->get('mutasi')) ? true : false;
                        });
                    }
                    if (!empty($request->get('fisik'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['fisik'], $request->get('fisik')) ? true : false;
                        });
                    }
                    if (!empty($request->get('asallimbah'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['asallimbah'], $request->get('asallimbah')) ? true : false;
                        });
                    }
                    if (!empty($request->get('tpslimbah'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            return Str::contains($row['tps'], $request->get('tpslimbah')) ? true : false;
                        });
                    }
                    if (!empty($request->get('limbah3r'))) {
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
        return view('limbah.list', []);
    }
    public function viewEntri()
    {
        //
        $jenisLimbah = DB::table('md_jenislimbah')->get();
        $namaLimbah = DB::table('md_namalimbah')->get();
        $tipeLimbah = DB::table('md_tipelimbah')->get();
        $penghasilLimbah = DB::table('md_penghasillimbah')->get();
        $satuanLimbah = DB::table('md_satuan')->get();
        $tpsLimbah = DB::table('md_tps')->get();
        return view('limbah.create', [
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
        $jenisLimbah = DB::table('md_jenislimbah')->get();
        $namaLimbah = DB::table('md_namalimbah')->get();
        $tipeLimbah = DB::table('md_tipelimbah')->get();
        $penghasilLimbah = DB::table('md_penghasillimbah')->get();
        $satuanLimbah = DB::table('md_satuan')->get();
        $tpsLimbah = DB::table('md_tps')->get();
        return view('limbah.create', [
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

        $jenisLimbah = DB::table('md_jenislimbah')->get();
        $namaLimbah = DB::table('md_namalimbah')->get();
        $tipeLimbah = DB::table('md_tipelimbah')->get();
        $penghasilLimbah = DB::table('md_penghasillimbah')->get();
        $satuanLimbah = DB::table('md_satuan')->get();
        $tpsLimbah = DB::table('md_tps')->get();
        return view('limbah.list', [
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAnggaran(Request $request)
    {

        $error = null;
        $rules = array(
            'tipelimbah' => 'required',
            'tahun' => 'required',
            'total' => 'required',
            'np' => 'required',
        );
        $messages = array(
            'tipelimbah.required'            =>  'Tipe Limbah Harus Diisi',
            'tahun.required'            =>  'Tahun Harus Diisi',
            'total.required'            =>  'Total Harus Diisi',
            'np.required'            =>  'Nomor Pegawai Harus Diisi',
        );

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tipe_limbah'        =>  $request->tipelimbah,
            'tahun'                =>  $request->tahun,
            'jumlah'                =>  $request->total,
            'np'                =>  $request->np,
            'created_at'                =>  date('Y-m-d'),
        );
        try {
            $insertKuota = DB::table('md_kuota')->insert($form_data);
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
    }
    public function updateAnggaran(Request $request)
    {
        $error = null;
        $rules = array(
            'tipelimbah' => 'required',
            'tahun' => 'required',
            'total' => 'required',
            'np' => 'required',
        );
        $messages = array(
            'tipelimbah.required'            =>  'Tipe Limbah Harus Diisi',
            'tahun.required'            =>  'Tahun Harus Diisi',
            'total.required'            =>  'Total Harus Diisi',
            'np.required'            =>  'Nomor Pegawai Harus Diisi',
        );

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tipe_limbah'        =>  $request->tipelimbah,
            'tahun'                =>  $request->tahun,
            'jumlah'                =>  $request->total,
            'np'                =>  $request->np,
            'updated_at'                =>  date('Y-m-d'),
        );
        try {
            $insertKuota = DB::table('md_kuota')->where('id', $request->id)->update($form_data);
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
    }
    public function updateKonsumsi(Request $request)
    {
        $error = null;
        $rules = array(
            'konsumsi' => 'required',
            'np' => 'required',
        );
        $messages = array(
            'konsumsi.required'            =>  'Konsumsi Harus Diisi',
            'np.required'            =>  'Nomor Pegawai Harus Diisi',
        );
        $dataKuota = DB::table('md_kuota')->where('id', $request->id)->first();

        $jmlghKuotaDB = $dataKuota->jumlah;
        $jmlghKonsumsi = $dataKuota->konsumsi;
        $jmlghSisa = $dataKuota->sisa;
        // $finalJumlah=(int)$jmlghKuotaDB - (int)$request->konsumsi;
        $finalKonsumsi = (int)$jmlghKonsumsi + (int)$request->konsumsi;
        $finalSisa = (int)$jmlghKuotaDB - (int)$finalKonsumsi;

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(

            // 'jumlah'	            =>   $finalJumlah,
            'konsumsi'                =>   $finalKonsumsi,
            'sisa'                =>   $finalSisa,
            'np'                =>  $request->np,
            'updated_at'                =>  date('Y-m-d'),
        );
        try {
            $insertKuota = DB::table('md_kuota')->where('id', $request->id)->update($form_data);
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
    }

    public function store(Request $request)
    {
        $error = null;
        $rules = array(
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
            'entridate.required'            =>  'Tanggal Input Harus Diisi',
            'jenislimbah.required'            =>  'Jenis Limbah Harus Diisi',
            'namalimbah.required'            =>  'Nama Limbah Harus Diisi',
            'fisiklimbah.required'            =>  'Tipe Limbah Harus Diisi',
            'limbahasal.required'           =>  'Limbah Asal Harus Diisi',
            'jmlhlimbah.required'           =>  'Jumlah Limbah Harus Diisi',
            'satuan.required'               =>  'Satuan Harus Diisi',

        );

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'namalimbah'        =>  $request->namalimbah,
            'tgl'                =>  AppHelper::convertDate($request->entridate),
            'asallimbah'        =>  $request->limbahasal,
            'fisik'                =>  $request->fisiklimbah,
            'jenislimbah'       => $request->jenislimbah,
            'mutasi'            =>  'Input',
            'jumlah'            =>  (int)$request->jmlhlimbah,
            'satuan'            =>  $request->satuan,
            'tps'                =>   $request->tps,
            'limbah3r'            =>   $request->limbah3r,

        );
        $queryNamaLimbah = DB::table('md_namalimbah')->where('id', '=', $request->idnamalimbah)->first();
        // dd($queryNamaLimbah);
        $jumlah = $queryNamaLimbah->saldo;
        $jumlah = $jumlah + (int)$request->jmlhlimbah;


        $updateJumlah = array(
            'saldo'            =>  (int)$jumlah,
        );


        try {
            $queryInsert = DB::table('tr_mutasilimbah')->insertTs($form_data, true);
            $queryUpdate = DB::table('md_namalimbah')->where('namalimbah', '=', $request->namalimbah)->updateTs($updateJumlah, true);
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
        $error = null;
        $rules = array(
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
            'entridate.required'            =>  'Tanggal Input Harus Diisi',
            'jenislimbah.required'            =>  'Jenis Limbah Harus Diisi',
            'namalimbah.required'            =>  'Nama Limbah Harus Diisi',
            'fisiklimbah.required'            =>  'Tipe Limbah Harus Diisi',
            'limbahasal.required'           =>  'Limbah Asal Harus Diisi',
            'jmlhlimbah.required'           =>  'Jumlah Limbah Harus Diisi',
            'satuan.required'               =>  'Satuan Harus Diisi',

        );

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'namalimbah'        =>  $request->namalimbah,
            'tgl'                =>  AppHelper::convertDate($request->entridate),
            'asallimbah'        =>  $request->limbahasal,
            'fisik'                =>  $request->fisiklimbah,
            'jenislimbah'       =>  $request->jenislimbah,
            'mutasi'            =>  'Input',
            'jumlah'            =>  (int)$request->jmlhlimbah,
            'satuan'            =>  $request->satuan,
            'tps'                =>  $request->tps,
            'limbah3r'            =>  $request->limbah3r,

        );
        $queryNamaLimbah = DB::table('md_namalimbah')->where('namalimbah', '=', $request->namalimbah)->first();
        // dd($queryNamaLimbah);
        $jumlah = $queryNamaLimbah->saldo;
        $jumlah = $jumlah - (int)$request->jumlahlama;
        $jumlah = $jumlah + (int)$request->jmlhlimbah;


        $updateJumlah = array(
            'saldo'            =>  (int)$jumlah,
        );
        dd($request->hidden_id);
        try {
            $queryUpdateData = DB::table('tr_mutasilimbah')->where('id', '=', $request->hidden_id)->updateTs($form_data, true);
            // dd( $queryUpdateData);
            $queryUpdate = DB::table('md_namalimbah')->where('namalimbah', '=', $request->namalimbah)->updateTs($updateJumlah, true);
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
        $html .= '<option value="-">-</option>';
        foreach ($seri as $seri_pikai) {
            $html .= '<option value="' . $seri_pikai->seri_gol . '">' . $seri_pikai->seri_gol . '</option>';
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

        $html .= '<option value="-">-</option>';
        foreach ($namalimbah as $nama) {
            $html .= '<option value="' . $nama->namalimbah . '">' . $nama->namalimbah . '</option>';
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

        $html .= '<option value="-">-</option>';
        foreach ($namalimbah as $nama) {
            $html .= '<option value="' . $nama->satuan . '">' . $nama->satuan . '</option>';
        }
        return response()->json(['html' => $html]);
    }
    public function indexHistory(Request $request)
    {
       
        if (request()->ajax()) {
            $queryData = DB::table('tr_headermutasi')
                ->join('tr_detailmutasi', 'tr_detailmutasi.idmutasi', '=', 'tr_headermutasi.id')
                ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_penghasillimbah', 'tr_detailmutasi.idlimbah', '=', 'md_penghasillimbah.id')
                ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id')
                // ->join('md_tps', 'tr_detailmutasi.idtps', '=', 'md_tps.id')
                ->select('tr_detailmutasi.*', 
                'md_namalimbah.namalimbah', 
                'md_namalimbah.satuan', 
                'md_namalimbah.jenislimbah', 
                'md_namalimbah.tipelimbah', 
                'md_penghasillimbah.seksi', 
                'md_statusmutasi.keterangan as status',
                )
                ->orderBy('tr_detailmutasi.created_at', 'desc');

            // if (!empty($request->tglinput)) {

            //     $splitDate2 = explode(" - ", $request->tglinput);
            //     $queryData->whereBetween('tr_mutasilimbah.tgl', array(AppHelper::convertDateYmd($splitDate2[0]),  AppHelper::convertDateYmd($splitDate2[1])));
            // }
            $queryData = $queryData->get();
            return datatables()->of($queryData)
                // ->filter(function ($instance) use ($request) {
                //     if (!empty($request->get('jenislimbah'))) {
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains(Str::lower($row['jenislimbah']), Str::lower($request->get('jenislimbah'))) ? true : false;
                //         });
                //     }
                //     if (!empty($request->get('namalimbah'))) {
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains(Str::lower($row['namalimbah']), Str::lower($request->get('namalimbah'))) ? true : false;
                //         });
                //     }

                //     if (!empty($request->get('mutasi'))) {
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['mutasi'], $request->get('mutasi')) ? true : false;
                //         });
                //     }
                //     if (!empty($request->get('fisik'))) {
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['fisik'], $request->get('fisik')) ? true : false;
                //         });
                //     }
                //     if (!empty($request->get('asallimbah'))) {
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['asallimbah'], $request->get('asallimbah')) ? true : false;
                //         });
                //     }
                //     if (!empty($request->get('tpslimbah'))) {
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['tps'], $request->get('tpslimbah')) ? true : false;
                //         });
                //     }
                //     if (!empty($request->get('limbah3r'))) {
                //         $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                //             return Str::contains($row['limbah3r'], $request->get('limbah3r')) ? true : false;
                //         });
                //     }
                // })
                ->addIndexColumn()
                // ->addColumn('action', 'action_butt_limbah')
                // ->rawColumns(['action'])

                ->make(true);
        }
        return view('report.history_transaksi', []);
    }
    public function viewHistory()
    {
        
        return view('report.history_transaksi', QueryHelper::getDropDown());
    }
}
