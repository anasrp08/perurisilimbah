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
use Exception;

class MDVendorController extends Controller
{
    public function viewDaftar()
    {
        
       return view('MasterData.MDVendor', QueryHelper::getDropDown());
 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        if (request()->ajax()) { 
            $queryData=DB::table('md_vendorlimbah')
           
           ->orderBy('md_vendorlimbah.id', 'asc'); 
            $queryData=$queryData->get();  
            return datatables()->of($queryData) 
                     
                    ->addIndexColumn()
                    ->addColumn('action', 'action_butt_limbah')
                    ->rawColumns(['action'])
                    
                    ->make(true);
 
        } 
        return view('MasterData.MDVendor', QueryHelper::getDropDown());
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
            'namavendor' => 'required',
            'jenislimbah' => 'required',
            'fisiklimbah' => 'required',
            'tipelimbah' => 'required',   
        );
        $messages = array(
             
            'namavendor.required'			=>  'Nama Vendor Harus Diisi'	,
            'jenislimbah.required'			=>  'Jenis Limbah Harus Diisi'	, 
            'fisiklimbah.required'	        =>  'Fisik Limbah Harus Diisi',
            'tipelimbah.required'	        =>  'Tipe Limbah Harus Diisi',
             
    
        );
        $error = Validator::make($request->all(), $rules, $messages); 
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'namavendor'		=>  $request->namavendor	, 
            'fisik'		        =>  $request->fisiklimbah	,
            'jenislimbah'       => $request->jenislimbah, 
            'tipelimbah'        =>$request->tipelimbah,  
            'created_at'    => date('Y-m-d')           
        );         
        try {
            $queryInsert=DB::table('md_vendorlimbah')->insert($form_data);
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ada Kesalahan Sistem: '.$e->getMessage()]);
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
        'namavendor' => 'required',
        'jenislimbah' => 'required',
        'fisiklimbah' => 'required',
        'tipelimbah' => 'required',   
    );
    $messages = array(
         
        'namavendor.required'			=>  'Nama VendorHarus Diisi'	,
        'jenislimbah.required'			=>  'Jenis Limbah Harus Diisi'	, 
        'fisiklimbah.required'	        =>  'Fisik Limbah Harus Diisi',
        'tipelimbah.required'	        =>  'Tipe Limbah Harus Diisi' 
    );

        $error = Validator::make($request->all(), $rules, $messages); 
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'namavendor'		=>  $request->namavendor	, 
            'fisik'		        =>  $request->fisiklimbah	,
            'jenislimbah'       => $request->jenislimbah, 
            'tipelimbah'        =>$request->tipelimbah,     
            'updated_at'        => date('Y-m-d')           
        );       
        
        try { 
            
            $queryUpdate=DB::table('md_vendorlimbah')->where('id','=',$request->hidden_id)->update($form_data);
            return response()->json(['success' => 'Data Berhasil Di Simpan']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Ada Kesalahan Sistem: '.$e->getMessage()]);
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
        $queryUpdate=DB::table('md_vendorlimbah')
        ->where('id','=',$id); 
        $queryUpdate->delete();
    }
     

     

}
