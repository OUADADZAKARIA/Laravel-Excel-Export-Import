<?php

namespace App\Exports;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UsersExport implements
    FromCollection,
    ShouldAutoSize,
    WithMapping,
    WithHeadings,
    WithEvents,
    WithDrawings,
    WithCustomStartCell



/*
ShouldAutoSize : Dans certains cas, vous souhaiterez peut-être plus de contrôle sur la largeur réelle de la colonne au lieu de vous fier au dimensionnement automatique. Vous pouvez le faire avec les préoccupations WithColumnWidths. Il accepte un tableau de colonnes (représentation alphabétique: A, B, C) et une largeur numérique.
WithMapping : En ajoutant WithMapping, vous mappez les données qui doivent être ajoutées sous forme de ligne. De cette façon, vous contrôlez la source réelle de chaque colonne. En cas d'utilisation du générateur de requêtes Eloquent
WithHeadings : Une ligne d'en-tête peut facilement être ajoutée en ajoutant la préoccupation WithHeadings. La ligne d'en-tête sera ajoutée comme toute première ligne de la feuille.
WithDrawings :En utilisant le souci WithDrawings, vous pouvez ajouter un ou plusieurs dessins à votre feuille de calcul
WithCustomStartCell :La cellule de début par défaut est A1. L'implémentation de la préoccupation WithCustomStartCell dans votre classe d'exportation vous permet de spécifier une cellule de démarrage personnalisée.


*/

//ShouldAutoSize : pour bien afficher les columns
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;
    private $fileName = "users.xlsx";
    public function collection()
    {

        //1)
        return User::all();
        return User::where('email', 'like', '%regimeaz%')->get();


        // //2)
        // return new Collection([
        //     ['OUADAD','ouadad.zakaria@gmail.com']
        // ]);




    }

    // 3) WithMapping
    public function map($user): array
    {
        return [
            $user->id,
            $user->email,
            $user->created_at,
        ];
    }


    // 3) WithHeadings

    public function headings(): array
    {
        return [
            '#',
            'Email',
            'Date',
        ];
    }


    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $event->sheet->getStyle('A8:C8')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                            'color' => ['argb' => 'FFFF0000'],
                        ],
                    ]
                ]);
            },
        ];
    }


    //drawings

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/img/logo.jpg'));
        $drawing->setHeight(90);
        $drawing->setCoordinates('B3');

        return $drawing;
    }




    //startCell
    public function startCell(): string
    {
        return 'A8';
    }
}
