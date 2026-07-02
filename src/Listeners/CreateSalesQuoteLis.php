<?php

namespace Zerp\Slack\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Zerp\Sales\Events\CreateSalesQuote;
use Zerp\Slack\Services\SendMsg;

class CreateSalesQuoteLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateSalesQuote $event)
    {
        $quote = $event->quote;
        if (company_setting('Slack New Quote') == 'on') {
            $uArr = [
                'quotation_id' => $quote->quote_number,
            ];

            SendMsg::SendMsgs($uArr, 'New Quote');
        }
    }
}