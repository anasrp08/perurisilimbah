<?php

namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class NeracaExport implements FromCollection,WithHeadings,WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function __construct(int $month,int $year)
    {
        $this->month = $month;
        $this->year = $year;
        
    }
public function forYear(int $year)
{
    $this->year = $year;
    
    return $this;
}
public function forStatus(string $status)
{
    $this->status = $status;
    
    return $this;
}
    public function collection()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 240);
        ini_set('max_execution_time',360);
        ini_set('max_input_time', 120);


        $queryData=DB::table('tr_detailmutasi');
            // dd($this->status );
            // if( $this->status != ""){
            //     // dd($this->status);
            // $queryData=$queryData->where('jadwal.status',$this->status)->get();
            // // dd($queryData);
            // }else{
            //     $queryData=$queryData->get();
               
            // }
            $queryData=$queryData->get();
           
        
         

        // return User::query()->where('name', 'like', '%'. $this->name);
        return  $queryData;
    }
    public function headings(): array
    {
        return [
            'Id Jadwal',
            'Pilihan Uji',
            'No. Surat',
            'Kantor Pemohon',
            'Instansi',
            'Tgl. Surat Pemohon',
            'Tgl. Surat Perintah',
            'Status',
            'Tgl. Dibuat',
            'Mod A',
            'Mod B',
            'Charge',
            'Code',
            'Description',
            'Pos',
            'Mod A',
            'Mod B',
            'Charge',
            'Code',
            'Description',
            'Pos',
            'Mod A',
            'Mod B',
            'Charge',
            'Code',
            'Description',
            'Pos',
            'Mod A',
            'Mod B',
            'Charge',
            'Code',
            'Description',
            'Pos',
            'Mod A',
            
        ];
    }
    public function sheets(): array
    { 
        $sheets = [];
        // $sheets = [
        //     new NeracaExport($this->sheets['general']),
        //     new NeracaProsesExport($this->sheets['leads']), 
        // ];
        // for ($month = 1; $month <= 2; $month++) {
            $sheets = [
                new NeracaMasukExport( $this->month,$this->year,'Masuk'),
                new NeracaProsesExport( $this->month,$this->year,'Proses'),
            ];
        // }

        return $sheets;
    }
    
}
