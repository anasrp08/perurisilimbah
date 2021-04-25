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
use App\Helpers\AuthHelper; 
use Illuminate\Support\Facades\Storage;

use Redirect;
use Validator;
use Response;
use DB;
use PDF;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
     
    public function index(Request $request)
    {

         
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
    public static function getDownloadUserManual(){  
    //PDF file is stored under project/public/download/info.pdf
    $file= public_path(). "/file/UM_SIMBAH_Unit_Kerja.pdf";

    $headers = array(
              'Content-Type: application/pdf',
            );
    return response()->download($file, 'UM_SIMBAH_Unit_Kerja.pdf', $headers); 

    }
    public static function getDownloadUID(){  
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/file/Daftar_UID_Password.pdf";
    
        $headers = array(
                  'Content-Type: application/pdf',
                );
        return response()->download($file, 'Daftar_UID_Password.pdf', $headers); 
    
        }
        public static function getDownloadNamaLimbah(){  
            //PDF file is stored under project/public/download/info.pdf
            $file= public_path(). "/file/Standar_Nama_Limbah.pdf";
        
            $headers = array(
                      'Content-Type: application/pdf',
                    );
            return response()->download($file, 'Standar_Nama_Limbah.pdf', $headers); 
        
            }
            public static function getDownloadLabel(){  
                 //PDF file is stored under project/public/download/info.pdf
            $file= public_path(). "/file/Petunjuk Teknis Simbol Label.pdf";
        
            $headers = array(
                      'Content-Type: application/pdf',
                    );
            return response()->download($file, 'Petunjuk Teknis Simbol Label.pdf', $headers); 
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
