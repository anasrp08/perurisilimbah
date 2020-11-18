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


class PenyimpananLimbahController extends Controller
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
            $queryData = DB::table('tr_statusmutasi')
                ->join('md_namalimbah', 'tr_statusmutasi.idlimbah', '=', 'md_namalimbah.id')
                ->join('tr_headermutasi', 'tr_statusmutasi.idmutasi', '=', 'tr_headermutasi.id')
                ->join('md_statusmutasi', 'tr_statusmutasi.idstatus', '=', 'md_statusmutasi.id')
                // ->join('tr_detailmutasi', 'tr_statusmutasi.idmutasi', '=', 'tr_detailmutasi.idmutasi')
                ->join('md_penghasillimbah', 'tr_statusmutasi.idasallimbah', '=', 'md_penghasillimbah.id')
                ->join('md_satuan', 'tr_statusmutasi.idsatuan', '=', 'md_satuan.id')
                ->select(
                    'tr_statusmutasi.*',
                    'md_namalimbah.namalimbah',
                    'md_namalimbah.jenislimbah',
                    'tr_headermutasi.id_transaksi',
                    'md_namalimbah.fisik',
                    'md_namalimbah.tipelimbah',
                    'md_penghasillimbah.seksi',
                    'md_statusmutasi.keterangan',
                    'md_satuan.satuan'
                )
                ->where('tr_statusmutasi.idstatus', 2)
                ->orderBy('tr_statusmutasi.tgl', 'asc');

            // if(!empty($request->tglinput)){

            //     $splitDate2=explode(" - ",$request->tglinput);
            //     $queryData->whereBetween('tr_mutasilimbah.tgl',array(  AppHelper::convertDateYmd($splitDate2[0]),  AppHelper::convertDateYmd($splitDate2[1])));

            // } 

            $queryData = $queryData->get();
            return datatables()->of($queryData)

                ->addIndexColumn()
                // ->addColumn('action', 'action_butt_pemohon')
                // ->rawColumns(['action'])

                ->make(true);
        }
        return view('penyimpanan.list', []);
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
        $np=DB::table('tbl_np')->get();
        
        return view('penyimpanan.list', [
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
    public static function toTPSCategory($row)
    {

        $category = [];
        switch ($row['tipelimbah']) {
            case 'Abu':
                $dataJB = DB::table('tr_packing')->where('tipelimbah', 'Abu')->latest('no_packing')->first();
                $dataTPS = DB::table('md_tps')->where('tipelimbah', 'Abu')->first();
                if ($dataJB == null) {
                    $nopack=1;
                } else {
                    $nopack = $dataJB->no_packing;
                    $nopack++;
                }

                array_push($category, $nopack, 'Abu - ' . $nopack, $dataTPS->id);

                break;
            case 'Sludge':

                $dataJB = DB::table('tr_packing')->where('tipelimbah', 'Sludge')->latest('no_packing')->first();
                $dataTPS = DB::table('md_tps')->where('tipelimbah', 'Sludge')->first();
                if ($dataJB == null) {
                    $nopack=1;
                } else {
                    $nopack = $dataJB->no_packing;
                    $nopack+1;
                }
                array_push($category, $nopack + 1, 'Sludge - ' . $nopack, $dataTPS->id);
                break;
            case 'Sampah Kontaminasi':
                $dataJB = DB::table('tr_packing')->where('tipelimbah', 'Sampah Kontaminasi')->latest('no_packing')->first();
                $dataTPS = DB::table('md_tps')->where('tipelimbah', 'Sampah Kontaminasi')->first();
                if ($dataJB == null) {
                    $nopack=1;
                } else {
                    $nopack = $dataJB->no_packing;
                    $nopack+1;
                }
                array_push($category, $nopack, 'SK - ' . $nopack, $dataTPS->id);
                break;
            case 'Kaleng':
                $dataJB = DB::table('tr_packing')->where('tipelimbah', 'Kaleng')->latest('no_packing')->first();
                $dataTPS = DB::table('md_tps')->where('tipelimbah', 'Kaleng')->first();
                if ($dataJB == null) {
                    $nopack=1;
                } else {
                    $nopack = $dataJB->no_packing;
                    $nopack++;
                }
                array_push($category, $nopack, 'Kaleng - ' . $nopack, $dataTPS->id);
                break;
            case 'Drum':
                $dataJB = DB::table('tr_packing')->where('tipelimbah', 'Drum')->latest('no_packing')->first();
                $dataTPS = DB::table('md_tps')->where('tipelimbah', 'Drum')->first();
                if ($dataJB == null) {
                    $nopack=1;
                } else {
                    $nopack = $dataJB->no_packing;
                    $nopack++;
                }

                array_push($category, $nopack, 'Drum - ' . $nopack, $dataTPS->id);
                break;


            default:
                $dataJB = DB::table('tr_packing')->where('tipelimbah', 'Limbah Cair')->latest('no_packing')->first();
                $dataTPS = DB::table('md_tps')->where('tipelimbah', 'Limbah Cair')->first();
                // dd(count($dataJB));
                if ($dataJB == null) {
                    $nopack=1;
                } else {
                    $nopack = $dataJB->no_packing;
                    $nopack++;
                }

                array_push($category, $nopack, 'Cair - ' . $nopack, $dataTPS->id);
                // dd($category);

                break;
        }
        return $category;
    }
    public function updatepack(Request $request)
    {
        $username=AuthHelper::getAuthUser()[0]->email;
        $getRequest = json_decode($request->getContent(), true);

        $dataRequest = $getRequest['Order'];

        $countDataReq = count($dataRequest);
        // dd($dataRequest);
        $error = null;
        $dataDetail = null;
        $nopack = null; 
        $nopackcair = null;  
        $first = true;
        $dateKadaluarsa=null;
        try {
            foreach ($dataRequest as $row) {
                if($first){
                    $dateKadaluarsa=date('Y-m-d', strtotime("+ 90 day",strtotime($row['tgl'])));
                    // dd($dateKadaluarsa);
                    $first=false;
                }
                if ($row['fisik'] == 'Padat') {
                    if($nopack==null){
                        $nopack = $this->toTPSCategory($row);
                    }else{
                        $nopack;
                    }
                    
                    $dataPacking = array(
                        'id_transaksi'      =>  $row['id_transaksi'],
                        'no_packing'            =>  $nopack[0],
                        'kode_pack'            => $nopack[1],
                        'idmutasi'            => $row['idmutasi'],
                        'idlimbah'            => $row['idlimbah'],
                        'idtps'            => $nopack[2],
                        'tipelimbah'            => $row['tipelimbah'],
                        'idstatus'            => $row['idstatus'],
                        'kadaluarsa'            => $dateKadaluarsa,
                        'created_at'            => date('Y-m-d'),
                        'np'                   =>$row['np'],
                        'created_by'            =>$username, 
                    );
                    $dataDetail = array(
                        'id_transaksi'      =>  $row['id_transaksi'],
                        'idmutasi'            => $row['idmutasi'],
                        'idlimbah'            => $row['idlimbah'],
                        'idjenislimbah'            => $row['idjenislimbah'],
                        'idstatus'            => $row['idstatus'],
                        'idasallimbah'            => $row['idasallimbah'],
                        'idtps'            => $nopack[2],
                        'tgl'            => $row['tgl'],
                        'jumlah'            => $row['jumlah'],
                        'limbah3r'            => $row['limbah3r'],
                        'created_at'        => date('Y-m-d'),
                        'np'                   =>$row['np'],
                        'created_by'            =>$username,
    
                    );
                    $dataStatus = array(
                        'id_transaksi'      =>  $row['id_transaksi'],
                        'idstatus'            =>  $row['idstatus'],
                        'updated_at'        => date('Y-m-d'),
                        'idtps' => $nopack[2],
                        'changed_by'            =>$username,
                        'np'                   =>$row['np'],

                    );
                    $dataTPS = array('idtps' => $nopack[2]);
                    UpdtSaldoHelper::updateTambahSaldoTPS($nopack[2], $row['jumlah']);
                    // $nopack = $this->toTPSCategory($row);
                } else {
                    if($nopackcair==null){
                        $nopackcair = $this->toTPSCategory($row);
                    }else{
                        $nopackcair;
                    }
                    $dataPacking = array(
                        'id_transaksi'      =>  $row['id_transaksi'],
                        'no_packing'            =>  $nopackcair[0],
                        'kode_pack'            => $nopackcair[1],
                        'idmutasi'            => $row['idmutasi'],
                        'idlimbah'            => $row['idlimbah'],
                        'idtps'            => $nopackcair[2],
                        'tipelimbah'            => $row['tipelimbah'],
                        'idstatus'            => $row['idstatus'],
                        'kadaluarsa'            => date('Y-m-d', strtotime("+ 90 day")),
                        'created_at'            => date('Y-m-d'),
                        'created_by'            =>$username,
                        'np'                   =>$row['np'],
                    );
                    $dataDetail = array(
                        'id_transaksi'      =>  $row['id_transaksi'],
                        'idmutasi'            => $row['idmutasi'],
                        'idlimbah'            => $row['idlimbah'],
                        'idjenislimbah'            => $row['idjenislimbah'],
                        'idstatus'            => $row['idstatus'],
                        'idasallimbah'            => $row['idasallimbah'],
                        'idtps'            => $nopackcair[2],
                        'tgl'            => $row['tgl'],
                        'jumlah'            => $row['jumlah'],
                        'limbah3r'            => $row['limbah3r'],
                        'created_at'        => date('Y-m-d'),
                        'created_by'            =>$username,
                        'np'                   =>$row['np'],

    
                    );
                    $dataStatus = array(
                        'id_transaksi'          =>  $row['id_transaksi'],
                        'idstatus'            =>  $row['idstatus'],
                        'updated_at'            => date('Y-m-d'),
                        'idtps'                 => $nopackcair[2],
                        'np'                   =>$row['np'],
                        'changed_by'            =>$username,
                    );
                    $dataTPS = array('idtps' => $nopackcair[2]);
                    UpdtSaldoHelper::updateTambahSaldoTPS($nopackcair[2], $row['jumlah']);
                    
                }
                // $dataDetail = array(
                //     'idmutasi'            => $row['idmutasi'],
                //     'idlimbah'            => $row['idlimbah'],
                //     'idjenislimbah'            => $row['idjenislimbah'],
                //     'idstatus'            => $row['idstatus'],
                //     'idasallimbah'            => $row['idasallimbah'],
                //     'idtps'            => $nopack[2],
                //     'tgl'            => $row['tgl'],
                //     'jumlah'            => $row['jumlah'],
                //     'limbah3r'            => $row['limbah3r'],
                //     'created_at'        => date('Y-m-d')

                // );
                // $dataStatus = array(
                //     'idstatus'            =>  $row['idstatus'],
                //     'updated_at'        => date('Y-m-d'),
                //     'idtps' => $nopack[2]
                // );
                // $dataPacking = array(
                //     'no_packing'            =>  $nopack[0],
                //     'kode_pack'            => $nopack[1],
                //     'idmutasi'            => $row['idmutasi'],
                //     'idlimbah'            => $row['idlimbah'],
                //     'idtps'            => $nopack[2],
                //     'tipelimbah'            => $row['tipelimbah'],
                //     'idstatus'            => $row['idstatus'],
                //     'kadaluarsa'            => date('Y-m-d', strtotime("+ 90 day")),
                //     'created_at'            => date('Y-m-d'),
                // );
                // $dataTPS = array('idtps' => $nopack[2]);

                


                $insertDetail = DB::table('tr_detailmutasi')->insert($dataDetail, true);
                $insertStatus = DB::table('tr_statusmutasi')->where('idmutasi', $row['idmutasi'])->update($dataStatus, true);
                $insertPacking = DB::table('tr_packing')->insert($dataPacking);
                $updHeader = DB::table('tr_headermutasi')->where('id', $row['idmutasi'])->update($dataTPS);
                // $updHeader = DB::table('tr_headermutasi')->where('id', $row['idmutasi'])->update($dataTPS);
                // UpdtSaldoHelper::updateTambahSaldoNamaLimbah($row['idlimbah'],$row['jumlah']);
                
            }
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
    }
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
        //
        
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
}
