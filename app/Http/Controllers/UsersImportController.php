<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Session\Session;

class UsersImportController extends Controller
{
    public function store(Request $request){
        $file = $request->file('file');
        //1)
        //Excel::import(new UsersImport, $file);


        //2)
        $import = new UsersImport;
        $import->import($file);

        if($import->failures()->isNotEmpty()){
            return back()->withFailures($import->failures());
        }
        //dd($import->failures());
        
        return back()->withStatus("nous vous envoyons notifications une fois l'importation terminer");
        //return back()->withStatus('Votre fichier est bien été importé');
    }
}
