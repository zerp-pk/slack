<?php

namespace Zerp\Slack\Listeners;

use Zerp\Sales\Events\CreateSalesMeeting;
use Zerp\Slack\Services\SendMsg;

class CreateSalesMeetingLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateSalesMeeting $event)
    {
        $request = $event->meeting;

        if (company_setting('Slack Meeting Assigned') == 'on') {
            $uArr = [
                'meeting_name' => $request->name
            ];

            SendMsg::SendMsgs($uArr, 'Meeting Assigned');
        }
    }
}