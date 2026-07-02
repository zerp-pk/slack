<?php

namespace Zerp\Slack\Listeners;

use Zerp\Slack\Services\SendMsg;
use Zerp\Taskly\Events\CreateProjectTask;
use Zerp\Taskly\Models\Project;

class CreateProjectTaskLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateProjectTask $event)
    {
        $task = $event->task;
        $project = Project::where('id', $task->project_id)->first();
        
        if (company_setting('Slack New Task') == 'on') {
            $uArr = [
                'task_name' => $task->title,
                'project_name' => $project->name
            ];

            SendMsg::SendMsgs($uArr, 'New Task');
        }
    }
}
