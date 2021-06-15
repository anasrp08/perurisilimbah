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
use App\Exports\NeracaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Exception;
use Redirect;
use Validator;
use Response;
use DB;
use PDF;


class ExportDataController extends Controller
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
    public function viewIndexNeraca()
    {
        

        return view('report.reportneraca', QueryHelper::getDropDown());
    }
    public function downloadNeraca($month,$year)
    {
  
    //     foreach($sales as $e)
    // {
    //     $sales_array[] = array(
    //        ' Date'=>$e->date,
    //             ' Time'=>$e->time,
    //             ' No of litre'=>$e->no_of_litre,
    //             ' note'=>$e->note,
    //     );
    //     $total += $e->no_of_litre;
    // }
    // $sales_array[] = array(
    //    ' Date'=>$e->'',
    //             ' Time'=>$e->'',
    //             ' No of litre'=>$e->'',
    //             ' note'=>$e->'',
    //    'Total'=> $total
    // );
    //     return Excel::create('salesdet',function($excel) use ($sales_array) {
    //         $excel->sheet('mySheet', function($sheet) use ($sales_array)
    //         {
    //             $sheet->fromArray($sales_array);
    //         });
    //     })->download($type);
    // https://laracasts.com/discuss/channels/laravel/how-to-pass-the-sumfields-to-excel-conversion-using-maatwebsite-in-laravel
        return Excel::download(new NeracaExport($month,$year), 'Export Neraca-'.$month.'-'.$year.'.xlsx');
    }
     

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
