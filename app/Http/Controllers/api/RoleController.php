<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\roles;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
     // Afficher la liste des rôles
    public function index()
    {
        try{
            $roles = roles::all();
        return response()->json([
            'roles' => $roles,
           'message' => 'Rôles récupérés avec succès'
        ]);
        }catch(Exception $e){
            return response()->json([
               'message' => 'Erreur lors de la récupération des rôles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Créer un nouveau rôle
    public function store(Request $request)
    {
      try{
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
        ]);

        $role = roles::create([
            'name' => $request->name,
        ]);
        return response()->json([
            'role' => $role,
           'message' => 'Rôle créé avec succès',
           $role, 201
        ]);
      }catch(Exception $e){
        return response()->json([
           'message' => 'Erreur lors de la création du rôle',
            'error' => $e->getMessage()
        ], 500);
      }
    }

    // Afficher un rôle spécifique
    public function show($id)
    {
        try{
         $role = roles::findOrFail($id);
        return response()->json([
            'role' => $role,
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

        $role = roles::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'role' => $role,
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
        $role = roles::findOrFail($id);
        $role->delete();

        return response()->json([
            'role' => $role,
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
