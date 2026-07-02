<?php

namespace Zerp\Slack\Listeners;

use Zerp\Slack\Services\SendMsg;
use Zerp\Taskly\Events\CreateTaskComment;
use Zerp\Taskly\Models\ProjectTask;

class CreateTaskCommentLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateTaskComment $event)
    {
        $comment = $event->comment;

        if (company_setting('Slack New Task Comment') == 'on') {
            $task = ProjectTask::where('id',$comment->task_id)->first();

                $uArr = [
                    'task_name' => $task->title,
                ];

            SendMsg::SendMsgs($uArr, 'New Task Comment');
        }
    }
}