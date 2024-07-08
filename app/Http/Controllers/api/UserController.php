<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Http\Requests\RegisterUser;
use App\Models\roles;
use App\Models\User;
use Exception;

use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Http\Client\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function register(RegisterUser $request)
    {
        try {
            // Check if photo exists before processing it
            $imageName = null;
            if ($request->hasFile('photo')) {
                $imageName = Str::random(32) . "." . $request->photo->getClientOriginalExtension();
                Storage::disk('public_images')->put($imageName, file_get_contents($request->photo));
            }

            // Create new user
            $user = new User();
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = $request->status;
            $user->photo = $imageName;
            $user->role_id = $request->role_id;
            $user->save();
            $role = roles::find($request->role_id);
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur ajouté avec succès',
                'Utilisateur' => $user,
                'role' => $role ? $role->name : null, // Include role name in the response
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de l\'ajout de l\'utilisateur',
                'error' => $e->getMessage(),
            ]);
        }
    }
    public function login(loginRequest $request)
    {
     if(auth()->attempt($request->only(['email','password'])))
     {
         $user=auth()->user();
         $token=$user->createToken('auth_token')->plainTextToken;
         return response()->json([
             'status_code' => 200,
             'status_message' => 'User connecté en tant que'.' '.$user->role->name,
             'Utilisateur'=>$user,
             'token'=>$token,
         ]);
     }else{
         return response()->json([
             'status_code' => 403,
             'status_message' => 'Infromation d\'authentification incorrecte',

         ]);
     }
    }
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete(); // Supprime tous les jetons de l'utilisateur

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Déconnexion réussie',
                'user'=>$user,
            ]);
        } else {
            return response()->json([
                'status_code' => 401,
                'status_message' => 'Utilisateur non authentifié'
            ], 401);
        }
    }


}


