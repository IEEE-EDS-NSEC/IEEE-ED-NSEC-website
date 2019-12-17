<?php
namespace Pastheme\Blog\Model;
use Pagekit\Database\ORM\ModelTrait;

/**
* @Entity(tableClass="@dpnblog_tags")
*/
class Tags
{
    use ModelTrait;
    /** @Column(type="integer") , @Id */
    public $id;
    /** @Column(type="string") */
    public $tags;
    /** @Column(type="string") */
    public $slug;
    /** @Column(type="datetime")*/
    public $date;
    /** @Column(type="integer") */
    public $user_id;
    /**
    * @BelongsTo(targetEntity="Pagekit\User\Model\User", keyFrom="user_id")
    */
    public $user;
}
?>
