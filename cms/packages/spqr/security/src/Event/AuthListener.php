<?php

namespace Spqr\Security\Event;

use Pagekit\Application as App;
use Pagekit\Auth\Event\AuthenticateEvent;
use Pagekit\Event\EventSubscriberInterface;
use Spqr\Security\Helper\EntryHelper;

/**
 * Class AuthListener
 *
 * @package Spqr\Security\Event
 */
class AuthListener implements EventSubscriberInterface
{
    /**
     * @param \Pagekit\Auth\Event\AuthenticateEvent $event
     */
    public function onAuthFailure(AuthenticateEvent $event)
    {
        $config = App::module('spqr/security')->config();
        $helper = new EntryHelper();
        
        if ($config['jails']['login']['enabled'] == true) {
            $ip       = App::request()->getClientIp();
            $referrer = (App::request()->headers->get('referer')
                ? App::request()->headers->get('referer') : App::url()
                    ->current());
            $helper->createEntry($ip, $referrer, 'login');
        }
    }
    
    /**
     * @param \Pagekit\Auth\Event\AuthenticateEvent $event
     */
    public function onAuthSuccess(AuthenticateEvent $event)
    {
        
        $config = App::module('spqr/security')->config();
        $helper = new EntryHelper();
        
        if ($config['jails']['login']['enabled'] == true) {
            
            $ip       = App::request()->getClientIp();
            $referrer = (App::request()->headers->get('referer')
                ? App::request()->headers->get('referer') : App::url()
                    ->current());
            
            $helper->createEntry($ip, $referrer, 'login', ['result' => true]);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'auth.failure' => 'onAuthFailure',
            'auth.success' => 'onAuthSuccess',
        ];
    }
}