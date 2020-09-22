<?php
namespace App\Helpers;
use DateTime;
use DB;
use Illuminate\Support\Str; 
class UpdKaryawanHelper
{
    public static function updatePegawai(){
        $dataNP=DB::table('tbl_np')->get();
        // dd(count($dataNP));
        if(count($dataNP)!=0){

        }else{

        
 
        $location = 'datakaryawan';

          // Upload file
          $filename='data karyawan.txt';
        //   $file->move($location,$filename);

          // Import CSV to Database
          $filepath = public_path($location."/".$filename);
          // Reading file
          $file = fopen($filepath,"r");

          $importData_arr = array();
          $i = 0;
          while (($filedata = fgetcsv($file, 1000, "\t")) !== FALSE) {
            $num = count($filedata );
            // dd($filedata);
            
            // Skip first row (Remove below comment if you want to skip the first row)
            if($i == 0){
               $i++;
               continue; 
            }
            for ($c=0; $c < $num; $c++) {
                // dd($filedata);
                if(strpos($filedata [0], 'L')!== false){

                break;
                }else if(strpos($filedata [0], 'D')!== false){
                break;
                }else if(strpos($filedata [14], 'KADIV')!== false){
                break;
                }

                if($c==0){
                    
                    $importData_arr[$i][0] = $filedata [$c];
                }else if($c==2){ 
                    $importData_arr[$i][1] = $filedata [$c];
                }else if($c==8){
                     
                        $importData_arr[$i][2] = $filedata [$c];
                     
                    
                }else if($c==18){
                    // dd($filedata [$c]);
                    $importData_arr[$i][3] = $filedata [$c];
                }else{
                // break;
                }
            //    $importData_arr[$i][] = $filedata [$c];
            }
            $i++;
         }
         fclose($file);
        //  dd($importData_arr);

         // Insert to MySQL database
         foreach($importData_arr as $importData){

           $insertData = array(
              "np"=>$importData[0],
              "nama"=>$importData[1],
              "jabatan"=>$importData[3],
              "unitkerja"=>$importData[2],
              "created_at"=>date('Y-m-d'));
              $insertData=DB::table('tbl_np')->insert($insertData);
            //   DB::table('tbl_np')
        //    Page::insertData($insertData);

         }
        }
 
    }
     
     
}