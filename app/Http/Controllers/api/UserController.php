<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Http\Requests\RegisterUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(RegisterUser $request)
    {
        try {
            $user = new User();
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = $request->status;
            $user->photo;
            $user->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur ajouté avec succès',
                'Utilisateur' => $user,
            ]);
        } catch (\Exception $e) {
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
             'status_message' => 'Utilisateur connecté avec succes',
             'Utilisateur'=>$user,
             'token'=>$token,
         ]);
     }else{
         return response()->json([
             'status_code' => 403,
             'status_message' => 'Infromation d\'authentification incorrecte',

         ]);
     }

     // try{
     //     $user=User::where('email',request('email'))->first();
     //     $token=$user->createToken('auth_token')->plainTextToken;
     //     return response()->json([
     //         'status_code' => 200,
     //         'status_message' => 'Utilisateur connecté avec succes',
     //         'Utilisateur'=>$user,
     //         'token'=>$token,
     //     ]);
     // }catch(Exception $e){

     // }
    }

}


// <?php

// namespace App\Http\Controllers;

// use App\Http\Requests\RegisterUser; // Correction de l'importation
// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;

// class UserController extends Controller
// {

//     //     public function login(Request $request)
//     //     {
//     //         $request->validate([
//     //             'email' => 'required|string|email',
//     //             'password' => 'required|string',
//     //         ]);

//     //         if (!Auth::attempt($request->only('email', 'password'))) {
//     //             return response()->json(['message' => 'Invalid login details'], 401);
//     //         }

//     //         $user = User::where('email', $request->email)->firstOrFail();
//     //         $token = $user->createToken('auth_token')->plainTextToken;

//     //         return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
//     //     }

//     //     public function logout(Request $request)
//     //     {
//     //         $request->user()->tokens()->delete();

//     //         return response()->json(['message' => 'Logged out successfully']);
//     //     }

// }
