<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        // dd($user);
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Profil utilisateur récupéré avec succès',
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $imageName = null;
        if ($request->hasFile('photo')) {
            $imageName = Str::random(5) . "." . $request->photo->getClientOriginalExtension();
            Storage::disk('public_storage')->put($imageName, file_get_contents($request->photo));
        }

        // Validation des données
        $request->validate([
            'firstname' => 'sometimes|required|string',
            'lastname' => 'sometimes|required|string',
            'pays' => 'sometimes|required|string',
            'ville' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
            // 'password' => 'sometimes|required|string|min:6',
            'metier' => 'sometimes|required|string',
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Mise à jour des données utilisateur
        $user->firstname = $request->firstname ?? $user->firstname;
        $user->lastname = $request->lastname ?? $user->lastname;
        $user->pays = $request->pays ?? $user->pays;
        $user->ville = $request->ville ?? $user->ville;
        $user->email = $request->email ?? $user->email;
        // $user->password = Hash::make($request->password) ?? $user->password;
        $user->metier = $request->metier ?? $user->metier;
        $user->photo = $imageName ?? $user->photo;
        $user->save();


        return response()->json([
            'status_code' => 200,
            'status_message' => 'Profil utilisateur mis à jour avec succès',
            'user' => $user,
        ]);
    }
}
