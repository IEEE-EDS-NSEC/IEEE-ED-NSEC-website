<?php
namespace Pastheme\Blog\Controller\Admin;
use Pagekit\Application as App;
use Pastheme\Blog\Model\Post;
use Pagekit\User\Model\Role;
use Pastheme\Blog\Model\Category;
use Pastheme\Blog\Helper\BackAnswer;

/**
 * @Access(admin=true)
 */
class PostController
{
    /**
    * @Request({"page":"int" , "filter":"array"})
    */
    public function postsAction($page = 0 , $filter = array()){

        $categories = Category::where('status = ?' , [Category::STATUS_PUBLISHED])->get();

        return [
            '$view' => [
                'title' => __('Posts List'),
                'name'  => 'dpnblog/admin/post.php'
            ],
            '$data' => [
                'config' => [
                    'filter' => (object)$filter,
                    'page'   => $page
                ],
                'categories' => $categories
            ]
        ];
    }

    /**
    * @Route("/posts/edit", name="posts/edit")
    * @Request({"id":"string"})
    */
    public function editAction($id = null)
    {
        try {
            if ( !$post = Post::where(compact('id'))->first() ) {

                if ($id) {
                    App::abort(404, __('Invalid post id.'));
                }

                if (!$selected = Category::where('status = 2')->first()) {
                    App::abort(400 , 'No Categories Found');
                }
                $module = App::module('dpnblog');
                $post = Post::create([
                    'user_id' => App::user()->id,
                    'status' => Post::STATUS_PUBLISHED,
                    'comment_status' => $module->config('posts.comment_enabled'),
                    'post_style' => 0,
                    'tags' => [],
                    'date' => new \DateTime(),
                    'category_id' => $selected->id,
                    'data' => array(
                        'gallery' => [
                            ['image' => '']
                        ],
                        'video' => [
                            'source' => '',
                            'image' => '',
                        ],
                        'meta' => [
                            'og:title' => null,
                            'og:description' => null
                        ]
                    )
                ]);

                $post->set('title', $module->config('posts.show_title'));
                $post->set('markdown', $module->config('posts.markdown_enabled'));
            }

            $user = App::user();
            if(!$user->hasAccess('dpnblog: manage all posts') && $post->user_id !== $user->id) {
                App::abort(403, __('Insufficient User Rights.'));
            }

            $roles = App::db()->createQueryBuilder()
            ->from('@system_role')
            ->where(['id' => Role::ROLE_ADMINISTRATOR])
            ->whereInSet('permissions', ['dpnblog: manage all posts', 'dpnblog: manage own posts'], false, 'OR')
            ->execute('id')
            ->fetchAll(\PDO::FETCH_COLUMN);

            $authors = App::db()->createQueryBuilder()
            ->from('@system_user')
            ->whereInSet('roles', $roles)
            ->execute('id, username')
            ->fetchAll();

            return [
                '$view' => [
                    'title' => $id ? __('Edit Post') : __('Add Post'),
                    'name'  => 'dpnblog/admin/post-edit.php'
                ],
                '$data' => [
                    'data' => [
                        'post'     => $post,
                        'statuses' => Post::getStatuses(),
                        'roles'    => array_values(Role::findAll()),
                        'authors'  => $authors,
                    ],
                    'post' => $post
                ]
            ];
        } catch (\Exception $e) {
            App::message()->error($e->getMessage());
            return App::redirect('@dpnblog/posts');
        }
    }
}


?>
