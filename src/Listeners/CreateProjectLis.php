<?php

namespace Zerp\Slack\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Zerp\Slack\Services\SendMsg;
use Zerp\Taskly\Events\CreateProject;

class CreateProjectLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateProject $event)
    {
        $project = $event->project;

        if (company_setting('Slack New Project') == 'on') {
            $uArr = [
                'project_name' => $project->name
            ];

            SendMsg::SendMsgs($uArr, 'New Project');
        }
    }
}