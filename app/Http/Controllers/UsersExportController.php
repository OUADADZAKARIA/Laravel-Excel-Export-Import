<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
//use Maatwebsite\Excel\Facades\Excel;

class UsersExportController extends Controller
{



    // 1) 
    /*use Maatwebsite\Excel\Facades\Excel;*/

    // public function export(){
    //     return Excel::download(new UsersExport,'users.xlsx');
    // }



    // 2)
    /*use Maatwebsite\Excel\Excel;*/
    // public function export(Excel $excel){
    //     return $excel->download(new UsersExport,'users.xlsx');
    // }


    private $excel;
    public function __construct(Excel $excel)
    {
        $this->excel = $excel;
    }

    public function export(Excel $excel)
    {
         return $this->excel->download(new UsersExport, 'users.xlsx');

        /*****           Export formats :           ****/


        // https://docs.laravel-excel.com/3.1/exports/export-formats.html
        //return $this->excel->download(new UsersExport,'users.csv');


        // Export PDF :dompdf
        // https://github.com/dompdf/dompdf 
        // composer require dompdf/dompdf

        //return $this->excel->download(new UsersExport, 'users.pdf', Excel::DOMPDF);
    }
}
