<?php

namespace Zerp\Slack\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Zerp\InnovationCenter\Events\CreateCategory;
use Zerp\Slack\Services\SendMsg;

class CreateCategoryLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateCategory $event)
    {
        $CreativityCategories = $event->category;

        if (company_setting('Slack New Category') == 'on') {
            $uArr = [
                'name'=> $CreativityCategories->name
            ];

            SendMsg::SendMsgs($uArr, 'New Category');
        }
    }
}   