<?php

namespace Zerp\Slack\Listeners;

use Zerp\FormBuilder\Events\CreateForm;
use Zerp\Slack\Services\SendMsg;

class CreateFormLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateForm $event)
    {
        if (company_setting('Slack New Form') == 'on') {
            $form = $event->form;

            $uArr = [
               'name' => $form->name
            ];

            SendMsg::SendMsgs($uArr, 'New Form');
        }
    }
}