<?php

namespace Zerp\Slack\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Zerp\Retainer\Events\CreateRetainer;
use Zerp\Slack\Services\SendMsg;

class CreateRetainerLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateRetainer $event)
    {
        $retainer = $event->retainer;

        if (company_setting('Slack Create Retainer')  == 'on') {
            $uArr = [
                'retainer_id' => $retainer->retainer_number,
            ];

            SendMsg::SendMsgs($uArr, 'Create Retainer');
        }
    }
}