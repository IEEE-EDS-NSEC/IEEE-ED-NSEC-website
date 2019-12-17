<?php

namespace Spqr\Security\Event;

use Pagekit\Application as App;
use Pagekit\Event\EventSubscriberInterface;
use Spqr\Security\Model\Entry;
use Spqr\Security\Model\Ban;

/**
 * Class EntryListener
 *
 * @package Spqr\Security\Event
 */
class EntryListener implements EventSubscriberInterface
{
    /**
     * @param                                   $event
     * @param \Spqr\Security\Model\Entry        $entry
     */
    public function onEntrySaved($event, Entry $entry)
    {
        $config = App::module('spqr/security')->config();
        
        switch ($entry->event) {
            case "login":
                $limit  = $config['jails']['login']['attempts'];
                $jail   = 'login';
                $reason = __('Too much login attempts');
                break;
            case "forbidden":
                $limit  = $config['jails']['forbidden']['attempts'];
                $jail   = 'forbidden';
                $reason = __('Entered too many forbidden URLs');
                break;
            case "unauthorized":
                $limit  = $config['jails']['unauthorized']['attempts'];
                $jail   = 'unauthorized';
                $reason = __('Entered too many unauthorized URLs');
                break;
            case "honeypot":
                $limit  = $config['jails']['honeypot']['attempts'];
                $jail   = 'honeypot';
                $reason = __('Entered honeypot URL');
                break;
            case "spam":
                $limit  = $config['jails']['spam']['attempts'];
                $jail   = 'spam';
                $reason = __('Spamming');
                break;
            default:
                $limit  = $config['jails']['login']['attempts'];
                $jail   = 'default';
                $reason = __('Default action');
                break;
        }
        
        $entries = Entry::where(['ip = ?', 'event = ?'],
            [$entry->ip, $entry->event])->limit($limit)->orderBy('date', 'DESC')
            ->get();
        
        if ($this->continuityCount($entries, $limit)) {
            if (!Ban::where(['ip = ?'], [$entry->ip])->first()) {
                $ban = Ban::create([
                        'ip'     => $entry->ip,
                        'status' => Ban::STATUS_ACTIVE,
                        'reason' => $reason,
                        'jail'   => $jail,
                        'date'   => new \DateTime,
                    ]);
                
                $ban->save();
            }
        } else {
            $bans = Ban::where(['status = ?', 'ip = ?', 'jail = ?'], [
                    Ban::STATUS_ACTIVE,
                    $entry->ip,
                    $entry->event,
                ])->get();
            
            foreach ($bans as $ban) {
                $ban->status = Ban::STATUS_ARCHIVED;
                $ban->save();
            }
        }
    }
    
    /**
     * @param $entries
     * @param $limit
     *
     * @return bool
     */
    protected function continuityCount($entries, $limit)
    {
        $counter = 0;
        
        foreach ($entries as $res) {
            if ($res->data['result'] == false) {
                $counter++;
            } else {
                $counter = 0;
            }
        }
        
        if ($counter >= $limit) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'model.entry.saved'   => 'onEntrySaved',
            'model.entry.deleted' => 'onEntrySaved',
        ];
    }
}