<?php

namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class NeracaProsesExport implements FromCollection,WithHeadings,WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function __construct(string $month,string $year,string $status)
    {
        $this->status = $status;
        $this->year  = $year;
        $this->month = $month; 
    }

// public function forYear(int $year)
// {
//     $this->year = $year;
    
//     return $this;
// }
// public function forStatus(string $status)
// {
//     $this->status = $status;
    
//     return $this;
// }
    public function collection()
    {
        // dd($this->month);
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 240);
        ini_set('max_execution_time',360);
        ini_set('max_input_time', 120);


        $queryData = DB::table('tr_detailmutasi')
        ->join('tr_headermutasi', 'tr_detailmutasi.idmutasi', '=', 'tr_headermutasi.id')
        ->join('md_namalimbah', 'tr_detailmutasi.idlimbah', '=', 'md_namalimbah.id') 
        ->join('md_penghasillimbah', 'tr_detailmutasi.idasallimbah', '=', 'md_penghasillimbah.id')
        ->join('md_statusmutasi', 'tr_detailmutasi.idstatus', '=', 'md_statusmutasi.id')
        ->join('md_satuan', 'md_satuan.id', '=', 'tr_detailmutasi.idsatuan')
        ->select(
            // 'tr_headermutasi.id',
            'tr_headermutasi.tgl',
            'md_namalimbah.namalimbah', 
            'tr_detailmutasi.jumlah',
            'md_satuan.satuan',
            'md_namalimbah.jenislimbah', 
            'md_statusmutasi.keterangan as keterangan_mutasi',
            
            'md_penghasillimbah.seksi',
            // 'tr_detailmutasi.*'
            // DB::raw('SUM(tr_detailmutasi.jumlah) as jumlah2'),
           
            'tr_detailmutasi.created_at',
            'tr_detailmutasi.np_pemroses'
        )
        ->whereMonth('tr_detailmutasi.created_at', '=',   $this->month)
        ->whereYear('tr_detailmutasi.created_at', '=',   $this->year)    
        ->whereIn('tr_detailmutasi.idstatus', ['5','6','7','8','9'])
        ->orderBy('tr_detailmutasi.created_at','desc'); 
 

        $queryData = $queryData->get();
           
        
        
         

        // return User::query()->where('name', 'like', '%'. $this->name);
        return  $queryData;
    }
    public function headings(): array
    {
        return [
            'Tanggal Permohonan',
            'Limbah',
            'Jumlah',
            'Satuan', 
            'Jenis Limbah',
            'Keterangan',
            'Penghasil Limbah', 
            'Diproses Oleh',
            'Tgl. Diproses'     
            
        ];
    }
    // public function sheets(): array
    // {
    //     $sheets = [];
    //     $sheets = [
    //         new ReportGeneralExport($this->sheets['general']),
    //         new ReportLeadsExport($this->sheets['leads']),
    //         new ReportVideoExport($this->sheets['video'])
    //     ];
    //     // for ($month = 1; $month <= 2; $month++) {
    //     //     $sheets[] = new InvoicesPerMonthSheet($this->year, $month);
    //     // }

    //     return $sheets;
    // }
    public function title(): string
    {
        return 'Mutasi ' . $this->status;
    }
    

}
