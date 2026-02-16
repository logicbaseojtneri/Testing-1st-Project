<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    protected $signature = 'app:send-task-reminders';

    protected $description = 'Send daily notifications for upcoming deadlines and overdue tasks to customers and developers';

    public function handle(): int
    {
        $this->sendUpcomingDeadlineReminders();
        $this->sendOverdueReminders();

        return self::SUCCESS;
    }

    /**
     * Notify customer & developer about tasks whose deadline is tomorrow.
     */
    private function sendUpcomingDeadlineReminders(): void
    {
        $tomorrow = Carbon::tomorrow();

        $tasks = Task::whereNotNull('deadline')
            ->where('status', '!=', 'done')
            ->whereDate('deadline', $tomorrow)
            ->get();

        $count = 0;

        foreach ($tasks as $task) {
            $deadlineFormatted = $task->deadline->format('M d, Y h:i A');

            // Notify customer (creator)
            if ($task->created_by) {
                $this->createIfNotDuplicate(
                    $task->created_by,
                    'Upcoming Deadline',
                    "Task \"{$task->title}\" is due tomorrow ({$deadlineFormatted}). Please ensure it's on track.",
                    'deadline_reminder',
                    $task->id,
                );
                $count++;
            }

            // Notify developer (assignee)
            if ($task->assigned_to && $task->assigned_to !== $task->created_by) {
                $this->createIfNotDuplicate(
                    $task->assigned_to,
                    'Upcoming Deadline',
                    "Task \"{$task->title}\" is due tomorrow ({$deadlineFormatted}). Please make sure to complete it on time.",
                    'deadline_reminder',
                    $task->id,
                );
                $count++;
            }
        }

        $this->info("Sent {$count} upcoming-deadline reminders.");
    }

    /**
     * Notify customer & developer about overdue tasks (once per day).
     */
    private function sendOverdueReminders(): void
    {
        $now = Carbon::now();

        $tasks = Task::whereNotNull('deadline')
            ->where('status', '!=', 'done')
            ->where('deadline', '<', $now)
            ->get();

        $count = 0;

        foreach ($tasks as $task) {
            $daysOverdue = (int) $task->deadline->diffInDays($now);
            $label = $daysOverdue === 1 ? '1 day' : "{$daysOverdue} days";

            // Notify customer (creator)
            if ($task->created_by) {
                $this->createIfNotDuplicate(
                    $task->created_by,
                    'Task Overdue',
                    "Task \"{$task->title}\" is overdue by {$label}. Please follow up.",
                    'overdue_reminder',
                    $task->id,
                );
                $count++;
            }

            // Notify developer (assignee)
            if ($task->assigned_to && $task->assigned_to !== $task->created_by) {
                $this->createIfNotDuplicate(
                    $task->assigned_to,
                    'Task Overdue',
                    "Task \"{$task->title}\" is overdue by {$label}. Please prioritize this task.",
                    'overdue_reminder',
                    $task->id,
                );
                $count++;
            }
        }

        $this->info("Sent {$count} overdue reminders.");
    }

    /**
     * Only create the notification if one with the same type+task wasn't already
     * sent today (avoids duplicates when the command runs more than once).
     */
    private function createIfNotDuplicate(int $userId, string $title, string $message, string $type, int $taskId): void
    {
        $alreadySent = Notification::where('user_id', $userId)
            ->where('type', $type)
            ->where('related_id', $taskId)
            ->where('related_type', 'task')
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($alreadySent) {
            return;
        }

        Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'related_id' => $taskId,
            'related_type' => 'task',
        ]);
    }
}
