<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback; // Ajoutez cette ligne
use Illuminate\Support\Facades\Auth; // Ajoutez cette ligne pour utiliser auth()


class FeedbackController extends Controller 
{
    public function index()
    {
        // Code pour lister des ressources
    }

    public function show($id)
    {
        // Code pour montrer une ressource spécifique
    }

    public function store(Request $request)
{
    // Validation des données
    $request->validate([
        'hackathon_id' => 'required|exists:hackathons,id',  // Ajoutez une vérification pour l'existence du hackathon
        'content' => 'required',
    ]);

    // Création d'un nouvel objet Feedback
    $addFeedback = new Feedback();  // Remplacez `feedback` par `Feedback`
    $addFeedback->hackathon_id = $request->hackathon_id;
    $addFeedback->content = $request->content;
    $addFeedback->user_id = auth()->check() ? auth()->user()->id : null; // Assurez-vous d'utiliser = au lieu de ==

    if ($addFeedback->user_id === null) {
        return response()->json([
            'message' => 'Utilisateur non authentifié',
        ], 401);
    }

    // Sauvegarde du feedback
    $addFeedback->save();

    // Retourne une réponse JSON
    return response()->json([
        'message' => 'Feedback ajouté avec succès',
        'feedback' => $addFeedback,
    ], 201);
}

    public function update(Request $request, $id)
    {
        // Code pour mettre à jour une ressource existante
    }

    public function destroy($id)
    {
        // Code pour supprimer une ressource
    }
}
