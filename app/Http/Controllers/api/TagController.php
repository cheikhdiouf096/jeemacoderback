<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\tag;
use Exception;

class TagController extends Controller
{
    public function index()
    {
        try{
            $tag = tag::all();
        return response()->json([
            'tag' => $tag,
           'message' => 'tags récupérés avec succès'
        ]);
        }catch(Exception $e){
            return response()->json([
               'message' => 'Erreur lors de la récupération des tag',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Créer un nouveau rôle
    public function store(Request $request)
    {
      try{
        $request->validate([
            'name' => 'required',
        ]);

        $tag = tag::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'tag' => $tag,
           'message' => 'Tag créé avec succès',
           $tag, 201
        ]);
      }catch(Exception $e){
        return response()->json([
           'message' => 'Erreur lors de la création du tag',
            'error' => $e->getMessage()
        ], 500);
      }
    }

    // Afficher un rôle spécifique
    public function show($id)
    {
        try{
         $tag = tag::findOrFail($id);
        return response()->json([
            'tag' => $tag,
           'message' => 'Rôle trouvé',
        ]);
        }catch(Exception $e){
            return response()->json([
               'message' => 'Erreur lors de la récupération du rôle',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    // Mettre à jour un rôle
    public function update(Request $request, $id)
    {
        try{

        $tag = tag::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:tag,name,' . $tag->id,
        ]);

        $tag->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'tag' => $tag,
           'message' => 'Rôle mis à jour avec succès',
        ]);
        }catch(Exception $e){
            return response()->json([
               'message' => 'Erreur lors de la mise à jour du rôle',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Supprimer un rôle
    public function destroy($id)
    {
       try{
        $tag = tag::findOrFail($id);
        $tag->delete();

        return response()->json([
            'tag' => $tag,
           'message' => 'Rôle supprimé avec succès',
           null, 204
        ]);
       }catch(Exception $e){
        return response()->json([
           'message' => 'Erreur lors de la suppression du rôle',
            'error' => $e->getMessage()
        ], 500);
       }
    }




}








