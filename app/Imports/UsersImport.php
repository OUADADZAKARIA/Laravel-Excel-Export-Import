<?php

namespace App\Imports;

use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class UsersImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure,
    WithChunkReading,
    ShouldQueue,
    WithEvents
    

/*
WithHeadingRow : Si votre fichier contient une ligne d'en-tête (une ligne dans laquelle chaque cellule indique le but de cette colonne) et que vous souhaitez utiliser ces noms comme clés de tableau de chaque ligne, vous pouvez implémenter la préoccupation WithHeadingRow.
SkipsOnError : Parfois, vous voudrez peut-être ignorer toutes les erreurs, par exemple enregistrements de base de données en double. En utilisant le problème SkipsOnError, vous contrôlez ce qui se passe au moment où une importation de modèle échoue. Lors de l'utilisation de SkipsOnError, l'importation entière ne sera pas annulée lorsqu'une exception de base de données se produit.
WithValidation : Parfois, vous souhaiterez peut-être valider chaque ligne avant son insertion dans la base de données. En implémentant le problème WithValidation, vous pouvez indiquer les règles que chaque ligne doit respecter. La méthode rules () s'attend à ce qu'un tableau avec des règles de validation Laravel soit renvoyé.
SkipsOnFailure : Parfois, vous voudrez peut-être ignorer les échecs. En utilisant la préoccupation SkipsOnFailure, vous contrôlez ce qui se passe au moment où un échec de validation se produit. Lors de l'utilisation de SkipsOnFailure, l'importation entière ne sera pas annulée en cas d'échec.
WithBatchInserts : L'importation d'un fichier volumineux dans des modèles Eloquent peut rapidement devenir un goulot d'étranglement car chaque ligne se traduit par une requête d'insertion. Avec la préoccupation WithBatchInserts, vous pouvez limiter le nombre de requêtes effectuées en spécifiant une taille de lot. Cette taille de lot déterminera le nombre de modèles qui seront insérés dans la base de données en une seule fois. Cela réduira considérablement la durée de l'importation.
WithChunkReading : L'importation d'un fichier volumineux peut avoir un impact énorme sur l'utilisation de la mémoire, car la bibliothèque essaiera de charger la feuille entière en mémoire. Pour atténuer cette augmentation de l'utilisation de la mémoire, vous pouvez utiliser le problème WithChunkReading. Cela lira la feuille de calcul en morceaux et gardera l'utilisation de la mémoire sous contrôle.
ShouldQueue : Lorsque vous utilisez le problème WithChunkReading, vous pouvez également choisir d'exécuter chaque bloc dans un travail de file d'attente. Vous pouvez le faire en ajoutant simplement le contrat ShouldQueue.
WithEvents : Le processus d'importation comporte quelques événements que vous pouvez utiliser pour interagir avec les classes sous-jacentes afin d'ajouter un comportement personnalisé à l'importation. Vous pouvez vous connecter au package parent à l'aide d'événements. Les événements seront activés en ajoutant la préoccupation WithEvents. Dans la méthode registerEvents, vous devrez retourner un tableau d'événements. La clé est le nom complet (FQN) de l'événement et la valeur est un écouteur d'événement appelable. Cela peut être une classe de fermeture, appelable par tableau ou invocable.
*/
{
    use Importable, SkipsErrors, SkipsFailures,RegistersEventListeners;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'password' => Hash::make($row['password']),
        ]);
    }


    /* Si vous voudrez ignorer toutes les erreurs */
    // public function onError(Throwable $error){
    // }


    public function rules(): array
    {
        return [

            '*.email' => ['email', 'unique:users,email']
        ];
    }


    /* l'importation entière ne sera pas annulée en cas d'échec (validation Email , unique ... ) */
    // public function onFailure(Failure ...$failures)
    // {
    //     // Handle the failures how you'd like.
    // }



    /*
    WithBatchInserts :L'importation d'un fichier volumineux dans des modèles Eloquent peut rapidement devenir un goulot d'étranglement car chaque ligne se traduit par une requête d'insertion. 
    Avec la préoccupation WithBatchInserts, vous pouvez limiter le nombre de requêtes effectuées en spécifiant une taille de lot. 
    Cette taille de lot déterminera le nombre de modèles qui seront insérés dans la base de données en une seule fois. 
    Cela réduira considérablement la durée de l'importation. 
    */

    // public function batchSize(): int
    // {
    //     return 1000;
    // }

    public function chunkSize(): int
    {
        return 1000;
    }


    public static function afterImport(AfterImport $event){
        dd($event);
        return back()->withStatus("ok");

    }

    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }
}
