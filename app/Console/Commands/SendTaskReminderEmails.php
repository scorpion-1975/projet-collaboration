<?php

namespace App\Console\Commands;

use App\Mail\TaskNotification;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskReminderEmails extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Envoyer des rappels par e-mail pour les tâches arrivant à échéance demain';

    public function handle()
    {
        $tasks = Task::whereDate('due_date', Carbon::tomorrow())->get();

        foreach ($tasks as $task) {
            if ($task->user) {
                Mail::to($task->user->email)->send(new TaskNotification($task, "Votre tâche \"{$task->title}\" arrive à échéance demain."));
            }
        }

        $this->info('Les rappels de tâches ont été envoyés avec succès.');
    }
}
