<?php

namespace Zerp\Slack\Listeners;

use Zerp\Internalknowledge\Events\CreateInternalknowledgeArticle;
use Zerp\Internalknowledge\Models\InternalknowledgeBook;
use Zerp\Slack\Services\SendMsg;

class CreateInternalknowledgeArticleLis
{
    public function __construct()
    {
        //
    }

    public function handle(CreateInternalknowledgeArticle $event)
    {
        $article = $event->internalknowledgeArticle;
        $book = InternalknowledgeBook::find($article->internalknowledge_book_id);

        if (company_setting('Slack New Article') == 'on') {
            $uArr = [
                'article_type' => $article->type,
                'book_name' => !empty($book) ? $book->title : '-', 
            ];

            SendMsg::SendMsgs($uArr, 'New Article');
        }
    }
}   