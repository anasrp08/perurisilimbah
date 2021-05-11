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
use App\Helpers\UpdtSaldoHelper;
use App\Helpers\AuthHelper;


use Redirect;
use Validator;
use Response;
use DB;
// use File;
use PDF;


class PemohonController extends Controller
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
                ->join('md_satuan', 'tr_headermutasi.idsatuan', '=', 'md_satuan.id')
                // ->join('tr_detailmutasi', 'tr_headermutasi.id', '=', 'tr_detailmutasi.idmutasi')
                ->join('md_penghasillimbah', 'tr_headermutasi.idasallimbah', '=', 'md_penghasillimbah.id')
                ->select(
                    'tr_headermutasi.*',
                    'tr_headermutasi.id as idheader',
                    'md_namalimbah.namalimbah',
                    'md_namalimbah.jenislimbah',
                    'md_namalimbah.is_lgsg_proses',
                    'md_penghasillimbah.seksi',
                    'md_statusmutasi.keterangan as status',
                    'md_satuan.satuan'
                )
                ->orderBy('tr_headermutasi.idstatus', 'asc')
                ->orderBy('tr_headermutasi.tgl', 'desc');

            // if (AuthHelper::getAuthUser()[0]->display_name == 'Pengawas') {
            //     $queryData->orWhere('tr_headermutasi.validated_by', null)->where('tr_detailmutasi.idstatus', 9);
            // }
            if ($request->idasallimbah == 'admin' || $request->idasallimbah == 'operator') {
                $queryData = $queryData
                    ->where('tr_headermutasi.np_penerima', null)
                    ->whereIn('tr_headermutasi.idstatus', ['1', '11']);
            } else if ($request->idasallimbah == 'pengawas') {

                $queryData = $queryData
                    // ->orWhere('tr_headermutasi.validated_by','')
                    ->where('tr_headermutasi.idstatus', '!=', '11')
                    ->where('tr_headermutasi.validated_by', null)->distinct('id');
            } else {
                $queryData = $queryData
                    ->where('tr_headermutasi.idasallimbah', $request->idasallimbah)
                    ->where('tr_headermutasi.np_penerima', null)
                    ->whereIn('tr_headermutasi.idstatus', ['1', '11']);
            }

            if (!empty($request->f_date)) {

                $splitDate2 = explode(" - ", $request->f_date);
                $queryData->whereBetween('tr_headermutasi.tgl', array(AppHelper::convertDateYmd($splitDate2[0]),  AppHelper::convertDateYmd($splitDate2[1])));
            }
            if (!empty($request->namalimbah)) {

                $queryData->where('tr_headermutasi.idlimbah', $request->namalimbah);
            }
            if (!empty($request->limbahasal)) {

                $queryData->where('tr_headermutasi.idasallimbah', $request->limbahasal);
            }
            if (!empty($request->jenislimbah)) {

                $queryData->where('tr_headermutasi.idjenislimbah', $request->jenislimbah);
            }

            $queryData = $queryData->get();
            return datatables()->of($queryData)

                ->addIndexColumn()
                ->addColumn('action', 'action_butt_pemohon')
                ->rawColumns(['action'])

                ->make(true);
        }
        return view('pemohon.list', []);
    }
    public function viewEntri()
    {
        return view('pemohon.create', QueryHelper::getDropDown());
    }

    public function viewIndex()
    {
        $vendor = DB::table('md_vendorlimbah')->groupBy('namavendor')->get();
        $jenisLimbah = DB::table('md_jenislimbah')->get();
        $namaLimbah = DB::table('md_namalimbah')->get();
        $tipeLimbah = DB::table('md_tipelimbah')->get();
        $penghasilLimbah = DB::table('md_penghasillimbah')->get();
        $satuanLimbah = DB::table('md_satuan')->orderBy('id', 'desc')->get();
        $tpsLimbah = DB::table('md_tps')->get();
        $np = DB::table('tbl_np')->get();
        $status = DB::table('md_statusmutasi')->get();

        return view(
            'pemohon.list',
            [
                'np' => $np,
                'vendor' => $vendor,
                'jenisLimbah' => $jenisLimbah,
                'namaLimbah' => $namaLimbah,
                'tipeLimbah' => $tipeLimbah,
                'satuanLimbah' => $satuanLimbah,
                'tpsLimbah' => $tpsLimbah,
                'penghasilLimbah' => $penghasilLimbah,
                'status' => $status,
                'username' => AuthHelper::getAuthUser()[0]
            ]

        );
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
    public function numberToRomanRepresentation($number)
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
    public function noSurat($idAsalLimbah)
    {
        $noSuratUnitKerja = DB::table('md_nosurat')->where('unit_kerja', $idAsalLimbah)->first();
        // $unitKerja = $noSuratUnitKerja->unit_kerja;
        $currMonth = date("m");
        $currYear = date("Y");
        $nomor = (int)$noSuratUnitKerja->no;

        $no = sprintf('%03d', $nomor);

        $concatFormat = $no . "/" . $idAsalLimbah . "/" . $this->numberToRomanRepresentation($currMonth) . "/" . $currYear;
        $nomor++;
        DB::table('md_nosurat')->where('unit_kerja', $idAsalLimbah)->update(['no' => $nomor]);
        return  $concatFormat;
    }
    public function store(Request $request)
    {

        $username = AuthHelper::getAuthUser()[0]->email;
        $getRequest = json_decode($request->getContent(), true);
        $dataRequest = $getRequest['Data'];
        $requestHeader = $getRequest['Header'];

        $countDataReq = count($dataRequest);
        $error = null;
        $getLastTransaksi = DB::table('tr_headermutasi')->latest('id')->first();

        $lastTransactionNo = null;
        if ($getLastTransaksi == null) {
            $lastTransactionNo = 1;
        } else {
            $lastTransactionNo = (int)$getLastTransaksi->id_transaksi;
            $lastTransactionNo++;
        }

        $idAsalLimbah = $dataRequest[0]['asal_limbah'];

        $jmlh_pack = null;
        foreach ($dataRequest as $row) {

            $jmlh_pack = UpdtSaldoHelper::convertJumlahToPack($row['nama_limbah'], $row['jmlhlimbah']);
            $dataHeader = array(
                'id_transaksi'      =>  $lastTransactionNo,
                'no_surat'          =>  '',
                'idlimbah'            =>  $row['nama_limbah'],
                'tgl'                =>  AppHelper::convertDate($row['tgl']),
                'idasallimbah'        =>  $row['asal_limbah'],
                'idjenislimbah'     =>  $row['jenis_limbah'],
                'idstatus'            =>  1,
                'jumlah_in'            =>  $row['jmlhlimbah'],
                'pack_in'              =>  $jmlh_pack,
                'idsatuan'            =>  $row['satuan'],
                'limbah3r'            =>  $row['limbah_3r'],
                'keterangan'            =>  $row['keterangan'],
                'np_pemohon'                   => $row['np_pemohon'],
                'maksud'                   => $requestHeader,
                'created_by'            => $username,
                'created_at'            => date('Y-m-d')

            );
            $insertHeader = DB::table('tr_headermutasi')->insertGetId($dataHeader, true);

            $dataDetail = array(
                'id_transaksi'      =>  $lastTransactionNo,
                'idmutasi'      => $insertHeader,
                'idlimbah'        =>  $row['nama_limbah'],
                'idstatus'            =>  1,
                'jumlah'            =>  $row['jmlhlimbah'],
                'pack'              =>  $jmlh_pack,
                'idsatuan'            =>  $row['satuan'],
                'created_at'        => date('Y-m-d'),
                'tgl'                =>  AppHelper::convertDate($row['tgl']),
                'idasallimbah'        =>  $row['asal_limbah'],
                'np_pemohon'                   => $row['np_pemohon'],
                'idjenislimbah'       => $row['jenis_limbah'],
                'limbah3r'            =>  $row['limbah_3r'],
                'created_by'            => $username,
            );
            $insertDetail = DB::table('tr_detailmutasi')->insert($dataDetail);
        }
        try {
            // UpdtSaldoHelper::updateSaldoNamaLimbah($row['nama_limbah'],$row['jmlhlimbah']);
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
    public function updatevalid(Request $request)
    {

        $username = AuthHelper::getAuthUser()[0]->email;
        $getRequest = json_decode($request->getContent(), true);
        $dataRequest = $getRequest['Order'];
        $countDataReq = count($dataRequest);
        $error = null;
        $dataStatus = null;
        $dataDetail = null;
        $jmlh_pack = null;
        try {

            foreach ($dataRequest as $row) {

                $jmlh_pack = UpdtSaldoHelper::convertJumlahToPack($row['idlimbah'], $row['jumlah']);

                if ($row['hiddenTransaksi'] == 'validasi') {
                    $dataStatus = array(
                        'validated'        => date('Y-m-d'),
                        'validated_by'        => $row['np'],
                    );

                    $updateHeaderValidasi = DB::table('tr_headermutasi')->where('id', $row['idheader'])->update($dataStatus, true);
                
                } else if ($row['hiddenTransaksi'] == 'terima') {

                    $noSurat = $this->noSurat($row['idasallimbah']);
                    $dataDetail = array(
                        'id_transaksi'      =>  $row['id_transaksi'],
                        'idmutasi'          => $row['idheader'],
                        'idlimbah'          =>  $row['idlimbah'],
                        'tgl'                => $row['tgl'],
                        'idasallimbah'        =>  $row['idasallimbah'],
                        'idjenislimbah'       => $row['idjenislimbah'],
                        'idstatus'            =>  2,
                        'jumlah'            =>  $row['jumlah'],
                        'jmlh_massa'            =>  $row['massa'],
                        'pack'              =>  $jmlh_pack,
                        'np_penerima'           => $row['np'],
                        'idsatuan'            =>  $row['satuan'],
                        'limbah3r'            =>  $row['limbah3r'],
                        'created_at'        => date('Y-m-d'),
                        'created_by'            => $username,

                    );
                    $dataStatus = array(
                        'idstatus'          =>  2,
                        'no_surat'          =>  $noSurat,
                        'jmlh_massa_in'     =>  $row['massa'],
                        'pack_in'           =>  $jmlh_pack,
                        'np_penerima'       =>  $row['np'],
                        'updated_at'        =>  date('Y-m-d'),
                        'changed_by'        =>  $username,
                    );
                    $insertDetail = DB::table('tr_detailmutasi')->insert($dataDetail, true);
                    $updateHeaderValidasi = DB::table('tr_headermutasi')->where('id', $row['idheader'])->update($dataStatus, true);

                    UpdtSaldoHelper::updateTambahSaldoNamaLimbah($row['idlimbah'], $row['jumlah']);
                    UpdtSaldoHelper::updateTambahPackNamaLimbah($row['idlimbah'], $jmlh_pack);

                } else if ($row['hiddenTransaksi'] == 'proses') {

                    $noSurat = $this->noSurat($row['idasallimbah']);
                    $dataHeader = DB::table('tr_headermutasi')->where('id', $row['idheader'])->first();
                    $jmlhIn = (int)$dataHeader->jumlah_in - (int)$row['jumlah'];
                    $jmlhPackIn = (int)$dataHeader->pack_in - (int)$row['pack'];
                    $jmlhOut = (int)$dataHeader->jumlah_out + (int)$row['jumlah'];
                    $jmlhPackOut = (int)$dataHeader->pack_out + (int)$row['pack'];
                    $dataDetail1 = array(
                        'id_transaksi'      =>  $row['id_transaksi'],
                        'idmutasi'          => $row['idheader'],
                        'idlimbah'          =>  $row['idlimbah'],
                        'tgl'                =>  $dataHeader->tgl,
                        'idasallimbah'        =>  $row['idasallimbah'],
                        'idjenislimbah'       => $row['idjenislimbah'],
                        'idstatus'            =>  2,
                        'jumlah'            =>  (int)$row['jumlah'],
                        'pack'            =>  (int)$row['pack'],
                        'np_penerima'           => $row['np_pemroses'],
                        'np_pemroses'           => $row['np_pemroses'],
                        'idsatuan'            =>  $row['idsatuan'],
                        'limbah3r'            =>  $row['limbah3r'],
                        'created_at'        => date('Y-m-d'),
                        // 'keterangan'          => 'proses langsung',
                        'created_by'            => $username,

                    );
                    $dataDetail2 = array(
                        'id_transaksi'      =>  $row['id_transaksi'],
                        'idmutasi'          => $row['idheader'],
                        'idlimbah'          =>  $row['idlimbah'],
                        'tgl'                =>   $row['tglproses'],
                        'idasallimbah'        =>  $row['idasallimbah'],
                        'idjenislimbah'       => $row['idjenislimbah'],
                        'idstatus'            =>  $row['idstatus'],
                        'jumlah'            =>  $jmlhOut,
                        'pack'            =>  $jmlhPackOut,
                        'np_pemroses'           => $row['np_pemroses'],
                        'idsatuan'            =>  $row['idsatuan'],
                        'limbah3r'            =>  $row['limbah3r'],
                        'created_at'        => date('Y-m-d'),
                        'keterangan'          => 'proses langsung',
                        'no_ba_pemusnahan'           => $this->getNoBAPemusnahan(),
                        'created_by'            => $username,

                    );
                    $dataStatus = array(
                        'idstatus'          =>   $row['idstatus'],
                        'no_surat'          => $noSurat,
                        'jumlah_in'            =>  $jmlhIn,
                        'jumlah_out'            =>  $jmlhOut,
                        'pack_in'            =>  $jmlhPackIn,
                        'pack_out'            =>  $jmlhPackOut,
                        'np_penerima'       =>  $row['np_pemroses'],
                        'np_pemroses'       =>  $row['np_pemroses'],
                        'updated_at'        =>  date('Y-m-d'),
                        'changed_by'        =>  $username,
                    );
                    $insertDetail1 = DB::table('tr_detailmutasi')->insert($dataDetail1, true);
                    $insertDetail2 = DB::table('tr_detailmutasi')->insertGetId($dataDetail2, true);

                    $dataValidasi = array(
                        'id_detail'             =>  $insertDetail2,
                        'id_mutasi'             => $row['idmutasi'],
                        'keterangan_proses'     => $row['keterangan_proses'],
                        // 'np_penerima'     => $row['keterangan_proses'],                    
                        'created_at'            => date('Y-m-d'),

                    );

                    $insertValidasi = DB::table('tr_validasi_ba')->insert($dataValidasi);
                    $updateHeaderValidasi = DB::table('tr_headermutasi')->where('id', $row['idheader'])->update($dataStatus, true);
                    // $insertStatus = DB::table('tr_statusmutasi')->where('idmutasi', $row['idmutasi'])->update($dataStatus, true);
                    // UpdtSaldoHelper::updateTambahSaldoNamaLimbah($row['idlimbah'], $row['jumlah']);
                    // UpdtSaldoHelper::updateTambahPackNamaLimbah($row['idlimbah'], $jmlh_pack);
                }
            }
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Disimpan']);
        }
    }
    public function getNoBAPemusnahan()
    {

        $noBA = DB::table('md_ba_pemusnahan')->where('tahun', date('Y'))->first();
        if ($noBA === null) {
            $dataNomor = array(
                'no'         => 1,
                'tahun'        => date('Y')


            );
            $insertNewNomor = DB::table('md_ba_pemusnahan')->insert($dataNomor);
            $noBA = DB::table('md_ba_pemusnahan')->where('tahun', date('Y'))->first();
            // user doesn't exist
        }


        $currMonth = date("m");
        $currYear = date("Y");
        $nomor = (int)$noBA->no;

        $no = sprintf('%03d', $nomor);

        $concatFormat = 'BA-' . $no . "/" . 'BAPI' . "/" . $this->numberToRomanRepresentation($currMonth) . "/" . $currYear;
        $nomor++;
        DB::table('md_ba_pemusnahan')->update(['no' => $nomor]);
        return  $concatFormat;
    }
    public function update(Request $request)
    {
    }
    public function updateTolak(Request $request)
    {
        $dataToBeUpdate = DB::table('tr_headermutasi')->where('id', $request->hidden_id_tolak)->first();
        try {
            $dataHeader = array(
                'alasan_tolak'              => $request->alasan_tolak,
                'np_penolak'                => $request->np_penolak,
                'idstatus'                  => 11,
                'updated_at'                => date('Y-m-d')

            );
            $dataDetail = array(
                'keterangan'                => $request->alasan_tolak,
                'np_penolak'                => $request->np_penolak,
                'idstatus'                  => 11,
                'updated_at'                => date('Y-m-d')

            );
            $updateHeader = DB::table('tr_headermutasi')->where('id', $request->hidden_id_tolak)->update($dataHeader);
            $updateDetail = DB::table('tr_detailmutasi')->where('idmutasi', $request->hidden_id_tolak)->update($dataDetail);
            return response()->json(['success' => 'Data Berhasil Di Revisi']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Di Revisi']);
        }
    }
    //menu revisi
    public function updateRevisi(Request $request)
    {
        $username = AuthHelper::getAuthUser()[0]->email;
        try {
            $jmlh_pack = UpdtSaldoHelper::convertJumlahToPack($request->namalimbah, $request->jmlhlimbah);
            $dataToBeUpdate = DB::table('tr_headermutasi')->where('id', $request->hidden_id)->first();
            // $dataLimbah=DB::table('md_namalimbah')->where('id',$request->namalimbah)->first();
            $dataHeader = array(

                'idlimbah'            =>   $request->namalimbah,
                'tgl'                =>  AppHelper::convertDate($request->entridate),
                'idasallimbah'        =>  $request->limbahasal,
                'idjenislimbah'     =>  $request->jenislimbah,
                'jumlah_in'            =>  $request->jmlhlimbah,
                'pack_in'            =>   $jmlh_pack,
                'idsatuan'            =>  $request->satuan,
                'limbah3r'            =>  $request->limbah3r,
                'keterangan'            =>  $request->keterangan,
                'maksud'                   => $request->maksud,
                'np_perevisi'          => $request->np_perevisi,
                // 'np_penerima'          => $request->np_perevisi,
                'updated_at'            => date('Y-m-d')

            );

            $dataDetail = array(
                'id_transaksi'      =>  $dataToBeUpdate->id_transaksi,
                'idmutasi'          =>  $dataToBeUpdate->id,
                'idlimbah'          =>  $request->namalimbah,
                'idstatus'          =>  10,
                'jumlah'            =>  $request->jmlhlimbah,
                'pack'              =>  $jmlh_pack,
                'idsatuan'          =>  $request->satuan,
                'created_at'        =>  date('Y-m-d'),
                'tgl'               => AppHelper::convertDate($request->entridate),
                'idasallimbah'      =>   $request->limbahasal,
                'np_perevisi'                   => $request->np_perevisi,
                'alasan_revisi'        => $request->alasan,
                'idjenislimbah'     => $request->jenislimbah,
                'limbah3r'          =>  $request->limbah3r,
                'created_by'        => $request->np_perevisi,
            );
            // $dataDetailTerima = array(
            //     'id_transaksi'      =>  $dataToBeUpdate->id_transaksi,
            //     'idmutasi'          => $dataToBeUpdate->id,
            //     'idlimbah'          =>  $request->namalimbah,
            //     'idstatus'          =>  2,
            //     'jumlah'            =>  $request->jmlhlimbah,
            //     'pack'              =>   $jmlh_pack,
            //     'idsatuan'          =>  $request->satuan,
            //     'created_at'        => date('Y-m-d'),
            //     'tgl'               =>  AppHelper::convertDate($request->entridate),
            //     'idasallimbah'      =>   $request->limbahasal,
            //     'np_perevisi'       => $request->np_perevisi,
            //     // 'np_pemohon'        => $request->np_pemohon,
            //     'alasan_revisi'     => $request->alasan,
            //     'idjenislimbah'     => $request->jenislimbah,
            //     'limbah3r'          =>  $request->limbah3r,
            //     'created_by'        => $request->np_perevisi,
            //     'changed_by'        => $request->np_perevisi,
            // );
            $dataDetailPermohonan = array( 
                'idlimbah'          =>  $request->namalimbah, 
                'jumlah'            =>  $request->jmlhlimbah,
                'pack'              =>  $jmlh_pack,
                'idsatuan'          =>  $request->satuan,
                'created_at'        =>  date('Y-m-d'),
                'tgl'               => AppHelper::convertDate($request->entridate),
                'idasallimbah'      =>   $request->limbahasal,
                'np_perevisi'                   => $request->np_perevisi,
                'alasan_revisi'        => $request->alasan,
                'idjenislimbah'     => $request->jenislimbah,
                'limbah3r'          =>  $request->limbah3r,
                'created_by'        => $request->np_perevisi,
            );
            $dataStatus = array(

                'jumlah_in'            =>  $request->jmlhlimbah,


            );
            // UpdtSaldoHelper::updateKurangPackNamaLimbah($row['idlimbah'], $jmlh_pack);
            UpdtSaldoHelper::updateTambahSaldoNamaLimbah($request->namalimbah, $request->jmlhlimbah);
            $updateHeader = DB::table('tr_headermutasi')->where('id', $request->hidden_id)->update($dataHeader);
            // $updateHeader = DB::table('tr_statusmutasi')->where('idmutasi', $request->hidden_id)->update($dataStatus);
            $insertDetail = DB::table('tr_detailmutasi')->insert($dataDetail);
            // $insertDetail1 = DB::table('tr_detailmutasi')->insert($dataDetailTerima);
            $insertDetail1 = DB::table('tr_detailmutasi')->where('idmutasi', $request->hidden_id)
            ->where('idstatus','1')
            ->update($dataDetailPermohonan);
            return response()->json(['success' => 'Data Berhasil Di Revisi']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Data Gagal Di Revisi']);
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
}
