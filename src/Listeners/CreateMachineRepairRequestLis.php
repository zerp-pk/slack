<?php

namespace Zerp\Slack\Listeners;

use Zerp\MachineRepairManagement\Events\CreateMachineRepairRequest;
use Zerp\MachineRepairManagement\Models\Machine;
use Zerp\Slack\Services\SendMsg;

class CreateMachineRepairRequestLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateMachineRepairRequest $event)
    {
        $repair_request = $event->machinerepairrequest;
        $machine = Machine::find($repair_request->machine_id);
        
        if (company_setting('Slack New Repair Request') == 'on') {
            $uArr = [
                'machine_name' => $machine->machine_name
            ];

            SendMsg::SendMsgs($uArr, 'New Repair Request');
        }
    }
}