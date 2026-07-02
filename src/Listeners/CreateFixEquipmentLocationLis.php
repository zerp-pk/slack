<?php

namespace Zerp\Slack\Listeners;

use Zerp\FixEquipment\Events\CreateFixEquipmentLocation;
use Zerp\Slack\Services\SendMsg;

class CreateFixEquipmentLocationLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateFixEquipmentLocation $event)
    {
       $location = $event->fixEquipmentLocation;

        if (company_setting('Slack New Fix Equipment Location') == 'on') {
            $uArr = [
                'location_name' => $location->name
            ];

            SendMsg::SendMsgs($uArr, 'New Fix Equipment Location');
        }
    }
}