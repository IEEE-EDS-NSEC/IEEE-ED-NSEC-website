<?php

namespace Spqr\Security\Event;

use Pagekit\Application as App;
use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Blog\Model\Comment;
use Spqr\Security\Helper\EntryHelper;

/**
 * Class CommentListener
 *
 * @package Spqr\Security\Event
 */
class CommentListener implements EventSubscriberInterface
{
    /**
     * @param                             $event
     * @param \Pagekit\Blog\Model\Comment $comment
     * @param                             $request
     */
    public function onCommentSaved($event, Comment $comment, $request)
    {
        $config = App::module('spqr/security')->config();
        $helper = new EntryHelper();
        if ($config['jails']['spam']['enabled'] == true) {
            
            if (App::module('blog')) {
                if ($request['status'] == Comment::STATUS_SPAM) {
                    $ip       = $comment->ip;
                    $referrer = App::url('@blog/id',
                        ['id' => $comment->post_id ? : 0], 'base');
                    $helper->createEntry($ip, $referrer, 'spam');
                }
            }
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'model.comment.saved' => 'onCommentSaved',
        ];
    }
    
}