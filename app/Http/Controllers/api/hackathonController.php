<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\hackathonRequest;
use App\Http\Requests\RegisterUser;
use App\Models\roles;
use App\Models\User;
use Exception;
use App\Models\hackathon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class hackathonController extends Controller
{
    // public function store(hackathonRequest $request)
    // {
    //     try{
    //         $logo=null;
    //         if($request->hasFile('logo_url')){
    //             $logo=Str::random(32).".".$request->logo_url->getClientOriginalExtension();
    //             Storage::disk('public_images')->put($logo, file_get_contents($request->logo_url));
    //         }
    //         $hackathon = new Hackathon();
    //         $hackathon->name = $request->name;
    //         $hackathon->structure_organisateur=$request->structure_organisateur;
    //         $hackathon->date_debut = $request->date_debut;
    //         $hackathon->date_fin = $request->date_fin;
    //         $hackathon->lieu = $request->lieu;
    //         $hackathon->description = $request->description;
    //         $hackathon->logo_url = $request->$logo;
    //         $hackathon->theme = $request->theme;
    //         $hackathon->organisateur_id =auth()->user()->id;
    //         // dd($hackathon);

    //         $hackathon->save();

    //         return response()->json([
    //             'status_code' => 200,
    //             'status_message' => 'Hackathon ajouté avec succès',
    //             'Hackathon' => $hackathon,

    //         ]);}catch(Exception $e){
    //         return response()->json([
    //            'message' => 'Erreur lors de l\'ajout de l\'hakacthon',
    //             'error' => 'Erreur interne du serveur'
    //         ], 500);
    //     }
    // }

    public function store(hackathonRequest $request)
    {
        try {
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
            $hackathon->organisateur_id = auth()->check() ? auth()->user()->id : null; // Vérification de l'utilisateur authentifié

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
            ], 500); // Retourne le message d'erreur exact
        }
    }
}
