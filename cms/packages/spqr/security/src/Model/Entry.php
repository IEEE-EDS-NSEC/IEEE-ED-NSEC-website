<?php

namespace Spqr\Security\Model;

use Pagekit\Database\ORM\ModelTrait;
use Pagekit\System\Model\DataModelTrait;

/**
 * @Entity(tableClass="@security_entry")
 */
class Entry implements \JsonSerializable
{
    use ModelTrait, DataModelTrait;
    
    /** @Column(type="integer") @Id */
    public $id;
    
    /** @Column(type="string") */
    public $ip;
    
    /** @Column(type="string") */
    public $event;
    
    /** @Column(type="string") */
    public $referrer;
    
    /** @Column(type="datetime") */
    public $date;
    
    /** @BelongsTo(targetEntity="Ban", keyFrom="ip") */
    public $ban;
    
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}