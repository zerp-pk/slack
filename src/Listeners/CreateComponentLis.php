<?php

namespace Zerp\Slack\Listeners;

use Zerp\CMMS\Events\CreateComponent;
use Zerp\Slack\Services\SendMsg;

class CreateComponentLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateComponent $event)
    {
        $request = $event->request;
        $component = $request->name;

        if (company_setting('Slack New Component') == 'on') {
            $uArr = [
                'component_name' => $component,
            ];

            SendMsg::SendMsgs($uArr, 'New Component');
        }
    }
}
