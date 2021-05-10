<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\RoleUser;
use App\Helpers\AppHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Helpers\QueryHelper; 
use Redirect;
use Validator;
use Response;
use Image;
use Excel; 
use DB;
use App\Jobs\ImportJobKantor;

class TransaksiKontrakB3Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // public function __construct(
    //     User $user )
    // {
    //     $this->photo = $photo;
    // }
    public function view()
    { 
        return view('tr_kontrak.list',QueryHelper::getDropDown());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if (request()->ajax()) {
            $queryData=DB::table('tr_kontrak_b3')
            ->join('md_tipelimbah','tr_kontrak_b3.tipe_limbah','md_tipelimbah.id')
            ->join('tbl_np','tr_kontrak_b3.np','tbl_np.np')
            ->where('tahun',$request->tahun)
            ->select('tr_kontrak_b3.*','md_tipelimbah.*','tr_kontrak_b3.created_at as tgl_dibuat',
            'tbl_np.nama' )
            ->orderBy('tr_kontrak_b3.tipe_limbah')
            ->get();
            return datatables()->of($queryData)
                    ->addColumn('action', 'action_button') 
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
            
        }  
        return view('tr_kontrak.list',[
            
            ]);
    }
    public function indexNeracaKontrak(Request $request)
    {
        if (request()->ajax()) {
            $queryData = DB::table('md_kuota')
                ->join('md_tipelimbah', 'md_tipelimbah.id', 'md_kuota.tipe_limbah')
                ->leftjoin('tr_kontrak_b3','md_kuota.tipe_limbah', 'tr_kontrak_b3.tipe_limbah')
                ->select('md_kuota.*','md_tipelimbah.*',DB::raw('sum(tr_kontrak_b3.konsumsi) as jumlah_konsumsi'))
                ->where('md_kuota.tahun',$request->tahun)
                ->groupBy('tr_kontrak_b3.tipe_limbah')
                ->orderBy('md_kuota.tipe_limbah')
                ->get();
                // dd($queryData);
 
            return datatables()->of($queryData)

                ->addIndexColumn()
                ->addColumn('action', 'action_butt_anggaran')
                ->rawColumns(['action'])

                ->make(true);
        }
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
       
        // dd($request->transaksi_tipelimbah);
        $error = null;
        $rules = array(
            'transaksi_tipelimbah' => 'required',
            'transaksi_tahun' => 'required',
            'transaksi_total' => 'required',
            'jmlhlimbah' => 'required',
            'dataharga' => 'required',
            'transaksi_konsumsi'=>'required',
            'transaksi_np' => 'required',
        );
        $messages = array(
            'transaksi_tipelimbah.required' => 'Tipe Limbah Harus Diisi',
            'transaksi_tahun.required' => 'Tipe Limbah Harus Diisi',
            'transaksi_total.required' => 'Tipe Limbah Harus Diisi',
            'jmlhlimbah.required' => 'Tipe Limbah Harus Diisi',
            'dataharga.required' => 'Tipe Limbah Harus Diisi',
            'transaksi_konsumsi.required'=>'Tipe Limbah Harus Diisi',
            'transaksi_np.required' => 'Tipe Limbah Harus Diisi',
        );

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tipe_limbah'=>$request->transaksi_tipelimbah,
            'jmlh_limbah'=>$request->jmlhlimbah,
            'harga'      =>$request->dataharga,
            'satuan'     =>$request->satuan,
            'konsumsi'   =>(int)str_replace('.', '', $request->transaksi_konsumsi),      
            'tahun'      =>$request->transaksi_tahun,
            'np'         =>$request->transaksi_np,
            'created_at'                =>  date('Y-m-d'),
        );
        try {
            $insertKuota = DB::table('tr_kontrak_b3')->insert($form_data);
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
    public function getDataTipeLimbah(Request $request)
    { 
        $dataTipeKuota=DB::table('md_namalimbah')->where('tipe_kuota_limbah',$request->idtipe)->first();
        $md_kuota=DB::table('md_kuota')
        ->where('tipe_limbah',$request->idtipe)
        ->where('tahun',$request->tahun)
        ->first();
        $jumlah=0; 
        if($md_kuota == null){ 
        }else{
            $jumlah=$md_kuota->jumlah;
        }
        return response()->json([
            'dataHarga' =>$dataTipeKuota->harga_satuan_konversi,
            'dataSatuan' =>$dataTipeKuota->konversi_kuota,
            'md_kuota' =>$jumlah
            
            ]);
         
    }

    public function destroy($id)
    {
        //
        $queryUpdate=DB::table('tr_kontrak_b3')
        ->where('id','=',$id); 
        $queryUpdate->delete();
    }
     

    public function edit($id)
    {
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request )
    {
         
    }
 

    
}
