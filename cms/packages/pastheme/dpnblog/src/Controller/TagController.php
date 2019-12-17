<?php
namespace Pastheme\Blog\Controller;
use Pagekit\Application as App;
use Pastheme\Blog\Model\Post;
use Pastheme\Blog\Model\Tags;

class TagController{

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
    * @Route("/tags/{id}" , name="tags/id" , requirements={"id" = "\d+"})
    * @Request({"page": "int"})
    */
    public function tagsAction($page = 1 , $id = null){
        if (empty($id)) {
            App::abort('404' , 'Not Found Tags');
        }

        if (!$tagsQuery = Tags::where('id = ?' , [$id])->first() ) {
            App::abort('404' , 'Not Found Tags');
        }

        $query = Post::query();
        $query->where(['status = :status', 'date < :date' , 'tags LIKE :tags'], ['status' => Post::STATUS_PUBLISHED, 'date' => new \DateTime , 'tags' => "%{$tagsQuery->tags}%"])->where(function ($query) {
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
                'name' => 'dpnblog/tags.php',
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

}
?>
