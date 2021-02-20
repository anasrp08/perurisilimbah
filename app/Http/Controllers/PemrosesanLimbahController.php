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
            $queryData = DB::table('tr_headermutasi')
                // ->join('tr_packing', 'tr_packing.idmutasi', '=', 'tr_headermutasi.id')
                // ->join('tr_headermutasi', 'tr_packing.idmutasi', '=', 'tr_headermutasi.id')
                ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_tps', 'tr_headermutasi.idtps', '=', 'md_tps.id')
                // ->join('md_jenislimbah', 'md_jenislimbah.id', '=', 'md_namalimbah.idjenislimbah')
                // ->join('md_statusmutasi', 'tr_headermutasi.idstatus', '=', 'md_statusmutasi.id')
                ->join('md_satuan', 'tr_headermutasi.idsatuan', '=', 'md_satuan.id')
                ->select(
                    'tr_headermutasi.id_transaksi',
                    'tr_headermutasi.idlimbah',
                    'md_tps.namatps',
                    // 'md_statusmutasi.keterangan',
                    // 'tr_packing.*',
                    'md_satuan.satuan',
                    'md_namalimbah.*',
                    DB::raw('SUM(tr_headermutasi.jumlah) as total_saldo')

                )
                ->where('tr_headermutasi.jumlah', '!=', 0)
                // ->whereIn('tr_packing.idstatus',['3','4','5','6','7'])
                ->groupBy('tr_headermutasi.idlimbah');

            $queryData = $queryData->get();
            return datatables()->of($queryData)

                ->addIndexColumn()
                ->make(true);
        }
        return view('pemrosesan.list', []);
    }
    public function indexLain(Request $request)
    { 
        if (request()->ajax()) {
            $queryData = DB::table('tbl_pemroses_lain')->where('is_deleted','=',null);

            $queryData = $queryData->get();
            return datatables()->of($queryData)

                ->addIndexColumn()
                ->addColumn('action', 'action_proses')
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pemrosesan.list_lain', []);
    }

     
    public function detaillist(Request $request)
    {
        // dd($request->all());
        if (request()->ajax()) {
            $queryData = DB::table('tr_packing')
                ->join('tr_headermutasi', 'tr_packing.idmutasi', '=', 'tr_headermutasi.id')
                ->join('md_namalimbah', 'tr_packing.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_tps', 'tr_packing.idtps', '=', 'md_tps.id')
                // ->join('tr_statusmutasi', 'tr_packing.idmutasi', '=', 'tr_statusmutasi.idmutasi')
                // ->join('md_statusmutasi', 'tr_statusmutasi.idstatus', '=', 'md_statusmutasi.id')
                ->join('md_satuan', 'tr_headermutasi.idsatuan', '=', 'md_satuan.id')
                ->select(
                    'tr_packing.*',
                    'tr_headermutasi.id_transaksi',
                    'tr_headermutasi.idlimbah',
                    'tr_headermutasi.idjenislimbah',
                    'tr_headermutasi.idasallimbah',
                    'tr_headermutasi.idtps',
                    'tr_headermutasi.tgl',
                    'tr_headermutasi.idsatuan',
                    'tr_headermutasi.limbah3r',
                    'tr_headermutasi.jumlah',
                    'tr_headermutasi.tgl as tgl_permohonan',
                    'md_satuan.satuan as nama_satuan',
                    // 'tr_statusmutasi.jumlah', 
                    // DB::raw('COUNT(tr_packing.idlimbah) as total_pack'),

                    'md_namalimbah.*',
                    'md_tps.*',
                    'md_satuan.satuan as nama_satuan'
                )
                // ->where('tr_packing.kode_pack','=',$request->kodepack)
                ->where('tr_packing.idlimbah', '=', $request->idlimbah)
                ->where('tr_headermutasi.jumlah', '!=', 0)
                ->groupBy('tr_packing.idmutasi');

            $queryData = $queryData->get();

            return datatables()->of($queryData)

                ->addIndexColumn()
                ->addColumn('action', 'f_proses_out')
                ->rawColumns(['action'])

                ->make(true);
        }
    }
    public function proses(Request $request)
    {
      
        $username = AuthHelper::getAuthUser()[0]->email;

        $getRequest = json_decode($request->getContent(), true);

        $dataRequest = $getRequest['detail'];

        $countDataReq = count($dataRequest);
        $error = null;
        $dataDetail = null;
        $nopack = null;
        try {
            foreach ($dataRequest as $row) {
                $dataHeader = DB::table('tr_headermutasi')->where('id', $row['idmutasi'])->first();
                // $dataStatus = DB::table('tr_statusmutasi')->where('idmutasi', $row['idmutasi'])->first();
                $jmlh_pack=UpdtSaldoHelper::convertJumlahToPack($row['idlimbah'],$row['jmlh_proses']);
                $jmlh = $dataHeader->jumlah;
                $valJumlah = (int)$row['jumlah'] - (int)$row['jmlh_proses'];
                
                $status = null;
                if ($valJumlah == 0) {
                    $status = $row['idstatus'];
                } else {
                    $status = $row['status_lama'];
                }
                $jmlhOut = (int)$dataHeader->jumlah_out + (int)$row['jmlh_proses'];
                $jmlhOutPack = (double)$dataHeader->pack_out + (double)$jmlh_pack;
                $valPackIn = (double)$dataHeader->pack_in - (double)$jmlh_pack;
                $dataDetail = array(
                    'id_transaksi'        => $row['id_transaksi'],
                    'idmutasi'            => $row['idmutasi'],
                    'idlimbah'            => $row['idlimbah'],
                    'idjenislimbah'       => $row['idjenislimbah'],
                    'idstatus'            => $row['idstatus'],
                    'idasallimbah'        => $row['idasallimbah'],
                    'idtps'               => $row['idtps'],
                    'tgl'                 => $row['tgl'],
                    'jumlah'              => $row['jmlh_proses'],
                    'idsatuan'            => $row['idsatuan'],
                    'pack_out'            =>  $jmlh_pack,
                    // 'jumlah_out'            => $row['jmlh_proses'], 
                    'limbah3r'            => $row['limbah3r'],
                    'created_at'            => date('Y-m-d'),
                    'np_pemroses'           => $row['np_pemroses'],
                    'created_by'            => $username,

                );

                $dataHeader = array(
                    'id_transaksi'          =>  $row['id_transaksi'],
                    'idstatus'              =>  $status,
                    'updated_at'            => date('Y-m-d'),
                    'jumlah'                => $valJumlah,
                    'jumlah_out'            => $jmlhOut,
                    'pack_in'               =>  $valPackIn,
                    'pack_out'              => $jmlhOutPack,
                    'idsatuan'              => $row['idsatuan'],
                    'idtps'                 => $row['idtps'],
                    'idvendor'              => $row['idvendor'],
                    'no_manifest'           => $row['nomanifest'],
                    'no_spbe'               => $row['nospbe'],
                    'no_kendaraan'          => $row['nokendaraan'],
                    'np_pemroses'           => $row['np_pemroses'],
                    'changed_by'            => $username,
                );
                // $dataPacking = array(
                //     'id_transaksi'          =>  $row['id_transaksi'],
                //     'no_packing'            =>  $row['no_packing'],
                //     // 'kode_pack'            => $row['kode_pack'],
                //     'idmutasi'              => $row['idmutasi'],
                //     'idlimbah'              => $row['idlimbah'],
                //     'idtps'                 => $row['idtps'],
                //     // 'tipelimbah'            => $row['tipelimbah'],
                //     'idstatus'              => $status,
                //     'kadaluarsa'            => date('Y-m-d', strtotime("+ 90 day")),
                //     'created_at'            => date('Y-m-d'),
                //     // 'np'                   =>$row['np'],
                //     'created_by'            =>$username,
                // );
                // $dataTPS = array('idtps' => $row['idtps'],
                // 'idvendor' => $row['idvendor'],
                // 'no_manifest' => $row['nomanifest'],
                // 'no_spbe' => $row['nospbe'],
                // 'no_kendaraan' => $row['nokendaraan'],
                // );

                // dd($dataDetail);
                $insertDetail = DB::table('tr_detailmutasi')->insert($dataDetail);
                $insertHeader = DB::table('tr_headermutasi')->where('id', $row['idmutasi'])->update($dataHeader);
                // $insertPacking = DB::table('tr_packing')->where('idmutasi', $row['idmutasi'])->update($dataPacking);


                // UpdtSaldoHelper::updateKurangSaldoTPS($row['idtps'], $row['jmlh_proses']);
                UpdtSaldoHelper::updateKurangSaldoNamaLimbah($row['idlimbah'], $row['jmlh_proses']);
                UpdtSaldoHelper::updateKurangPackTPS($row['idtps'], $jmlh_pack);
                UpdtSaldoHelper::updateKurangPackNamaLimbah($row['idlimbah'], $jmlh_pack);
            }
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
    }
    public function prosesLain(Request $request)
    {
        //  dd($request->all());
        $error =null;
        $rules = array(
            'nama_limbah' => 'required',
            'tgl_proses'=> 'required', 
            'jmlh'=> 'required',
            'unit_penghasil'=> 'required',
            'treatmen'=> 'required',
            'satuan'=> 'required',
            'np_pemroses'=> 'required',
            'file'=>'nullable|mimes:pdf|max:10048'
        );

       
        $messages = array(
            'nama_limbah' => 'Nama Limbah Harus Diisi',
            'tgl_proses'=> 'Tgl PermohonanHarus Diisi', 
            'jmlh'=> 'Jumlah Limbah Harus Diisi',
            'unit_penghasil'=> 'Unit Penghasil Limbah Harus Diisi',
            'treatmen'=> 'Treatmen Limbah Harus Diisi',
            'satuan'=> 'Satuan Limbah Harus Diisi',
            'np_pemroses'=> 'NP Pemroses Limbah Harus Diisi',
            'file'=>'nullable|mimes:pdf|max:10048',

            'required' => 'form :attribute harus diisi.',
            'same'    => 'The :attribute and :other must match.',
            'max'    => 'file :attribute terlalu besar max :max Kb.',
            'between' => 'The :attribute must be between :min - :max.',
            'in'      => 'The :attribute must be one of the following types: :values',
            
        );
         
        $error = Validator::make($request->all(), $rules, $messages); 
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->tgl_proses) {
           $tgl_proses= AppHelper::convertDate($request->tgl_proses);
           
        }
        $path_file_proses=null;
        $savepath_srtkantor=null;
        
        try {
            if ($request->hasFile('file')) {
                $path_file_proses=AppHelper::pathFile('File Proses');
                if (!File::exists($path_file_proses)) {
                    // path does not exist
                    File::makeDirectory($path_file_proses, $mode = 0777, true, true);
                }
                $upload_file=$request->file('file');
                $file=$upload_file->getClientOriginalName(); 
                // $filename_srtkantor='SURATKANTOR'.'_'.$pathname1[0].'.'.$extension;
                $upload_file->move($path_file_proses, $file);
                $savepath_file=AppHelper::savePath('File Proses', $file); 
                
            } 
                $dataProseslain = array(
                    'tgl_proses'        => $tgl_proses,
                    'nama_limbah'       => $request->nama_limbah,
                    'jumlah'            => $request->jmlh,
                    'treatmen'          => $request->treatmen, 
                    'unit_penghasil'    => $request->unit_penghasil,
                    'created_at'        => date('Y-m-d'),
                    'satuan'       => $request->satuan,
                    'keterangan'       => $request->keterangan,
                    'np_pemroses'       => $request->np_pemroses,
                    'file'        		=> $savepath_file

                );
               
                $insertDataProsesLain = DB::table('tbl_pemroses_lain')->insert($dataProseslain);
            
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
    }


    public function viewIndex()
    {

        $vendor = DB::table('md_vendorlimbah')->groupBy('namavendor')->get();
        $np = DB::table('tbl_np')->get();
        // $namaLimbah=DB::table('md_namalimbah')->get();
        // $tipeLimbah=DB::table('md_tipelimbah')->get();
        // $penghasilLimbah=DB::table('md_penghasillimbah')->get();
        // $satuanLimbah=DB::table('md_satuan')->get();
        // $tpsLimbah=DB::table('md_tps')->get();
        // dd($vendor);
        return view('pemrosesan.list', [
            'vendor' => $vendor,
            'np' => $np



        ]);
    }
    public function viewIndexLain()
    {

        $vendor = DB::table('md_vendorlimbah')->groupBy('namavendor')->get();
        $np = DB::table('tbl_np')->get();
         $penghasilLimbah=DB::table('md_penghasillimbah')->get();
        // $namaLimbah=DB::table('md_namalimbah')->get();
        // $tipeLimbah=DB::table('md_tipelimbah')->get();
        // $penghasilLimbah=DB::table('md_penghasillimbah')->get();
        // $satuanLimbah=DB::table('md_satuan')->get();
        // $tpsLimbah=DB::table('md_tps')->get();
        // dd($vendor);
        return view('pemrosesan.list_lain', [ 
            'np' => $np,
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
        //  dd($request->all());
        $error =null;
        $rules = array(
            'nama_limbah' => 'required',
            'tgl_proses'=> 'required', 
            'jmlh'=> 'required',
            'unit_penghasil'=> 'required',
            'treatmen'=> 'required',
            'satuan'=> 'required',
            'np_pemroses'=> 'required',
            'file'=>'nullable|mimes:pdf|max:10048'
        );

       
        $messages = array(
            'nama_limbah' => 'Nama Limbah Harus Diisi',
            'tgl_proses'=> 'Tgl PermohonanHarus Diisi', 
            'jmlh'=> 'Jumlah Limbah Harus Diisi',
            'unit_penghasil'=> 'Unit Penghasil Limbah Harus Diisi',
            'treatmen'=> 'Treatmen Limbah Harus Diisi',
            'satuan'=> 'Satuan Limbah Harus Diisi',
            'np_pemroses'=> 'NP Pemroses Limbah Harus Diisi',
            'file'=>'nullable|mimes:pdf|max:10048',

            'required' => 'form :attribute harus diisi.',
            'same'    => 'The :attribute and :other must match.',
            'max'    => 'file :attribute terlalu besar max :max Kb.',
            'between' => 'The :attribute must be between :min - :max.',
            'in'      => 'The :attribute must be one of the following types: :values',
            
        );
         
        $error = Validator::make($request->all(), $rules, $messages); 
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        if ($request->tgl_proses) {
           $tgl_proses= AppHelper::convertDate($request->tgl_proses);
           
        }
        $path_file_proses=null;
        $savepath_srtkantor=null;
        $dataProseslain=null;
        try {
            if ($request->hasFile('file')) {
                $path_file_proses=AppHelper::pathFile('File Proses');
                if (!File::exists($path_file_proses)) {
                    // path does not exist
                    File::makeDirectory($path_file_proses, $mode = 0777, true, true);
                }
                $upload_file=$request->file('file');
                $file=$upload_file->getClientOriginalName(); 
                // $filename_srtkantor='SURATKANTOR'.'_'.$pathname1[0].'.'.$extension;
                $upload_file->move($path_file_proses, $file);
                $savepath_file=AppHelper::savePath('File Proses', $file); 
                
                $dataProseslain = array(
                    'tgl_proses'        => $tgl_proses,
                    'nama_limbah'       => $request->nama_limbah,
                    'jumlah'            => $request->jmlh,
                    'treatmen'          => $request->treatmen, 
                    'unit_penghasil'    => $request->unit_penghasil,
                    'created_at'        => date('Y-m-d'),
                    'np_pemroses'       => $request->np_pemroses,
                    'satuan'       => $request->satuan,
                    'alasan' => $request->alasan,
                    'keterangan'       => $request->keterangan,
                    'file'        		=> $savepath_file 
                );
            } else{
                $dataProseslain = array(
                    'tgl_proses'        => $tgl_proses,
                    'nama_limbah'       => $request->nama_limbah,
                    'jumlah'            => $request->jmlh,
                    'treatmen'          => $request->treatmen, 
                    'unit_penghasil'    => $request->unit_penghasil,
                    'created_at'        => date('Y-m-d'),
                    'satuan'       => $request->satuan,
                    'alasan' => $request->alasan,
                    'keterangan'       => $request->keterangan,
                    'np_pemroses'       => $request->np_pemroses 
                );
            }
               
               
                $updateData = DB::table('tbl_pemroses_lain')->where('id',$request->hidden_id)->update($dataProseslain);
            
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
        $dataUpdate = array(
            'is_deleted'         => 1,
            'updated_by'        =>date('Y-m-d')
            

        );
       
        $updateDelete = DB::table('tbl_pemroses_lain')->where('id',$id)->update($dataUpdate);
        return response()->json(['success' => 'Data Berhasil Di Di Hapus']);
    }
}
