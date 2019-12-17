<?php
namespace Pastheme\Blog\Controller;
use Pagekit\Application as App;
use Pagekit\Module\Module;
use Pastheme\Blog\Model\Post;

class BlogController
{
    /**
     * @var Module
     */
    protected $blog;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->blog = App::module('dpnblog');
    }

    /**
    * @Route("/")
    * @Route("/page/{page}", name="page", requirements={"page" = "\d+"})
    */
    public function indexAction($page = 1){
        $query = Post::query();
        $query->where(['status = ?', 'date < ?'], [Post::STATUS_PUBLISHED, new \DateTime])->where(function ($query) {
            return $query->where('roles IS NULL')->whereInSet('roles', App::user()->roles, false, 'OR');
        })->related('user' , 'category');

        if (!$limit = $this->blog->config('posts.posts_per_page')) {
            $limit = 10;
        }

        $count = $query->count('id');
        $total = ceil($count / $limit);
        $page = max(1, min($total, $page));

        $query->offset(($page - 1) * $limit)->limit($limit)->orderBy('date', 'DESC');

        foreach ($posts = $query->get() as $post) {
            $post->excerpt = App::content()->applyPlugins($post->excerpt, ['post' => $post, 'markdown' => $post->get('markdown')]);
            $post->content = App::content()->applyPlugins($post->content, ['post' => $post, 'markdown' => $post->get('markdown'), 'readmore' => true]);
        }
        return [
            '$view' => [
                'title' => __('Blog'),
                'name' => 'dpnblog/posts.php',
                'link:feed' => [
                    'rel' => 'alternate',
                    'href' => App::url('@dpnblog/feed'),
                    'title' => App::module('system/site')->config('title'),
                    'type' => App::feed()->create($this->blog->config('feed.type'))->getMIMEType()
                ]
            ],
            'blog' => $this->blog,
            'posts' => $posts,
            'total' => $total,
            'page' => $page,
            'authorBox' => $this->blog->config('posts.author_box_show')
        ];
    }

    /**
    * @Route("/{id}" , name="id")
    */
    public function postAction($id = 0){

        if (!$post = Post::where(['id = ?', 'status = ?', 'date < ?'], [$id, Post::STATUS_PUBLISHED, new \DateTime])->related(['user' , 'category'])->first()) {
            App::abort(404, __('Post not found!'));
        }

        if (!$post->hasAccess(App::user())) {
            App::abort(403, __('Insufficient User Rights.'));
        }

        $post->excerpt = App::content()->applyPlugins($post->excerpt, ['post' => $post, 'markdown' => $post->get('markdown')]);
        $post->content = App::content()->applyPlugins($post->content, ['post' => $post, 'markdown' => $post->get('markdown')]);

        $user = App::user();
        $description = $post->get('meta.og:description');
        if (!$description) {
            $description = strip_tags($post->excerpt ?: $post->content);
            $description = rtrim(mb_substr($description, 0, 150), " \t\n\r\0\x0B.,") . '...';
        }

        if ( $post->isPostStyle() == 'Default Post' || $post->isPostStyle() == 'Article Post' || $post->isPostStyle() == 'Document' ) {
            $ogimage = $post->get('image.src') ? App::url()->getStatic($post->get('image.src'), [] , true) : false;
        }

        if ( $post->isPostStyle() == 'Video Content' ) {
            $ogimage = !empty($post->get('video.image')) ? App::url()->getStatic($post->get('video.image') , [] , true) : false;
        }

        if ( $post->isPostStyle() == 'Image Gallery' ) {
            $ogimage = !empty($post->data['gallery'][0]['image']) ? App::url()->getStatic($post->data['gallery'][0]['image'] , [] , true) : false;
        }

        return [
            '$view' => [
                'title' => __($post->title),
                'name' => 'dpnblog/post.php',
                'og:type' => 'article',
                'article:published_time' => $post->date->format(\DateTime::ATOM),
                'article:modified_time' => $post->modified->format(\DateTime::ATOM),
                'article:author' => $post->user->name,
                'og:title' => $post->get('meta.og:title') ?: $post->title,
                'og:description' => $description,
                'og:image' =>  $ogimage,
                'twitter:title' => $post->get('meta.og:title') ?: $post->title,
                'twitter:description' => $description,
                'twitter:image' =>  $ogimage
            ],
            '$data' => [
                'id' => $post->id,
                'type' => 'post'
            ],
            'blog' => $this->blog,
            'post' => $post,
            'user' => $post->user,
            'category' => $post->category,
            'authorBox' => $this->blog->config('posts.author_box_show')
        ];

    }

}
?>
