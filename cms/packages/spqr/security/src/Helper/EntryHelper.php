<?php

namespace Spqr\Security\Helper;

use Spqr\Security\Model\Entry;

/**
 * Class EntryHelper
 *
 * @package Spqr\Security\Helper
 */
class EntryHelper
{
    /**
     * @param       $ip
     * @param       $referrer
     * @param       $event
     * @param array $data
     *
     * @return bool
     */
    public function createEntry(
        $ip,
        $referrer,
        $event,
        $data = ['result' => false]
    ) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            $entry = Entry::create([
                    'ip' => $ip,
                    'referrer' => $referrer,
                    'event' => $event,
                    'data' => $data,
                    'date' => new \DateTime,
                ]);
            
            $entry->save();
            
            return true;
        }
        
        return false;
    }
}