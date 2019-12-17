<?php
namespace Pastheme\Blog\Model;
use Pagekit\Application as App;
use Pagekit\Database\ORM\ModelTrait;
use Pagekit\System\Model\DataModelTrait;
use Pagekit\User\Model\AccessModelTrait;
use Pagekit\User\Model\User;
use Pastheme\Blog\Model\Tags;

/**
* @Entity(tableClass="@dpnblog_post")
*/
class Post implements \JsonSerializable
{
    use ModelTrait , DataModelTrait , AccessModelTrait;

    const STATUS_DRAFT = 0;
    const STATUS_PENDING_REVIEW = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_UNPUBLISHED = 3;
    const POST_DEFAULT = 0;
    const POST_VIDEO = 1;
    const POST_ARTICLE = 2;
    const POST_GALLERY = 3;
    const POST_DOCUMENT = 4;

    /** @Column(type="integer") @Id */
    public $id;
    /** @Column(type="string") */
    public $title;
    /** @Column(type="string") */
    public $slug;
    /** @Column(type="integer") */
    public $user_id;
    /** @Column(type="datetime") */
    public $date;
    /** @Column(type="text") */
    public $content = '';
    /** @Column(type="text") */
    public $excerpt = '';
    /** @Column(type="smallint") */
    public $status;
    /** @Column(type="boolean") */
    public $comment_status;
    /** @Column(type="datetime") */
    public $modified;
    /** @Column(type="integer") */
    public $category_id;
    /** @Column(type="integer") */
    public $post_style;
    /** @Column(type="simple_array") */
    public $tags;
    /**
    * @BelongsTo(targetEntity="Pagekit\User\Model\User", keyFrom="user_id")
    */
    public $user;
    /**
    * @BelongsTo(targetEntity="Category" , keyFrom="category_id")
    */
    public $category;

    /** @var array */
    protected static $properties = [
      'author' => 'getAuthor',
      'categories' => 'getCategory',
      'published' => 'isPublished',
      'accessible' => 'isAccessible',
      'post_name' => 'isPostStyle'
    ];

    public static function getStatuses()
    {
        return [
            self::STATUS_PUBLISHED        => __('Published'),
            self::STATUS_UNPUBLISHED      => __('Unpublished'),
            self::STATUS_DRAFT            => __('Draft'),
            self::STATUS_PENDING_REVIEW   => __('Pending Review')
        ];
    }

    public function getUrl(){
        return App::url()->base(0).App::url('@dpnblog/id', ['id' => $this->id]);
    }

    public function isCommentable()
    {
        $blog      = App::module('dpnblog');
        $autoclose = $blog->config('comments.autoclose') ? $blog->config('comments.autoclose_days') : 0;
        return $this->comment_status && (!$autoclose or $this->date >= new \DateTime("-{$autoclose} day"));
    }

    public static function getPostStyle()
    {
        return [
            self::POST_DEFAULT    => __('Default Post'),
            self::POST_VIDEO      => __('Video Content'),
            self::POST_ARTICLE    => __('Article Post'),
            self::POST_GALLERY    => __('Image Gallery'),
            self::POST_DOCUMENT   => __('Document')
        ];
    }

    public function isPostStyle(){
        return $postStyleName = self::getPostStyle()[$this->post_style];
    }

    public function getStatusText()
    {
        $statuses = self::getStatuses();
        return isset($statuses[$this->status]) ? $statuses[$this->status] : __('Unknown');
    }

    public function getAuthor()
    {
        return $this->user ? $this->user->username : null;
    }
    public function getCategory()
    {
        return $this->category ? $this->category->title : null;
    }

    public function isPublished()
    {
        return $this->status === self::STATUS_PUBLISHED && $this->date < new \DateTime;
    }

    public function isAccessible(User $user = null)
    {
        return $this->isPublished() && $this->hasAccess($user ?: App::user());
    }

    public function getGravatar($params = [])
    {
        $email = $this->user->email;
        $params = array_merge([
            'size'    => 50,
            'default' => 'mm',
            'rating'  => 'g',
            'img'     => false,
            'attrs'   => []
        ], $params);

        $url = sprintf('//gravatar.com/avatar/%s?s=%s&d=%s&r=%s', md5(strtolower(trim($email))), $params['size'], $params['default'], $params['rating']);

        if ($params['img']) {

            $attrs = array_merge([
                'src'    => $url,
                'width'  => $params['size'],
                'height' => $params['size']
            ], $params['attrs']);

            $attrs = array_map(function($name, $value) {
                return sprintf('%s="%s"', $name, htmlspecialchars($value));
            }, array_keys($attrs), $attrs);

            return '<img '.implode(' ', $attrs).'/>';
        }

        return $url;
    }

    public function tagsSerialize(){
        $tagsSerialize = [];
        foreach ($this->tags as $value) {
            if ( $query = Tags::where('tags = ?' , [$value])->first() ) {
                array_push($tagsSerialize , $query);
            }
        }
        return $tagsSerialize;
    }

    /**
    * {@inheritdoc}
    */
    public function jsonSerialize()
    {
        $data = [
            'url' => App::url('@dpnblog/id', ['id' => $this->id ?: 0], 'base')
        ];
        return $this->toArray($data);
    }

}

?>
