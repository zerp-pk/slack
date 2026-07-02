<?php

namespace Zerp\Slack\Listeners;

use Zerp\Account\Events\CreateVendor;
use Zerp\Slack\Services\SendMsg;

class CreateVendorLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateVendor $event)
    {
        if (company_setting('Slack New Vendor') == 'on') {
            $uArr = [];
            SendMsg::SendMsgs($uArr, 'New Vendor');
        }
    }
}