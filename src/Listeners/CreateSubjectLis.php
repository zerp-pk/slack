<?php

namespace Zerp\Slack\Listeners;

use Zerp\School\Events\CreateSubject;
use Zerp\School\Models\SchoolClass;
use Zerp\Slack\Services\SendMsg;

class CreateSubjectLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateSubject $event)
    {
        $subject = $event->subject;
        
        if (company_setting('Slack New Subject') == 'on') {
            $uArr = [
                'subject_name' => $subject->name,
            ];

            SendMsg::SendMsgs($uArr, 'New Subject');
        }
    }
}