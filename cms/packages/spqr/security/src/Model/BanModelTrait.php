<?php

namespace Spqr\Security\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * Class BanModelTrait
 *
 * @package Spqr\Security\Model
 */
trait BanModelTrait
{
    use ModelTrait;
    
    /**
     * @Saving
     */
    public static function saving($event, Ban $ban)
    {
        $ban->modified = new \DateTime();
    }
    
    /**
     * @Deleting
     */
    public static function deleting($event, Ban $ban)
    {
        self::getConnection()->delete('@security_entry', ['ip' => $ban->ip]);
    }
    
    /**
     * @return array
     */
    public function getEntries()
    {
        if ($this->entries) {
            foreach ($this->entries as $key => $entry) {
                if ($entry->event != $this->jail) {
                    unset($this->entries[$key]);
                }
            }
            
            return array_values(array_map(function ($entry) {
                    return $entry;
                }, $this->entries));
        }
        
        return [];
    }
}