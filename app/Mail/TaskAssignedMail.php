<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;

    /**
     * Create a new message instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('New Task Assigned: ' . $this->task->title)
            ->view('emails.task_assigned')
            ->with([
                'taskTitle' => $this->task->title,
                'taskDescription' => $this->task->description,
                'taskDeadline' => $this->task->deadline,
            ]);
    }
}
