<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::where('user_id', auth()->id())->latest()->get();

        return view('projects.index', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::with('tasks', 'users')->findOrFail($id); // Assurez-vous que les tâches et utilisateurs sont récupérés
        return view('projects.show', compact('project'));
    }




    public function create()
    {
        if ( auth()->check() && auth()->user()->roles->isNotEmpty() && auth()->user()->roles->first()->name != 'admin') {
            abort(403, 'Unauthorized');
        }

        return view('projects.create');
    }

    public function store(Request $request)
    {

        if ( auth()->check() && auth()->user()->roles->isNotEmpty() && auth()->user()->roles->first()->name != 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'string',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
        ]);

        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'en attente',
            'user_id' => auth()->id(),
        ]);

        // Ajouter l'utilisateur créateur comme admin du projet
        $project->users()->attach(Auth::id(), ['role' => 'admin']);

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès !');
    }

    public function showInviteForm(Project $project)
    {
        // $this->authorize('update', $project); // Seul le créateur peut inviter
        $users = User::where('id', '!=', auth()->id())->get();
        return view('projects.invite', compact('project', 'users'));
    }


    // Ajouter un utilisateur à un projet

    public function inviteUser(Request $request, Project $project)
    {

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:admin,membre',
        ]);

        $user = User::findOrFail($validated['user_id']);

        if ($project->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Cet utilisateur fait déjà partie du projet.');
        }

        $project->users()->attach($user->id, ['role' => $validated['role']]);

        return redirect()->route('projects.index')->with('success', 'Utilisateur invité avec succès !');
    }


    // Changer le statut du projet
    public function updateStatus(Request $request, $projectId)
    {

        $project = Project::findOrFail($projectId);

        // Validation du statut
        $request->validate([
            'status' => 'required|in:en cours,terminé,en attente',
        ]);

        // Mise à jour du statut
        $project->status = $request->status;
        $project->save();

        return redirect()->back()->with('success', 'Statut du projet mis à jour avec succès.');
    }
}
