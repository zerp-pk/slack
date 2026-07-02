<?php

namespace Zerp\Slack\Listeners;

use Zerp\Account\Events\CreateCustomer;
use Zerp\Slack\Services\SendMsg;

class CreateCustomerLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateCustomer $event)
    {
        if (company_setting('Slack New Customer') == 'on') {
            $uArr = [];
            SendMsg::SendMsgs($uArr, 'New Customer');
        }
    }
}