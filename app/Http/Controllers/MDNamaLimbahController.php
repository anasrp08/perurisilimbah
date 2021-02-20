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
 

class MDNamaLimbahController extends Controller
{
    public function viewDaftar()
    {
        
       return view('MasterData.MDNamaLimbah', QueryHelper::getDropDown());
 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        if (request()->ajax()) { 
            $queryData=DB::table('md_namalimbah')
           ->join('md_tps','md_namalimbah.tps','md_tps.id')
           ->select('md_namalimbah.*','md_tps.namatps')
           ->orderBy('md_namalimbah.id', 'asc'); 
            $queryData=$queryData->get();  
            return datatables()->of($queryData) 
                     
                    ->addIndexColumn()
                    ->addColumn('action', 'action_butt_limbah')
                    ->rawColumns(['action'])
                    
                    ->make(true);
 
        } 
        return view('MasterData.MDNamaLimbah', QueryHelper::getDropDown());
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
        $error=null;
        $rules=array( 
            'jenislimbah' => 'required',
            'namalimbah' => 'required',
            'fisiklimbah' => 'required',
            'tipelimbah' => 'required', 
            'satuan' => 'required', 
        );
        $messages = array(
             
            'jenislimbah.required'			=>  'Jenis Limbah Harus Diisi'	,
            'namalimbah.required'			=>  'Nama Limbah Harus Diisi'	, 
            'fisiklimbah.required'	        =>  'Fisik Limbah Harus Diisi',
            'tipelimbah.required'	        =>  'Tipe Limbah Harus Diisi',
            'satuan.required'               =>  'Satuan Harus Diisi',
    
        );
        $error = Validator::make($request->all(), $rules, $messages); 
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'namalimbah'		=>  $request->namalimbah	, 
            'fisik'		        =>  $request->fisiklimbah	,
            'jenislimbah'       => $request->jenislimbah, 
            'tipelimbah'        =>$request->tipelimbah, 
            'satuan'	        =>  $request->satuan	,
            'created_at'    => date('Y-m-d')           
        );         
        try {
            $queryInsert=DB::table('md_namalimbah')->insert($form_data);
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
    $error=null;
    $rules=array( 
        'jenislimbah' => 'required',
        'namalimbah' => 'required',
        'fisiklimbah' => 'required',
        'tipelimbah' => 'required', 
        'satuan' => 'required', 
        'saldo'=>'required'
    );
    $messages = array( 
        'jenislimbah.required'			=>  'Jenis Limbah Harus Diisi'	,
        'namalimbah.required'			=>  'Nama Limbah Harus Diisi'	, 
        'fisiklimbah.required'	        =>  'Fisik Limbah Harus Diisi',
        'tipelimbah.required'	        =>  'Tipe Limbah Harus Diisi',
        'saldo.required'               =>  'Saldo Harus Diisi',
        'satuan.required'               =>  'Satuan Harus Diisi',

    );

        $error = Validator::make($request->all(), $rules, $messages); 
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'namalimbah'		=>  $request->namalimbah	, 
            'fisik'		        =>  $request->fisiklimbah	,
            'jenislimbah'       =>  $request->jenislimbah, 
            'tipelimbah'        =>  $request->tipelimbah, 
            'satuan'	        =>  $request->satuan	,
            'saldo'	            =>  $request->saldo	,
            'updated_at'        => date('Y-m-d')           
        );       
        
        try { 
            
            $queryUpdate=DB::table('md_namalimbah')->where('id','=',$request->hidden_id)->update($form_data);
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
        $queryUpdate=DB::table('md_namalimbah')
        ->where('id','=',$id); 
        $queryUpdate->delete();
    }
     

     

}
