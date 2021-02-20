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

    public static function updateTambahSaldoBulanan($tps,$saldo){
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
    public static function updateKurangSaldoBulanan($tps,$saldo){
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
    public static function convertJumlahToPack($idlimbah,$saldo){
        $dataNamalimbah=DB::table('md_namalimbah')->where('id','=',$idlimbah)->first();
        $max_packing=$dataNamalimbah->max_packing;
        //pembulatan ke bawah
        $jmlh_pack=(int)$saldo / (int) $max_packing;
        $jmlhFinal=round($jmlh_pack, 1); 
        return $jmlhFinal;
         
        
        // $iterationPacking = floor($jmlh_pack); 
 
    }
    public static function updateTambahPackNamaLimbah($idlimbah,$jumlahAngkut){
        $queryNamaLimbah=DB::table('md_namalimbah')->where('id','=',$idlimbah)->first();
        // dd($queryNamaLimbah);
        $jumlah=$queryNamaLimbah->jmlh_pack;
        $jumlah=$jumlah+(double)$jumlahAngkut; 
        $updateJumlah = array ( 
            'jmlh_pack'	        =>  (double)$jumlah, 
            'updated_at'=>date('Y-m-d')
        );
        $queryUpdate=DB::table('md_namalimbah')->where('id','=',$idlimbah)->update($updateJumlah);
 
    }
    public static function updateKurangPackNamaLimbah($idlimbah,$jumlahAngkut){
        $queryNamaLimbah=DB::table('md_namalimbah')->where('id','=',$idlimbah)->first();
        // dd($queryNamaLimbah);
        $jumlah=$queryNamaLimbah->jmlh_pack;
        $jumlah=$jumlah-(double)$jumlahAngkut; 
        $updateJumlah = array ( 
            'jmlh_pack'	        =>  (double)$jumlah, 
            'updated_at'=>date('Y-m-d')
        );
        $queryUpdate=DB::table('md_namalimbah')->where('id','=',$idlimbah)->update($updateJumlah);
 
    }

    public static function updateTambahPackTPS($tps,$jmlh_pack){
        $saldoTPS=DB::table('md_tps')->where('id','=',$tps)->first();
        // dd($queryNamaLimbah);
        $jumlah=$saldoTPS->saldo;
        $jumlah=$jumlah+(double)$jmlh_pack; 
        $updateJumlah = array ( 
            'saldo'	        =>  (double)$jumlah, 
            'updated_at'=>date('Y-m-d')
        );
        $queryUpdate=DB::table('md_tps')->where('id','=',$tps)->update($updateJumlah);
 
    }
    public static function updateKurangPackTPS($tps,$jmlh_pack){
        $saldoTPS=DB::table('md_tps')->where('id','=',$tps)->first();
        // dd($queryNamaLimbah);
        $jumlah=$saldoTPS->saldo;
        $jumlah=$jumlah-(double)$jmlh_pack; 
        $updateJumlah = array ( 
            'saldo'	        =>  (double)$jumlah, 
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