<?php

namespace Spqr\Security\Event;

use Pagekit\Application as App;
use Pagekit\Event\EventSubscriberInterface;
use Pagekit\Kernel\Exception\ForbiddenException;
use Pagekit\Kernel\Exception\UnauthorizedException;
use Pagekit\Kernel\Exception\NotFoundException;
use Spqr\Security\Model\Ban;
use Spqr\Security\Helper\EntryHelper;


/**
 * Class RouteListener
 *
 * @package Spqr\Security\Event
 */
class RouteListener implements EventSubscriberInterface
{
    
    /**
     * @param $event
     * @param $request
     */
    public function onRequest($event, $request)
    {
        $client_ip = App::request()->getClientIp();
        $config    = App::module('spqr/security')->config();
        
        if ($banned = Ban::where(['status = ?', 'ip = ?'],
            [Ban::STATUS_ACTIVE, $client_ip])->first()
        ) {
            if (!in_array($client_ip, $config['whitelist'])) {
                App::abort(401, __('You are banned!'));
            }
        }
    }
    
    /**
     * @param $event
     * @param $request
     */
    public function onException($event, $request)
    {
        $config = App::module('spqr/security')->config();
        $helper = new EntryHelper();
        
        $exception = $event->getException();
        $url       = $request->getRequestUri();
        $ip        = App::request()->getClientIp();
        $referrer  = (App::request()->headers->get('referer')
            ? App::request()->headers->get('referer') : App::url()->current());
        
        if ($config['jails']['honeypot']['enabled'] == true) {
            if ($exception instanceof NotFoundException) {
                $honeypots = $config['jails']['honeypot']['honeypots'];
                foreach ($honeypots as $honeypot) {
                    if (stripos(strtolower($url), strtolower($honeypot))
                        !== false
                    ) {
                        $helper->createEntry($ip, $referrer, 'honeypot');
                    }
                }
            }
        }
        
        if ($config['jails']['forbidden']['enabled'] == true) {
            if ($exception instanceof ForbiddenException) {
                $helper->createEntry($ip, $referrer, 'forbidden');
            }
        }
    
        if ($config['jails']['unauthorized']['enabled'] == true) {
            if ($exception instanceof UnauthorizedException) {
                $helper->createEntry($ip, $referrer, 'unauthorized');
            }
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'request' => ['onRequest', -150],
            'exception' => ['onException', -150],
        ];
    }
}