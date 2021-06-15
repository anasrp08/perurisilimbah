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
use Exception;

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
        return view('tr_kontrak.list', QueryHelper::getDropDown());
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (request()->ajax()) {
            $queryData = DB::table('tr_kontrak_b3')
                ->join('md_tipelimbah', 'tr_kontrak_b3.tipe_limbah', 'md_tipelimbah.id')
                ->join('tbl_np', 'tr_kontrak_b3.np', 'tbl_np.np')
                ->where('tahun', $request->tahun)
                ->where('status', 1)
                ->select(
                    'tr_kontrak_b3.*',
                    'tr_kontrak_b3.id as id_catat',
                    'md_tipelimbah.*',
                    'tr_kontrak_b3.created_at as tgl_dibuat',
                    'tbl_np.nama'
                )
                ->orderBy('tr_kontrak_b3.tipe_limbah')
                ->get();
            return datatables()->of($queryData)
                ->addColumn('action', 'action_button')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('tr_kontrak.list', []);
    }
    public function indexNeracaKontrak(Request $request)
    {
        if (request()->ajax()) {
            $queryData = DB::table('md_kuota')
                ->join('md_tipelimbah', 'md_tipelimbah.id', 'md_kuota.tipe_limbah')
                ->leftjoin('tr_kontrak_b3', 'md_kuota.tipe_limbah', 'tr_kontrak_b3.tipe_limbah')
                ->select('md_kuota.*', 'md_tipelimbah.*', DB::raw('sum(tr_kontrak_b3.konsumsi) as jumlah_konsumsi'))
                ->where('md_kuota.tahun', $request->tahun)
                ->groupBy('tr_kontrak_b3.tipe_limbah')
                ->orderBy('md_kuota.tipe_limbah')
                ->get();

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


        $error = null;
        $rules = array(
            'transaksi_tipelimbah' => 'required',
            'transaksi_tahun' => 'required',
            'transaksi_total' => 'required',
            'jmlhlimbah' => 'required',
            'dataharga' => 'required',
            'transaksi_konsumsi' => 'required',
            'transaksi_np' => 'required',
        );
        $messages = array(
            'transaksi_tipelimbah.required' => 'Tipe Limbah Harus Diisi',
            'transaksi_tahun.required' => 'Tipe Limbah Harus Diisi',
            'transaksi_total.required' => 'Tipe Limbah Harus Diisi',
            'jmlhlimbah.required' => 'Tipe Limbah Harus Diisi',
            'dataharga.required' => 'Tipe Limbah Harus Diisi',
            'transaksi_konsumsi.required' => 'Tipe Limbah Harus Diisi',
            'transaksi_np.required' => 'Tipe Limbah Harus Diisi',
        );

        $error = Validator::make($request->all(), $rules, $messages);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'tipe_limbah' => $request->transaksi_tipelimbah,
            'jmlh_limbah' => $request->jmlhlimbah,
            'harga'      => $request->hargaSplit,
            'satuan'     => $request->satuan,
            'status'     => 1,
            'konsumsi'   => (int)str_replace('.', '', $request->transaksi_konsumsi),
            'tahun'      => $request->transaksi_tahun,
            'np'         => $request->transaksi_np,
            'created_at'                =>  date('Y-m-d'),
        );
        try {
            $insertKuota = DB::table('tr_kontrak_b3')->insert($form_data);
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ada Kesalahan Sistem: ' . $e->getMessage()]);
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
        $dataTipeKuota = DB::table('md_namalimbah')->where('tipe_kuota_limbah', $request->idtipe)->first();
        $md_kuota = DB::table('md_kuota')
            ->where('tipe_limbah', $request->idtipe)
            ->where('tahun', $request->tahun)
            ->first();
        $jumlah = 0;
        if ($md_kuota == null) {
        } else {
            $jumlah = $md_kuota->jumlah;
        }
        $hargaSatuan = null;
        $konversiKuota = null;
        if ($dataTipeKuota == null) {
            $hargaSatuan = '';
            $konversiKuota = '';
        } else {
            $hargaSatuan = $dataTipeKuota->harga_satuan_konversi;
            $konversiKuota = $dataTipeKuota->konversi_kuota;
        }

        return response()->json([
            'dataHarga' => $hargaSatuan,
            'dataSatuan' => $konversiKuota,
            'md_kuota' => $jumlah
        ]);
    }
    public function destroy(Request $request)
    {
    }
    public function deleteAnggaran(Request $request)
    {
        $paramData = array(
            'status' => 0
        );
        try {
            $queryUpdate = DB::table('tr_kontrak_b3')
                ->where('id', '=', $request->id_catat);
            $queryUpdate->update($paramData);
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ada Kesalahan Sistem: ' . $e->getMessage()]);
        }
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
    public function update(Request $request)
    {
    }
}
