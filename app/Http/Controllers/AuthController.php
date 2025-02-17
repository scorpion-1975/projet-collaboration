<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Affichage du formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('pages.pages-register'); // Assurez-vous que cette vue existe
    }

    // Traitement de l'inscription
    public function register(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'terms' => ['accepted'],
        ]);

        // Si la validation échoue, renvoie les erreurs
        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);



            // On attribue le rôle membre
            $memberRole = Role::where('name', 'membre')->first();
            $user->roles()->attach($memberRole);



        // Redirection après l'inscription réussie (par exemple vers la page de connexion)
        return redirect()->route('login')->with('success', 'Your account has been created successfully!');
    }


    // Affichage du formulaire de connexion
    public function showLoginForm()
    {
        return view('pages.pages-login'); // Assurez-vous que cette vue existe
    }

    // Traitement de la connexion
    public function login(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'exists:users,username'], // Vérifie si le username existe dans la table users
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Si la validation échoue, renvoie les erreurs
        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }
        // dd($validator);

        // Authentification de l'utilisateur
        $credentials = $request->only('username', 'password');

        // dd($credentials);
        if (Auth::attempt($credentials, $request->remember)) {
            // Si l'authentification est réussie, redirige l'utilisateur
            return redirect()->route('panel'); // Redirige vers le tableau de bord ou une autre page protégée
        }

        // Si l'authentification échoue, retour avec un message d'erreur
        return redirect()->route('login')
            ->withErrors(['username' => 'The provided credentials are incorrect.'])
            ->withInput();
    }




    public function profile()
    {

        return view('pages.users-profile'); // Rediriger vers la page d'accueil ou une autre page
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login'); // Rediriger vers la page d'accueil ou une autre page
    }
}
