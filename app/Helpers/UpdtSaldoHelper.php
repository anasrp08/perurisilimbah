<?php
namespace App\Helpers;
use DateTime;
use DB;
use Illuminate\Support\Str; 
class UpdtSaldoHelper
{
    public static function updateTambahSaldoNamaLimbah($namalimbah,$jumlahAngkut){
        $queryNamaLimbah=DB::table('md_namalimbah')->where('id','=',$namalimbah)->first();
        // dd($queryNamaLimbah);
        $jumlah=$queryNamaLimbah->saldo;
        $jumlah=$jumlah+(int)$jumlahAngkut; 
        $updateJumlah = array ( 
            'saldo'	        =>  (int)$jumlah, 
            'updated_at'=>date('Y-m-d')
        );
        $queryUpdate=DB::table('md_namalimbah')->where('id','=',$namalimbah)->update($updateJumlah);
 
    }
    public static function updateKurangSaldoNamaLimbah($namalimbah,$jumlahAngkut){
        $queryNamaLimbah=DB::table('md_namalimbah')->where('id','=',$namalimbah)->first();
        // dd($queryNamaLimbah);
        $jumlah=$queryNamaLimbah->saldo;
        $jumlah=$jumlah-(int)$jumlahAngkut; 
        $updateJumlah = array ( 
            'saldo'	        =>  (int)$jumlah, 
            'updated_at'=>date('Y-m-d')
        );
        $queryUpdate=DB::table('md_namalimbah')->where('id','=',$namalimbah)->update($updateJumlah);
 
    }
    public static function updateTambahSaldoTPS($tps,$saldo){
        $saldoTPS=DB::table('md_tps')->where('id','=',$tps)->first();
        // dd($queryNamaLimbah);
        $jumlah=$saldoTPS->saldo;
        $jumlah=$jumlah+(int)$saldo; 
        $updateJumlah = array ( 
            'saldo'	        =>  (int)$jumlah, 
            'updated_at'=>date('Y-m-d')
        );
        $queryUpdate=DB::table('md_tps')->where('id','=',$tps)->update($updateJumlah);
 
    }
    public static function updateKurangSaldoTPS($tps,$saldo){
        $saldoTPS=DB::table('md_tps')->where('id','=',$tps)->first();
        // dd($queryNamaLimbah);
        $jumlah=$saldoTPS->saldo;
        $jumlah=$jumlah-(int)$saldo; 
        $updateJumlah = array ( 
            'saldo'	        =>  (int)$jumlah, 
            'updated_at'=>date('Y-m-d')
        );
        $queryUpdate=DB::table('md_tps')->where('id','=',$tps)->update($updateJumlah);
 
    }
     
    
     
    public function getAuthUser(){
        if (!Auth::check()) {
           
            return redirect()->route('login');
        }else{
            $getUserid = auth()->user()->id;
            return $getRoleUser=DB::table('users')->join('role_user', 'role_user.user_id', '=', 'users.id')
       ->where('users.id', $getUserid)
      
       ->get();
        }

    }
     
}