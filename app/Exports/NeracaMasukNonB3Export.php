<?php

namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class NeracaMasukNonB3Export implements FromCollection,WithHeadings,WithTitle,WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public function __construct(int $month,int $year,string $status)
    {
        $this->month = $month; 
        $this->year  = $year; 
        $this->status = $status;
        
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
        // ->join('md_satuan', 'md_satuan.id', '=', 'tr_detailmutasi.idsatuan')
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
            'tr_detailmutasi.np_penerima'
        )
        ->whereMonth('tr_detailmutasi.created_at', '=',   $this->month)
        ->whereYear('tr_detailmutasi.created_at', '=',   $this->year)    
        ->where('tr_detailmutasi.idstatus', '=','2')
        ->where('tr_detailmutasi.idjenislimbah', '=','2')
        // ->groupBy('md_namalimbah.namalimbah')
        // ->orderBy('tr_detailmutasi.created_at','desc'); 
        ->orderBy('tr_detailmutasi.created_at','desc','md_namalimbah.namalimbah','asc'); 

        $queryData = $queryData->get(); 
        // dd($queryData);
         
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
            'Tgl. Diproses',
            'Diproses Oleh'             
            
        ];
    }
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_NUMBER,
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
        return 'Limbah Non B3 Mutasi ' . $this->status;
    }
    

}
