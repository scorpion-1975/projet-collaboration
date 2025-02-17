<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Mail\TaskNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:en cours,terminée,suspendue',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048'
        ]);

        $filePath = $request->file('file') ? $request->file('file')->store('tasks') : null;

        // dd($filePath);
        $task = $project->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'file' => $filePath,
            'user_id' => $request->user_id
        ]);

         // Envoi d'un e-mail si la tâche est assignée
         if ($request->user_id && $request->user_id != $task->user_id) {
            $user = \App\Models\User::find($request->user_id);
            if ($user) {
                Mail::to($user->email)->send(new TaskNotification($task, "Une nouvelle tâche vous a été assignée."));
            }
        }

        return redirect()->back()->with('success', 'Tâche ajoutée avec succès.');
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:en cours,terminée,suspendue',
            'file' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048'
        ]);

        if ($request->hasFile('file')) {
            if ($task->file) {
                Storage::delete($task->file);
            }
            $task->file = $request->file('file')->store('tasks');
        }

        $task->update($request->except(['file']));

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
}
