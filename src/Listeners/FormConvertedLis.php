<?php

namespace Zerp\Slack\Listeners;

use Zerp\FormBuilder\Events\FormConverted;
use Zerp\Slack\Services\SendMsg;

class FormConvertedLis
{
    public function __construct()
    {
        //
    }

    public function handle(FormConverted $event)
    {
        if (company_setting('Slack Convert To Modal') == 'on') {
            $uArr = [];

            SendMsg::SendMsgs($uArr, 'Convert To Modal');
        }
    }
}