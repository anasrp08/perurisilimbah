<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laratrust\LaratrustFacade as Laratrust;
use App\Helpers\QueryHelper; 
use App\Helpers\UpdKaryawanHelper; 
use App\Http\Requests;
use App\Jadwal;
use App\Helpers\AppHelper;
use App\Role;
use DB;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(DB::table('cemori.tbl_status')->get());

        if (Laratrust::hasRole('admin')) {

            //     // $getYear = DB::table('desain_tahun')->orderBy('tahun','desc')->get();
            //     // $year=[];
            //     // for($i=0;$i<count($getYear);$i++){
            //     //     array_push($year,$getYear[$i]->tahun);
            //     //     if($getYear[$i]->tahun == '2019'){ 
            //     //     break;
            //     //     }
            //     // }
            //     // dd($year);
            //     // $book = Book::all();

            //     // $member = Role::where('name', 'member')->first()->users;

            //     // $borrow = BorrowLog::all();
            //     // return view('dashboard.admin', compact('author', 'book', 'member', 'borrow'));

            //     return view('dashboard.admin',[
            //         // 'year'=>$year
            //     ]);
            UpdKaryawanHelper::updatePegawai();
            return view('dashboard.dashboard');
        } else {
            UpdKaryawanHelper::updatePegawai();
            return view('pemohon.create', QueryHelper::getDropDown());
        }


        // return view('home');
    }

    public function getNotifikasi()
    {
        // $countKadaluarsa=DB::table('tr_packing')
        // ->where()
    }
}
