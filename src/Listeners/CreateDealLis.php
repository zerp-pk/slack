<?php

namespace Zerp\Slack\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Zerp\Lead\Events\CreateDeal;
use Zerp\Slack\Services\SendMsg;

class CreateDealLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateDeal $event)
    {
        if (company_setting('Slack New Deal') == 'on') {
            $uArr = [];

            SendMsg::SendMsgs($uArr, 'New Deal');
        }
    }
}