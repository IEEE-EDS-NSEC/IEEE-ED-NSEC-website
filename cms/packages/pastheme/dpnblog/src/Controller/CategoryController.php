<?php
namespace Pastheme\Blog\Controller;
use Pagekit\Application as App;
use Pastheme\Blog\Model\Post;
use Pastheme\Blog\Model\Category;

class CategoryController{

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
    * @Route("/category/{id}" , name="category/id" , requirements={"id" = "\d+"})
    * @Request({"id":"int" , "page": "int"})
    */
    public function categoryAction($id = null , $page = 1){

        if (empty($id)) {
            App::abort('404' , 'Not Found Category');
        }

        if (!$categoryQuery = Category::where('id = ?' , [$id])->first() ) {
            App::abort('404' , 'Not Found Category');
        }
        $query = Post::query();
        $query->where(['status = :status', 'date < :date' , 'category_id = :category'], ['status' => Post::STATUS_PUBLISHED, 'date' => new \DateTime , 'category' => $categoryQuery->id])->where(function ($query) {
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
                'name' => 'dpnblog/categories.php',
                'link:feed' => [
                    'rel' => 'alternate',
                    'href' => App::url('@dpnblog/feed'),
                    'title' => App::module('system/site')->config('title'),
                    'type' => App::feed()->create($this->blog->config('feed.type'))->getMIMEType()
                ],
                'og:type' => 'article',
                'og:title' => !empty($categoryQuery->data['meta']['og:title']) ? $categoryQuery->data['meta']['og:title']:$categoryQuery->title,
                'og:description' => !empty($categoryQuery->data['meta']['og:description']) ?  $categoryQuery->data['meta']['og:description']:'',
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
