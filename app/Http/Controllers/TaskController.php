<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Mail\TaskNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TaskController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:en cours,terminée,suspendue',
            'user_id' => 'nullable|exists:users,id',
            'files.*' => 'nullable|file|mimes:pdf,docx,xlsx,jpg,png|max:2048',
        ]);

        $task = $project->tasks()->create($validatedData);

        // Ajouter les fichiers attachés
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $task->addMedia($file)->toMediaCollection();
            }
        }

        // Envoi d'un e-mail si la tâche est assignée
        if ($request->user_id && $request->user_id != $task->user_id) {
            $user = \App\Models\User::find($request->user_id);
            if ($user) {
                Mail::to($user->email)->send(new TaskNotification($task, "Une nouvelle tâche vous a été assignée."));
            }
        }

        return redirect()->back()->with('success', 'Tâche ajoutée avec succès.');
    }


    public function show(Project $project, Task $task)
    {
        return view('tasks.show', compact('project', 'task'));
    }



    public function edit(Project $project, Task $task)
    {
        // Vérifier si l'utilisateur est bien associé au projet
        if (!$project->users->contains(auth()->user())) {
            return redirect()->route('projects.index')->with('error', 'Vous n\'êtes pas autorisé à modifier cette tâche.');
        }

        return view('tasks.edit', compact('task', 'project'));
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:en cours,terminée,suspendue',
            'user_id' => 'nullable|exists:users,id',
            'files.*' => 'nullable|file|mimes:pdf,docx,xlsx,jpg,png|max:2048',
        ]);

        $task->update($validatedData);

        // Ajouter de nouveaux fichiers
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $task->addMedia($file)->toMediaCollection();
            }
        }

        // Envoi d'un e-mail si la tâche est assignée
        if ($request->user_id && $request->user_id != $task->user_id) {
            $user = \App\Models\User::find($request->user_id);
            if ($user) {
                Mail::to($user->email)->send(new TaskNotification($task, "Une nouvelle tâche vous a été assignée."));
            }
        }

        return redirect()->route('projects.show', $project)->with('success', 'Tâche mise à jour.');
    }

    public function destroy(Project $project, Task $task)
    {
        if ($task->file) {
            Storage::delete($task->file);
        }

        $task->delete();
        return redirect()->back()->with('success', 'Tâche supprimée.');
    }

    public function markAsCompleted(Task $task)
    {
        $task->update(['status' => 'terminée']);
        return redirect()->back()->with('success', 'Tâche marquée comme terminée.');
    }


    public function destroyFile(Task $task, Media $file)
    {
        $file->delete();
        return redirect()->back()->with('success', 'Fichier supprimé avec succès.');
    }



    public function download(Project $project, Task $task, int $fileIndex = null)
    {
        if (!$project || !$task ) {
            return back()->with('error', 'Fichier introuvable.');
        }
        $mediaItems = $task->getMedia();
        $fullPathOnDisk = $mediaItems[$fileIndex]->getPath();

 
        return response()->download($fullPathOnDisk);
    }
}
