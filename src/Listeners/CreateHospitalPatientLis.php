<?php

namespace Zerp\Slack\Listeners;

use Workdo\HospitalManagement\Events\CreateHospitalPatient;
use Zerp\Slack\Services\SendMsg;

class CreateHospitalPatientLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateHospitalPatient $event)
    {
        $patient = $event->hospitalpatient;

        if (company_setting('Slack New Patient') == 'on') {
            $uArr = [
                'patient_name' => $patient->name
            ];
            SendMsg::SendMsgs($uArr, 'New Patient');
        }
    }
}