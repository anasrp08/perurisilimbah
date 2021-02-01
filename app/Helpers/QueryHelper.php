<?php
namespace App\Helpers;
use DateTime;
use DB;

class QueryHelper
{
    public static function getDropDown(){
        $jenisLimbah=DB::table('md_jenislimbah')->get();
        $namaLimbah=DB::table('md_namalimbah')->get();
        $tipeLimbah=DB::table('md_tipelimbah')->get();
        $penghasilLimbah=DB::table('md_penghasillimbah')->get();
        $satuanLimbah=DB::table('md_satuan')->orderBy('id','desc')->get();
        $tpsLimbah=DB::table('md_tps')->get();
        $np=DB::table('tbl_np')->get();
        $status=DB::table('md_statusmutasi')->get();
        // dd($namaLimbah);
        

        return [
            'jenisLimbah' => $jenisLimbah,
            'namaLimbah' => $namaLimbah,
            'tipeLimbah' => $tipeLimbah,
            'satuanLimbah' => $satuanLimbah,
            'tpsLimbah' => $tpsLimbah,
            'penghasilLimbah' => $penghasilLimbah,
            'np' => $np,
            'status'=>$status

        ];
        
        
    } 
    public static function convertDateYmd($date){
        if($date == null){
            return "-";
        }else{
            $date=DateTime::createFromFormat("d/m/Y", $date);
            $date= $date->format('Y/m/d');
            return $date;
        }
        
        
    } 
       public static function pathFile($folderSurat,$folderNosurat)
       {

              // return public_path(). DIRECTORY_SEPARATOR .'file'. DIRECTORY_SEPARATOR .$folderSurat. DIRECTORY_SEPARATOR .$folderNosurat; 
              return public_path(). '/' .'file'. '/' .$folderSurat. '/' .$folderNosurat; 
               //un comment ini ketika publish
              // return base_path(). '/' .'file'. '/' .$folderSurat. '/' .$folderNosurat; 
       }

       public static function savePath($folderSurat,$folderNosurat,$filename)
       {
              return  'file/'.$folderSurat. '/' .$folderNosurat.'/'.$filename;
               //un comment ini ketika publish
              // return  'project/file/'.$folderSurat. '/' .$folderNosurat.'/'.$filename;
       }
       public static function pathFileFoto($avatar){
              if($avatar==""){
                  return public_path(). '/' .'img'; 
              }else{
                  return public_path() . '/' . 'img' . '/' . $avatar;
              }
              
      
          }

          public static function pathFoto($folder,$Nosurat){
            // base_path()

            // return base_path().'/'.'FOTO'. '/' .$folder. '/'  .$Nosurat ; 
              return public_path().'/'.'FOTO'. '/' .$folder. '/'  .$Nosurat ; 
              
      
          }
          //tmbah folder project ketika publish
          public static function savePathFoto($folderSurat,$folderNosurat,$filename){
              return  public_path().'/FOTO/'.$folderSurat. '/' .$folderNosurat.'/'.$filename;
              //un comment ini ketika publish
              // return  'project/FOTO/'.$folderSurat. '/' .$folderNosurat.'/'.$filename;
          }
          public static function savePathFotoDB($folderSurat,$folderNosurat,$filename){
            return  '/FOTO/'.$folderSurat. '/' .$folderNosurat.'/'.$filename;
            //un comment ini ketika publish
            // return  'project/FOTO/'.$folderSurat. '/' .$folderNosurat.'/'.$filename;
        }
          
//       

     
}