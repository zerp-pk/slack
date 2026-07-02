<?php

namespace Zerp\Slack\Listeners;

use Zerp\Recruitment\Events\ConvertOfferToEmployee;
use Zerp\Slack\Services\SendMsg;

class ConvertOfferToEmployeeLis
{
    public function __construct()
    {
        //
    }

    public function handle(ConvertOfferToEmployee $event)
    {
        if (company_setting('Slack Convert To Employee')  == 'on') {
            $uArr =  [];
            SendMsg::SendMsgs($uArr, 'Convert To Employee');
        }
    }
}