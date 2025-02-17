<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $message;

    public function __construct(Task $task, $message)
    {
        $this->task = $task;
        $this->message = $message;
    }

    public function build()
    {
        return $this->subject('Notification de tâche')
                    ->view('emails.task_notification')
                    ->with([
                        'task' => $this->task,
                        'message' => $this->message,
                    ]);
    }
}
