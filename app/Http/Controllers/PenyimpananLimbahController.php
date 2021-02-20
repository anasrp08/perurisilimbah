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
        if (request()->ajax()) {
            $queryData = DB::table('tr_headermutasi')
                ->join('md_namalimbah', 'tr_headermutasi.idlimbah', '=', 'md_namalimbah.id')

                ->join('md_statusmutasi', 'tr_headermutasi.idstatus', '=', 'md_statusmutasi.id')

                ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
                ->join('md_satuan', 'tr_headermutasi.idsatuan', '=', 'md_satuan.id')
                ->select(
                    'tr_headermutasi.*',
                    'md_namalimbah.namalimbah',
                    'md_namalimbah.jenislimbah',
                    'md_namalimbah.satuan',
                    'md_namalimbah.max_packing',
                    'md_namalimbah.packing_besar',
                    'md_namalimbah.tps',
                    'md_namalimbah.fisik',
                    'md_namalimbah.treatmen_limbah',
                    'md_penghasillimbah.seksi',
                    'md_statusmutasi.keterangan',
                    'md_satuan.satuan'
                )
                ->where('tr_headermutasi.idstatus', 2)
                ->orderBy('tr_headermutasi.tgl', 'asc');

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



    public function viewIndex()
    {
        $np = DB::table('tbl_np')->get();

        return view('penyimpanan.list', [
            'np' => $np

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
    // public static function toTPSCategory($row)
    // {

    //     $category = [];
    //     switch ($row['treatmen_limbah']) {
    //         case 'Abu':
    //             $dataJB = DB::table('tr_packing')->where('treatmen_limbah', 'Abu')->latest('no_packing')->first();
    //             $dataTPS = DB::table('md_tps')->where('treatmen_limbah', 'Abu')->first();
    //             if ($dataJB == null) {
    //                 $nopack = 1;
    //             } else {
    //                 $nopack = $dataJB->no_packing;
    //                 $nopack++;
    //             }

    //             array_push($category, $nopack, 'Abu - ' . $nopack, $dataTPS->id);

    //             break;
    //         case 'Sludge':

    //             $dataJB = DB::table('tr_packing')->where('treatmen_limbah', 'Sludge')->latest('no_packing')->first();
    //             $dataTPS = DB::table('md_tps')->where('treatmen_limbah', 'Sludge')->first();
    //             if ($dataJB == null) {
    //                 $nopack = 1;
    //             } else {
    //                 $nopack = $dataJB->no_packing;
    //                 $nopack + 1;
    //             }
    //             array_push($category, $nopack + 1, 'Sludge - ' . $nopack, $dataTPS->id);
    //             break;
    //         case 'Sampah Kontaminasi':
    //             $dataJB = DB::table('tr_packing')->where('treatmen_limbah', 'Sampah Kontaminasi')->latest('no_packing')->first();
    //             $dataTPS = DB::table('md_tps')->where('treatmen_limbah', 'Sampah Kontaminasi')->first();
    //             if ($dataJB == null) {
    //                 $nopack = 1;
    //             } else {
    //                 $nopack = $dataJB->no_packing;
    //                 $nopack + 1;
    //             }
    //             array_push($category, $nopack, 'SK - ' . $nopack, $dataTPS->id);
    //             break;
    //         case 'Kaleng':
    //             $dataJB = DB::table('tr_packing')->where('treatmen_limbah', 'Kaleng')->latest('no_packing')->first();
    //             $dataTPS = DB::table('md_tps')->where('treatmen_limbah', 'Kaleng')->first();
    //             if ($dataJB == null) {
    //                 $nopack = 1;
    //             } else {
    //                 $nopack = $dataJB->no_packing;
    //                 $nopack++;
    //             }
    //             array_push($category, $nopack, 'Kaleng - ' . $nopack, $dataTPS->id);
    //             break;
    //         case 'Drum':
    //             $dataJB = DB::table('tr_packing')->where('treatmen_limbah', 'Drum')->latest('no_packing')->first();
    //             $dataTPS = DB::table('md_tps')->where('treatmen_limbah', 'Drum')->first();
    //             if ($dataJB == null) {
    //                 $nopack = 1;
    //             } else {
    //                 $nopack = $dataJB->no_packing;
    //                 $nopack++;
    //             }

    //             array_push($category, $nopack, 'Drum - ' . $nopack, $dataTPS->id);
    //             break;


    //         default:
    //             $dataJB = DB::table('tr_packing')->where('treatmen_limbah', 'Limbah Cair')->latest('no_packing')->first();
    //             $dataTPS = DB::table('md_tps')->where('treatmen_limbah', 'Limbah Cair')->first();
    //             // dd(count($dataJB));
    //             if ($dataJB == null) {
    //                 $nopack = 1;
    //             } else {
    //                 $nopack = $dataJB->no_packing;
    //                 $nopack++;
    //             }

    //             array_push($category, $nopack, 'Cair - ' . $nopack, $dataTPS->id);
    //             // dd($category);

    //             break;
    //     }
    //     return $category;
    // }

    public static function toPackingTPS($row)
    {

        $category = [];
        $nopack = 0;
        // tinggal packing per material limbah
        // dd($row);
        $dataPacking = DB::table('tr_packing')
            ->where('packing_besar', $row['packing_besar'])
            ->latest('no_packing')->first();
        // dd($dataPacking);

        // cari cara untuk max packing dan mengurangi TPS dari packing besar
        // $dataTPS = DB::table('md_tps')->where('id', $row['tps'])->first();
        $dataParamPack = null;
        $username = AuthHelper::getAuthUser()[0]->email;
        $dateKadaluarsa = date('Y-m-d', strtotime("+ 90 day", strtotime($row['tgl'])));
        $max_pack = $row['max_packing'];
        $iterationPacking = 0;
        $modValue = 0;
        $isHalfValue = 0;
        if ($row['idlimbah'] == 1 || $row['idlimbah'] == 2 || $row['idlimbah'] == 3) {
            $dataParamPack = array(
                'id_transaksi'          => $row['id_transaksi'],
                'no_packing'            => 0,
                'kode_pack'             => $row['packing_besar'] . ' - ' . '0',
                'idmutasi'              => $row['idheader'],
                'idlimbah'              => $row['idlimbah'],
                'idtps'                 => $row['tps'],
                'jumlah'                => $max_pack,
                'packing_besar'         => $row['packing_besar'],
                'idstatus'              => $row['idstatus'],
                'kadaluarsa'            => $dateKadaluarsa,
                'created_at'            => date('Y-m-d'),
                'np_packer'             => $row['np_packer'],
                'created_by'            => $username,
            );
            $insertPacking = DB::table('tr_packing')->insert($dataParamPack);
        } else {


            $modValue = (int)$row['jumlah'] % (int)$max_pack;
            //jumlah dibagi per max pack
            $divideValue = (int)$row['jumlah'] / (int)$max_pack;
            //pembagian di bulatkan
            $iterationPacking = floor($divideValue);
            //mencari setengah nilai max packing untuk dikategorikan no packing baru
            $halfMaxPacking = (int)$row['max_packing'] / 2;
            //pembulatan nilai
            $isHalfValue = round($halfMaxPacking, 0, PHP_ROUND_HALF_DOWN);
            //percabangan jika tidak ada data no packing terakhir di database
            if ($modValue > 0) {

                if ($dataPacking == null) {
                    for ($i = 1; $i <= $iterationPacking; $i++) {
                        $dataParamPack = array(
                            'id_transaksi'          => $row['id_transaksi'],
                            'no_packing'            => $i,
                            'kode_pack'             => $row['packing_besar'] . ' - ' . $i,
                            'idmutasi'              => $row['idheader'],
                            'idlimbah'              => $row['idlimbah'],
                            'idtps'                 => $row['tps'],
                            'jumlah'                => $max_pack,
                            'packing_besar'         => $row['packing_besar'],
                            'idstatus'              => $row['idstatus'],
                            'kadaluarsa'            => $dateKadaluarsa,
                            'created_at'            => date('Y-m-d'),
                            'np_packer'             => $row['np_packer'],
                            'created_by'            => $username,
                        );
                        $insertPacking = DB::table('tr_packing')->insert($dataParamPack);
                    }
                    //tambah iterasi karena ada sisa hasil bagi 
                    $dataParamPack = array(
                        'id_transaksi'          => $row['id_transaksi'],
                        'no_packing'            => $i,
                        'kode_pack'             => $row['packing_besar'] . ' - ' . $i,
                        'idmutasi'              => $row['idheader'],
                        'idlimbah'              => $row['idlimbah'],
                        'idtps'                 => $row['tps'],
                        'jumlah'                => $modValue,
                        'packing_besar'         => $row['packing_besar'],
                        'idstatus'              => $row['idstatus'],
                        'kadaluarsa'            => $dateKadaluarsa,
                        'created_at'            => date('Y-m-d'),
                        'np_packer'             => $row['np_packer'],
                        'created_by'            => $username,
                    );
                    $insertPacking = DB::table('tr_packing')->insert($dataParamPack);
                } else {
                    //percabangan jika ada data no packing terakhir di database
                    $lastNopacking = $dataPacking->no_packing + 1;
                    $addIterasi = 0;
                    //cek jika iterasi packing lebih besar dari no packing terakhir
                    if ($iterationPacking >  $lastNopacking) {
                        $addIterasi = $iterationPacking - $lastNopacking;
                    } else if ($iterationPacking <  $lastNopacking) {

                        $addIterasi = $lastNopacking - $iterationPacking;
                    }

                    $i = 0;
                    for ($i = $lastNopacking; $i < ($lastNopacking + $iterationPacking); $i++) {
                        $dataParamPack = array(
                            'id_transaksi'          => $row['id_transaksi'],
                            'no_packing'            => $i,
                            'kode_pack'             => $row['packing_besar'] . ' - ' . $i,
                            'idmutasi'              => $row['idheader'],
                            'idlimbah'              => $row['idlimbah'],
                            'idtps'                 => $row['tps'],
                            'jumlah'                => $max_pack,
                            'packing_besar'         => $row['packing_besar'],
                            'idstatus'              => $row['idstatus'],
                            'kadaluarsa'            => $dateKadaluarsa,
                            'created_at'            => date('Y-m-d'),
                            'np_packer'             => $row['np_packer'],
                            'created_by'            => $username,
                        );
                        $insertPacking = DB::table('tr_packing')->insert($dataParamPack);
                    }
                    //tambah iterasi karena ada sisa hasil bagi 

                    $dataParamPack = array(
                        'id_transaksi'          => $row['id_transaksi'],
                        'no_packing'            => $i,
                        'kode_pack'             => $row['packing_besar'] . ' - ' . $i,
                        'idmutasi'              => $row['idheader'],
                        'idlimbah'              => $row['idlimbah'],
                        'idtps'                 => $row['tps'],
                        'jumlah'                => $modValue,
                        'packing_besar'         => $row['packing_besar'],
                        'idstatus'              => $row['idstatus'],
                        'kadaluarsa'            => $dateKadaluarsa,
                        'created_at'            => date('Y-m-d'),
                        'np_packer'             => $row['np_packer'],
                        'created_by'            => $username,
                    );
                    $insertPacking = DB::table('tr_packing')->insert($dataParamPack);
                }
            } else {
                if ($dataPacking == null) {
                    for ($i = 1; $i <= $iterationPacking; $i++) {
                        $dataParamPack = array(
                            'id_transaksi'          => $row['id_transaksi'],
                            'no_packing'            => $i,
                            'kode_pack'             => $row['packing_besar'] . ' - ' . $i,
                            'idmutasi'              => $row['idheader'],
                            'idlimbah'              => $row['idlimbah'],
                            'idtps'                 => $row['tps'],
                            'jumlah'                => $max_pack,
                            'packing_besar'         => $row['packing_besar'],
                            'idstatus'              => $row['idstatus'],
                            'kadaluarsa'            => $dateKadaluarsa,
                            'created_at'            => date('Y-m-d'),
                            'np_packer'             => $row['np_packer'],
                            'created_by'            => $username,
                        );
                        $insertPacking = DB::table('tr_packing')->insert($dataParamPack);
                    }
                    // //tambah iterasi karena ada sisa hasil bagi 
                    // $dataParamPack = array(
                    //     'id_transaksi'          => $row['id_transaksi'],
                    //     'no_packing'            => $i,
                    //     'kode_pack'             => $row['packing_besar'] . ' - ' . ($i+1),
                    //     'idmutasi'              => $row['idheader'],
                    //     'idlimbah'              => $row['idlimbah'],
                    //     'idtps'                 => $row['tps'],
                    //     'jumlah'                => $modValue,
                    //     'packing_besar'         => $row['packing_besar'],
                    //     'idstatus'              => $row['idstatus'],
                    //     'kadaluarsa'            => $dateKadaluarsa,
                    //     'created_at'            => date('Y-m-d'),
                    //     'np_packer'             => $row['np_packer'],
                    //     'created_by'            => $username,
                    // );
                    // $insertPacking = DB::table('tr_packing')->insert($dataParamPack);
                } else {
                    //percabangan jika ada data no packing terakhir di database
                    $lastNopacking = $dataPacking->no_packing + 1;
                    $addIterasi = 0;
                    //cek jika iterasi packing lebih besar dari no packing terakhir
                    if ($iterationPacking >  $lastNopacking) {
                        $addIterasi = $iterationPacking - $lastNopacking;
                    } else if ($iterationPacking <  $lastNopacking) {

                        $addIterasi = $lastNopacking - $iterationPacking;
                    }

                    $i = 0;
                    for ($i = $lastNopacking; $i < ($lastNopacking + $iterationPacking); $i++) {
                        $dataParamPack = array(
                            'id_transaksi'          => $row['id_transaksi'],
                            'no_packing'            => $i,
                            'kode_pack'             => $row['packing_besar'] . ' - ' . $i,
                            'idmutasi'              => $row['idheader'],
                            'idlimbah'              => $row['idlimbah'],
                            'idtps'                 => $row['tps'],
                            'jumlah'                => $max_pack,
                            'packing_besar'         => $row['packing_besar'],
                            'idstatus'              => $row['idstatus'],
                            'kadaluarsa'            => $dateKadaluarsa,
                            'created_at'            => date('Y-m-d'),
                            'np_packer'             => $row['np_packer'],
                            'created_by'            => $username,
                        );
                        $insertPacking = DB::table('tr_packing')->insert($dataParamPack);
                    }
                    //tambah iterasi karena ada sisa hasil bagi 

                    //    $dataParamPack = array(
                    //        'id_transaksi'          => $row['id_transaksi'],
                    //        'no_packing'            => $i,
                    //        'kode_pack'             => $row['packing_besar'] . ' - ' . $i,
                    //        'idmutasi'              => $row['idheader'],
                    //        'idlimbah'              => $row['idlimbah'],
                    //        'idtps'                 => $row['tps'],
                    //        'jumlah'                => $modValue,
                    //        'packing_besar'         => $row['packing_besar'],
                    //        'idstatus'              => $row['idstatus'],
                    //        'kadaluarsa'            => $dateKadaluarsa,
                    //        'created_at'            => date('Y-m-d'),
                    //        'np_packer'             => $row['np_packer'],
                    //        'created_by'            => $username,
                    //    );
                    //    $insertPacking = DB::table('tr_packing')->insert($dataParamPack);
                }
            }
        }
    }
    public function updatepack(Request $request)
    {
        $username = AuthHelper::getAuthUser()[0]->email;

        $getRequest = json_decode($request->getContent(), true);

        $dataRequest = $getRequest['Order'];

        $countDataReq = count($dataRequest);
        $error = null;
        $dataDetail = null;
        $resultPack = null;
        $first = true;
        $dateKadaluarsa = null;
        $jmlh_pack =null;
        try {
            foreach ($dataRequest as $row) {
                if ($first) {
                    $dateKadaluarsa = date('Y-m-d', strtotime("+ 90 day", strtotime($row['tgl'])));
                    // dd($dateKadaluarsa);
                    $first = false;
                }
                // if ($row['fisik'] == 'Padat') {
                if ($resultPack == null) {
                    $resultPack = $this->toPackingTPS($row);
                } else {
                    $resultPack;
                }
                if ($row['idlimbah'] == 1 || $row['idlimbah'] == 2 || $row['idlimbah'] == 3) {
                    $jmlh_pack =0;
                }else{
                    $jmlh_pack = UpdtSaldoHelper::convertJumlahToPack($row['idlimbah'], $row['jumlah']);
                }
              
                $dataDetail = array(
                    'id_transaksi'      =>  $row['id_transaksi'],
                    'idmutasi'            => $row['idheader'],
                    'idlimbah'            => $row['idlimbah'],
                    'idjenislimbah'            => $row['idjenislimbah'],
                    'idstatus'            => $row['idstatus'],
                    'idasallimbah'            => $row['idasallimbah'],
                    'idtps'                 => $row['tps'],
                    'tgl'            => $row['tgl'],
                    'jumlah'            => $row['jumlah'],
                    'pack_in'            => $row['pack_in'],
                    'limbah3r'            => $row['limbah3r'],
                    'created_at'        => date('Y-m-d'),
                    'np_packer'                   => $row['np_packer'],
                    'created_by'            => $username,

                );
                $dataHeader = array(
                    // 'id_transaksi'      =>  $row['id_transaksi'],
                    'idstatus'          =>  $row['idstatus'],
                    'updated_at'        => date('Y-m-d'),
                    'idtps'             => $row['tps'],
                    'changed_by'            => $username,
                    'np_packer'                   => $row['np_packer'],

                );
                $dataTPS = array('idtps'  => $row['tps']);

                // $nopack = $this->toTPSCategory($row);

                $insertDetail = DB::table('tr_detailmutasi')->insert($dataDetail, true);
                // $insertStatus = DB::table('tr_headermutasi')->where('id', $row['idheader'])->update($dataStatus, true);

                $updHeader = DB::table('tr_headermutasi')->where('id', $row['idheader'])->update($dataHeader);
                // UpdtSaldoHelper::updateTambahSaldoTPS($row['tps'], $row['jumlah']);
                UpdtSaldoHelper::updateTambahPackTPS($row['tps'], $row['pack_in']);
                // $updHeader = DB::table('tr_headermutasi')->where('id', $row['idmutasi'])->update($dataTPS);
                // UpdtSaldoHelper::updateTambahSaldoNamaLimbah($row['idlimbah'], $row['jumlah']);
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
}
