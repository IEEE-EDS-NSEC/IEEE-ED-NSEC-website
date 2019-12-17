<?php

namespace Pastheme\Blog\Model;
use Pagekit\Application as App;
use Pagekit\User\Model\User;
use Pagekit\Database\ORM\ModelTrait;
use Pagekit\System\Model\DataModelTrait;
/**
* @Entity(tableClass="@dpnblog_category")
*/
class Category implements \JsonSerializable
{
      use ModelTrait , DataModelTrait;

    /* Post draft status. */
    const STATUS_DRAFT = 0;
    /* Post pending review status. */
    const STATUS_PENDING_REVIEW = 1;
    /* Post published. */
    const STATUS_PUBLISHED = 2;
    /* Post unpublished. */
    const STATUS_UNPUBLISHED = 3;

    /** @Column(type="integer") , @Id */
    public $id;

    /** @Column(type="string") */
    public $title;

    /** @Column(type="string") */
    public $slug;

    /** @Column(type="string") */
    public $status;

    /** @Column(type="datetime") */
    public $date;

    /** @Column(type="json_array") */
    public $data;

    /**
    * @HasMany(targetEntity="Post", keyFrom="id", keyTo="category_id")
    */
    public $post;

    /** @var array */
    protected static $properties = [
      'accessible' => 'isAccessible',
    ];

    public static function getStatuses()
    {
        return [
          self::STATUS_PUBLISHED => __('Published'),
          self::STATUS_UNPUBLISHED => __('Unpublished'),
          self::STATUS_DRAFT => __('Draft'),
          self::STATUS_PENDING_REVIEW => __('Pending Review')
        ];
    }

    public function getStatusText()
    {
      $statuses = self::getStatuses();
      return isset($statuses[$this->status]) ? $statuses[$this->status] : __('Unknown');
    }

    public function isPublished()
    {
        return $this->status == self::STATUS_PUBLISHED && $this->date < new \DateTime;
    }

    public function isAccessible(User $user = null)
    {
        return $this->isPublished();
    }

    /**
    * {@inheritdoc}
    */
    public static function findByTitle($title)
    {
        return static::where(compact('title'))->first();
    }

    /**
    * {@inheritdoc}
    */
    public function jsonSerialize()
    {
        $data = [];
        if ( $this->status ==  self::STATUS_PUBLISHED ) {
            $data = [
                'url' => App::url('@dpnblog/category/id' , ['id' => $this->id], 'base')
            ];
        }
        return $this->toArray($data);
    }

}

?>
