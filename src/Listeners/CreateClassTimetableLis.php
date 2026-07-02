<?php

namespace Zerp\Slack\Listeners;

use Zerp\School\Events\CreateClassTimetable;
use Zerp\School\Models\SchoolClass;
use Zerp\Slack\Services\SendMsg;

class CreateClassTimetableLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateClassTimetable $event)
    {
        $timetable = $event->timetable;
        $class = SchoolClass::find($timetable->class_id);

        if (company_setting('Slack New Time Table') == 'on') {
            $uArr = [
                'class_name' => $class->name
            ];

            SendMsg::SendMsgs($uArr, 'New Time Table');
        }
    }
}