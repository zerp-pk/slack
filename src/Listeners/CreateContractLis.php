<?php

namespace Zerp\Slack\Listeners;

use Zerp\Contract\Events\CreateContract;
use Zerp\Contract\Models\Contract;
use Zerp\Slack\Services\SendMsg;

class CreateContractLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateContract $event)
    {
        $contract = $event->contract;

        if (company_setting('Slack New Contract') == 'on') {
            $uArr = [
                'contract_number' => $contract->contract_number,
            ];

            SendMsg::SendMsgs($uArr, 'New Contract');
        }
    }
}
