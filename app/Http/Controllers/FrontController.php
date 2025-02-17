<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Projets en cours
        $ongoingProjects = Project::where('status', 'en_cours')->where('user_id', $user->id)->count();

        // Tâches en retard
        $overdueTasks = Task::where('due_date', '<', Carbon::now())
            ->where('status', '!=', 'terminée')
            ->where('user_id', $user->id)
            ->count();

        // Progression moyenne (ici, calcul basique basé sur le pourcentage de progression des projets)
        $averageProgress = Project::where('user_id', $user->id)
            ->avg('progress'); // Assurez-vous d'avoir un champ `progress` pour la progression.

        // Projets actifs
        $activeProjects = Project::where('status', 'actif')
            ->where('user_id', $user->id)
            ->get();

        // Tâches imminentes (dans les prochaines 48 heures)
        $upcomingTasks = Task::where('due_date', '<=', Carbon::now()->addHours(48))
            ->where('status', '!=', 'terminée')
            ->where('user_id', $user->id)
            ->get();

        return view('pages.index', compact('ongoingProjects', 'overdueTasks', 'averageProgress', 'activeProjects', 'upcomingTasks'));
    }
}
