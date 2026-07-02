<?php

namespace Zerp\Slack\Listeners;

use Workdo\Retainer\Events\CreateRetainerPayment;
use Zerp\Slack\Services\SendMsg;

class CreateRetainerPaymentLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateRetainerPayment $event)
    {
        if (company_setting('Slack New Retainer Payment')  == 'on') {
            $uArr = [];

            SendMsg::SendMsgs($uArr, 'New Retainer Payment');
        }
    }
}