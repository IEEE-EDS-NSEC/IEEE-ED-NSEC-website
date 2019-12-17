<?php

namespace Spqr\Security\Model;

use Pagekit\System\Model\DataModelTrait;

/**
 * @Entity(tableClass="@security_ban")
 */
class Ban implements \JsonSerializable
{
    use BanModelTrait, DataModelTrait;
    
    /* Ban archived. */
    const STATUS_ARCHIVED = 0;
    
    /* Ban active. */
    const STATUS_ACTIVE = 1;
    
    /* Ban inactive. */
    const STATUS_INACTIVE = 2;
    
    /** @Column(type="integer") @Id */
    public $id;
    
    /** @Column(type="integer") */
    public $status;
    
    /** @Column(type="text") */
    public $reason = '';
    
    /** @Column(type="string") */
    public $jail = '';
    
    /** @Column(type="string") */
    public $ip;
    
    /** @Column(type="datetime") */
    public $date;
    
    /** @Column(type="datetime") */
    public $modified;
    
    /**
     * @HasMany(targetEntity="Entry", keyFrom="ip", keyTo="ip")
     * @OrderBy({"date" = "ASC"})
     */
    public $entries;
    
    /**
     * @param $ban
     *
     * @return mixed
     */
    public static function getPrevious($ban)
    {
        return self::where(['date > ?', 'date < ?', 'status = 1'], [
                $ban->date,
                new \DateTime,
            ])->orderBy('date', 'ASC')->first();
    }
    
    /**
     * @param $ban
     *
     * @return mixed
     */
    public static function getNext($ban)
    {
        return self::where(['date < ?', 'status = 1'], [$ban->date])
            ->orderBy('date', 'DESC')->first();
    }
    
    /**
     * @return mixed
     */
    public function getStatusText()
    {
        $statuses = self::getStatuses();
        
        return isset($statuses[$this->status]) ? $statuses[$this->status]
            : __('Unknown');
    }
    
    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE   => __('Active'),
            self::STATUS_INACTIVE => __('Inactive'),
            self::STATUS_ARCHIVED => __('Archived'),
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $data = [
            'entries' => $this->getEntries(),
        ];
        
        return $this->toArray($data);
    }
    
}