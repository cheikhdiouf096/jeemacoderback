<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditHackatonRequest;
use App\Http\Requests\hackathonRequest;
use App\Http\Requests\RegisterUser;
use App\Models\roles;
use App\Models\User;
use Exception;
use App\Models\hackathon;
use App\Models\tag;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class hackathonController extends Controller
{

    public function index(){
        try{
            $hackathons = Hackathon::all();
            return response()->json($hackathons);
        }catch(Exception $e) {
               return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function store(hackathonRequest $request)
    {
        try {
            // if (auth()->user()->role_id !== 1) {
            //     return response()->json([
            //         'message' => 'Vous n\'êtes pas autorisé à créer des hackathons',
            //     ], 403);
            // }
            $logo = null;
            if ($request->hasFile('logo_url')) {
                $logo = Str::random(32) . "." . $request->logo_url->getClientOriginalExtension();
                Storage::disk('public_images')->put($logo, file_get_contents($request->logo_url));
            }

            $hackathon = new Hackathon();
            $hackathon->name = $request->name;
            $hackathon->structure_organisateur = $request->structure_organisateur;
            $hackathon->date_debut = $request->date_debut;
            $hackathon->date_fin = $request->date_fin;
            $hackathon->lieu = $request->lieu;
            $hackathon->description = $request->description;
            $hackathon->logo_url = $logo; // Utilisation de la variable $logo ici
            $hackathon->theme = $request->theme;
            $hackathon->prix = $request->prix;
            $tag = tag::find($request->tag_id);
            $hackathon->organisateur_id = auth()->check() ? auth()->user()->id : null;
             // Vérification de l'utilisateur authentifié

            if ($hackathon->organisateur_id === null) {
                return response()->json([
                    'message' => 'Utilisateur non authentifié',
                ], 401);
            }

            $hackathon->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Hackathon ajouté avec succès',
                'Hackathon' => $hackathon,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de l\'ajout de l\'hakacthon',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function update(EditHackatonRequest $request, Hackathon $hackathon)
   {
    try {
        // if (auth()->user()->role_id !== 1) {
        //     return response()->json([
        //         'message' => 'Vous n\'êtes pas autorisé à modifier des hackathons',
        //     ], 403);
        // }
        $hackathon->name = $request->name; // Décommentez cette ligne
        $hackathon->structure_organisateur = $request->structure_organisateur;
        $hackathon->date_debut = $request->date_debut;
        $hackathon->date_fin = $request->date_fin;
        $hackathon->lieu = $request->lieu;
        $hackathon->description = $request->description;
        $hackathon->theme = $request->theme;
        $hackathon->prix = $request->prix;

        if ($hackathon->organisateur_id === auth()->user()->id) {
            $hackathon->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Hackathon modifié avec succès',
                'Hackathon' => $hackathon,
            ]);
        } else {
            return response()->json([
                'status_code' => 403,
                'status_message' => 'Vous n\'avez pas le droit de modifier cet hackathon',
            ]);
        }
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Erreur lors de la modification de l\'hackathon',
            'error' => $e->getMessage(),
        ], 500);
    }
}

public function destroy(hackathon $hackathon){
    try{
        if($hackathon->organisateur_id === auth()->user()->id){
            $hackathon->delete();
            return response()->json([
               'message' => 'Hackathon supprimé avec succès',
               'hackathon' => $hackathon
            ], 200);
        }else{
            return response()->json([
               'message' => 'Vous n\'avez pas le droit de supprimer cet hackathon',
            ], 403);
        }
    }catch(Exception $e){
        return response()->json([
           'message' => 'Erreur lors de la suppression du hackathon',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
