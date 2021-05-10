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
        if (request()->ajax()) {
            $queryData = DB::table('tr_headermutasi')
                ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_tps', 'tr_headermutasi.idtps', '=', 'md_tps.id')
                ->join('md_satuan', 'tr_headermutasi.idsatuan', '=', 'md_satuan.id')
                ->select(
                    'tr_headermutasi.id_transaksi',
                    'tr_headermutasi.idlimbah', 
                    'md_tps.namatps',
                    'md_satuan.satuan as satuanlimbah',
                    'md_namalimbah.*',
                    DB::raw('SUM(tr_headermutasi.jumlah_in) as total_saldo')
                )
                ->where('tr_headermutasi.jumlah_in', '!=', 0)
                ->orderBy('tr_headermutasi.tgl', 'asc')
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
            $queryData = DB::table('tbl_pemroses_lain')->where('is_deleted', '=', null);

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
        if (request()->ajax()) {
            $queryData = DB::table('tr_headermutasi')
                ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('md_satuan', 'tr_headermutasi.idsatuan', '=', 'md_satuan.id')
                ->select(
                    'tr_headermutasi.id as idmutasi',
                    'tr_headermutasi.id_transaksi',
                    'tr_headermutasi.idlimbah',
                    'tr_headermutasi.idjenislimbah',
                    'tr_headermutasi.idasallimbah',
                    'tr_headermutasi.idstatus',
                    'tr_headermutasi.jmlh_massa_in',
                    'tr_headermutasi.idtps',
                    'tr_headermutasi.tgl',
                    'tr_headermutasi.idsatuan',
                    'tr_headermutasi.limbah3r',
                    'tr_headermutasi.jumlah_in',
                    'tr_headermutasi.tgl_kadaluarsa',
                    'tr_headermutasi.jumlah_out',
                    'tr_headermutasi.tgl as tgl_permohonan',
                    'md_satuan.satuan as nama_satuan',
                    'md_namalimbah.*',
                    DB::raw('ROUND(tr_headermutasi.jmlh_massa_in / tr_headermutasi.jumlah_in) as pembagi'),
                    // 'md_satuan.satuan as nama_satuan'
                )
                ->where('tr_headermutasi.idlimbah', '=', $request->idlimbah)
                ->where('tr_headermutasi.jumlah_in', '!=', 0)
                ->where('tr_headermutasi.idtps', '!=', '')
                ->where('tr_headermutasi.idstatus', '=', '3')
                ->orderBy('tr_headermutasi.tgl', 'asc');

            $queryData = $queryData->get(); 
            return datatables()->of($queryData)

                ->addIndexColumn()
                ->addColumn('action', 'f_proses_out')
                ->rawColumns(['action'])

                ->make(true);
        }
    }
    public function prosesReportHorizontal($row,$dataHeader,$jmlh_pack,$username)
    {
        
        $jumlahKecilKeluar = (int)$row['jmlh_proses'] / (int)$row['pembagi'];
        // $sisaMassa = (float)$row['jmlh_massa_in'] - (float)$row['jmlh_proses'];
        $sisaJumlahKecil=0;

        if($row['jmlh_massa_in'] == '0'){
            $sisaJumlahKecil=0;
        }else{
            $sisaJumlahKecil = (int)$row['jumlah_in'] - (int)$jumlahKecilKeluar;
        }
        
        $status = $this->isZero($sisaJumlahKecil, $row);
        $jmlhOut = (int)$dataHeader->jumlah_out + (int)$jumlahKecilKeluar;

        $jmlhMassaOut = (float)$dataHeader->jmlh_massa_out + (float)$row['jmlh_proses'];
        $jmlhMassaIn = (float)$dataHeader->jmlh_massa_in - (float)$row['jmlh_proses'];

        $jmlhOutPack = (float)$dataHeader->pack_out + (float)$jmlh_pack;
        $valPackIn = (float)$dataHeader->pack_in - (float)$jmlh_pack;

        $dataDetail = array(
            'id_transaksi'        => $row['id_transaksi'],
            'idmutasi'            => $row['idmutasi'],
            'idlimbah'            => $row['idlimbah'],
            'idjenislimbah'       => $row['idjenislimbah'],
            'idstatus'            => $row['idstatus'],
            'idasallimbah'        => $row['idasallimbah'],
            'idtps'               => $row['idtps'],
            'tgl'                 => $row['tglproses'],
            'idsatuan'            => $row['idsatuan'],
            'pack'                  =>  $jmlh_pack,
            'jumlah'                => $jumlahKecilKeluar,
            'jmlh_massa'            => $row['jmlh_proses'],
            'limbah3r'              => $row['limbah3r'],
            'created_at'            => date('Y-m-d'),
            'np_pemroses'           => $row['np_pemroses'],
            'no_ba_pemusnahan'      => $this->getNoBAPemusnahan(), 
            'created_by'            => $username,

        );

        $dataHeader = array(
            'id_transaksi'          =>  $row['id_transaksi'],
            'idstatus'              =>  $status,
            'updated_at'            =>  date('Y-m-d'),
            'jumlah_in'             =>  $sisaJumlahKecil,
            'jumlah_out'            =>  $jmlhOut,
            'jmlh_massa_in'            => $jmlhMassaIn ,
            'jmlh_massa_out'            =>  $jmlhMassaOut,
            'pack_in'               =>  $valPackIn,
            'pack_out'              =>  $jmlhOutPack,
            'idsatuan'              =>  $row['idsatuan'],
            'idtps'                 =>  $row['idtps'],
            'idvendor'              =>  $row['idvendor'],
            'no_manifest'           =>  $row['nomanifest'],
            'no_spbe'               =>  $row['nospbe'],
            'no_kendaraan'          =>  strtoupper($row['nokendaraan']),
            'np_pemroses'           =>  $row['np_pemroses'],
            'changed_by'            =>  $username,
        );

        $insertDetail = DB::table('tr_detailmutasi')->insertGetId($dataDetail);
        $dataValidasi = array(
            'id_detail'             =>  $insertDetail,
            'id_mutasi'             => $row['idmutasi'],
            'keterangan_proses'     => $row['keterangan_proses'],
            'created_at'            => date('Y-m-d'),

        ); 
        $isInserted = $this->insert($dataValidasi, $dataHeader, $row);
        if ($isInserted) {
            $this->updateSaldo($row, $jmlh_pack);
        } else {
        }
    }
    public function prosesNonReportHorizontal($row,$dataHeader,$jmlh_pack,$username)
    {
        $valJumlah = (int)$row['jumlah_in'] - (int)$row['jmlh_proses'];
        $status = $this->isZero($valJumlah, $row);
        $jmlhOut = (int)$dataHeader->jumlah_out + (int)$row['jmlh_proses'];
        $jmlhOutPack = (float)$dataHeader->pack_out + (float)$jmlh_pack;
        $valPackIn = (float)$dataHeader->pack_in - (float)$jmlh_pack;

        $dataDetail = array(
            'id_transaksi'        => $row['id_transaksi'],
            'idmutasi'            => $row['idmutasi'],
            'idlimbah'            => $row['idlimbah'],
            'idjenislimbah'       => $row['idjenislimbah'],
            'idstatus'            => $row['idstatus'],
            'idasallimbah'        => $row['idasallimbah'],
            'idtps'               => $row['idtps'],
            'tgl'                 => $row['tglproses'],
            'idsatuan'            => $row['idsatuan'],
            'pack'                  =>  $jmlh_pack,
            'jumlah'                => $row['jmlh_proses'],
            'limbah3r'            => $row['limbah3r'],
            'created_at'            => date('Y-m-d'),
            'np_pemroses'           => $row['np_pemroses'],
            'no_ba_pemusnahan'           => $this->getNoBAPemusnahan(), 
            'created_by'            => $username,

        );

        $dataHeader = array(
            'id_transaksi'          =>  $row['id_transaksi'],
            'idstatus'              =>  $status,
            'updated_at'            =>  date('Y-m-d'),
            'jumlah_in'             =>  $valJumlah,
            'jumlah_out'            =>  $jmlhOut,
            'pack_in'               =>  $valPackIn,
            'pack_out'              =>  $jmlhOutPack,
            'idsatuan'              =>  $row['idsatuan'],
            'idtps'                 =>  $row['idtps'],
            'idvendor'              =>  $row['idvendor'],
            'no_manifest'           =>  $row['nomanifest'],
            'no_spbe'               =>  $row['nospbe'],
            'no_kendaraan'          =>  strtoupper($row['nokendaraan']),
            'np_pemroses'           =>  $row['np_pemroses'],
            'changed_by'            =>  $username,
        );

        $insertDetail = DB::table('tr_detailmutasi')->insertGetId($dataDetail);
        $dataValidasi = array(
            'id_detail'             =>  $insertDetail,
            'id_mutasi'             => $row['idmutasi'],
            'keterangan_proses'     => $row['keterangan_proses'],
            'created_at'            => date('Y-m-d'),

        );

        $isInserted = $this->insert($dataValidasi, $dataHeader, $row);
        if ($isInserted) {
            $this->updateSaldo($row, $jmlh_pack);
        } else {
        }
    }
    public function isZero($valJumlah, $dataRow)
    {

        if ($valJumlah == 0) {
            return $dataRow['idstatus'];
        } else {
            return $dataRow['status_lama'];
        }
    }
    public function updateSaldo($dataRow, $jmlh_pack)
    {
        UpdtSaldoHelper::updateKurangSaldoTPS($dataRow['idtps'], $dataRow['jmlh_proses']);
        UpdtSaldoHelper::updateKurangSaldoNamaLimbah($dataRow['idlimbah'], $dataRow['jmlh_proses']);
        UpdtSaldoHelper::updateKurangPackTPS($dataRow['idtps'], $jmlh_pack);
        UpdtSaldoHelper::updateKurangPackNamaLimbah($dataRow['idlimbah'], $jmlh_pack);
    }

    public function insert($dataValidasi, $dataHeader, $dataRow)
    {
        try {
            $insertValidasi = DB::table('tr_validasi_ba')->insert($dataValidasi);
            $insertHeader = DB::table('tr_headermutasi')->where('id', $dataRow['idmutasi'])->update($dataHeader);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function proses(Request $request)
    {

        $username = AuthHelper::getAuthUser()[0]->email;

        $getRequest = json_decode($request->getContent(), true);

        $dataRequest = $getRequest['detail'];
        $countDataReq = count($dataRequest);
        
        $jmlh_pack = null;
        try {
            foreach ($dataRequest as $row) {
                $dataHeader = DB::table('tr_headermutasi')
                ->join('md_namalimbah','tr_headermutasi.idlimbah','md_namalimbah.id')
                ->where('tr_headermutasi.id', $row['idmutasi'])->first();
                $jmlh_pack = UpdtSaldoHelper::convertJumlahToPack($row['idlimbah'], $row['jmlh_proses']);
                $jmlh = $dataHeader->jumlah_in;
                //check limbah masuk report horizontal / tidak
                if ($dataHeader->tipe_kuota_limbah != '-') {

                    $this->prosesReportHorizontal($row,$dataHeader,$jmlh_pack,$username);
                } else {
                    $this->prosesNonReportHorizontal($row,$dataHeader,$jmlh_pack,$username);
                }
            }
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
    }
    public function prosesLain(Request $request)
    {
        $error = null;
        $rules = array(
            'nama_limbah' => 'required',
            'tgl_proses' => 'required',
            'jmlh' => 'required',
            'unit_penghasil' => 'required',
            'treatmen' => 'required',
            'satuan' => 'required',
            'np_pemroses' => 'required',
            'file' => 'nullable|mimes:pdf|max:10048'
        );
        $messages = array(
            'nama_limbah' => 'Nama Limbah Harus Diisi',
            'tgl_proses' => 'Tgl PermohonanHarus Diisi',
            'jmlh' => 'Jumlah Limbah Harus Diisi',
            'unit_penghasil' => 'Unit Penghasil Limbah Harus Diisi',
            'treatmen' => 'Treatmen Limbah Harus Diisi',
            'satuan' => 'Satuan Limbah Harus Diisi',
            'np_pemroses' => 'NP Pemroses Limbah Harus Diisi',
            'file' => 'nullable|mimes:pdf|max:10048',

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
            $tgl_proses = AppHelper::convertDate($request->tgl_proses);
        }
        $path_file_proses = null;
        $savepath_srtkantor = null;

        try {
            if ($request->hasFile('file')) {
                $path_file_proses = AppHelper::pathFile('File Proses');
                if (!File::exists($path_file_proses)) {
                    // path does not exist
                    File::makeDirectory($path_file_proses, $mode = 0777, true, true);
                }
                $upload_file = $request->file('file');
                $file = $upload_file->getClientOriginalName();
                $upload_file->move($path_file_proses, $file);
                $savepath_file = AppHelper::savePath('File Proses', $file);
            }
            $dataProseslain = array(
                'tgl_proses'        => $tgl_proses,
                'nama_limbah'       => $request->nama_limbah,
                'jumlah'            => $request->jmlh,
                'treatmen'          => $request->treatmen,
                'unit_penghasil'    => $request->unit_penghasil,
                'created_at'        => date('Y-m-d'),
                'satuan'            => $request->satuan,
                'keterangan'        => $request->keterangan,
                'np_pemroses'       => $request->np_pemroses,
                'file'                => $savepath_file

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
        return view('pemrosesan.list', [
            'vendor' => $vendor,
            'np' => $np



        ]);
    }
    public function viewIndexLain()
    {

        $vendor = DB::table('md_vendorlimbah')->groupBy('namavendor')->get();
        $np = DB::table('tbl_np')->get();
        $penghasilLimbah = DB::table('md_penghasillimbah')->get();
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
        $error = null;
        $rules = array(
            'nama_limbah' => 'required',
            'tgl_proses' => 'required',
            'jmlh' => 'required',
            'unit_penghasil' => 'required',
            'treatmen' => 'required',
            'satuan' => 'required',
            'np_pemroses' => 'required',
            'file' => 'nullable|mimes:pdf|max:10048'
        );


        $messages = array(
            'nama_limbah' => 'Nama Limbah Harus Diisi',
            'tgl_proses' => 'Tgl PermohonanHarus Diisi',
            'jmlh' => 'Jumlah Limbah Harus Diisi',
            'unit_penghasil' => 'Unit Penghasil Limbah Harus Diisi',
            'treatmen' => 'Treatmen Limbah Harus Diisi',
            'satuan' => 'Satuan Limbah Harus Diisi',
            'np_pemroses' => 'NP Pemroses Limbah Harus Diisi',
            'file' => 'nullable|mimes:pdf|max:10048',

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
            $tgl_proses = AppHelper::convertDate($request->tgl_proses);
        }
        $path_file_proses = null;
        $savepath_srtkantor = null;
        $dataProseslain = null;
        try {
            if ($request->hasFile('file')) {
                $path_file_proses = AppHelper::pathFile('File Proses');
                if (!File::exists($path_file_proses)) {
                    // path does not exist
                    File::makeDirectory($path_file_proses, $mode = 0777, true, true);
                }
                $upload_file = $request->file('file');
                $file = $upload_file->getClientOriginalName();
                // $filename_srtkantor='SURATKANTOR'.'_'.$pathname1[0].'.'.$extension;
                $upload_file->move($path_file_proses, $file);
                $savepath_file = AppHelper::savePath('File Proses', $file);

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
                    'file'                => $savepath_file
                );
            } else {
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


            $updateData = DB::table('tbl_pemroses_lain')->where('id', $request->hidden_id)->update($dataProseslain);

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
            'updated_by'        => date('Y-m-d')


        );

        $updateDelete = DB::table('tbl_pemroses_lain')->where('id', $id)->update($dataUpdate);
        return response()->json(['success' => 'Data Berhasil Di Di Hapus']);
    }
    public function getNoBAPemusnahan(){

        $noBA = DB::table('md_ba_pemusnahan')->where('tahun',date('Y'))->first(); 
        if ($noBA === null) {
            $dataNomor = array(
                'no'         => 1,
                'tahun'        =>date('Y')
                
    
            );
            $insertNewNomor=DB::table('md_ba_pemusnahan')->insert($dataNomor); 
            $noBA =DB::table('md_ba_pemusnahan')->where('tahun',date('Y'))->first(); 
            // user doesn't exist
         }
         
         
        $currMonth = date("m");
        $currYear = date("Y");
        $nomor = (int)$noBA->no;
        
        $no = sprintf('%03d', $nomor);

        $concatFormat = 'BA-'.$no . "/" . 'BAPI' . "/" . $this->numberToRomanRepresentation($currMonth) . "/" . $currYear;
        $nomor++;
        DB::table('md_ba_pemusnahan')->update(['no' => $nomor]);
        return  $concatFormat;

    }
	function numberToRomanRepresentation($number)
        {
            $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
            $returnValue = '';
            while ($number > 0) {
                foreach ($map as $roman => $int) {
                    if ($number >= $int) {
                        $number -= $int;
                        $returnValue .= $roman;
                        break;
                    }
                }
            }
            return $returnValue;
        }
}
