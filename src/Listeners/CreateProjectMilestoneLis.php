<?php

namespace Zerp\Slack\Listeners;

use Zerp\Slack\Services\SendMsg;
use Zerp\Taskly\Events\CreateProjectMilestone;

class CreateProjectMilestoneLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateProjectMilestone $event)
    {
        if (company_setting('Slack New Milestone') == 'on') {
            $uArr = [];
            SendMsg::SendMsgs($uArr, 'New Milestone');
        }
    }
}