<?php
namespace Pastheme\Blog\Controller\Admin;
use Pagekit\Application as App;

/**
 * @Access(admin=true)
 */
class CategoryController
{

  /**
  * @Route("/categories")
  * @Request({"page":"int" , "filter":"array"})
  */
  public function categoriesAction( $page = 0 , $filter = array() )
  {
    try {
      $user = App::user();
      if(!$user->hasAccess('dpnblog: manage all posts') && $post->user_id !== $user->id) {
          App::abort(403, __('Insufficient User Rights.'));
      }

      return [
        '$view' => [
          'title' => __('Categories List'),
          'name'  => 'dpnblog/admin/categories.php'
        ],
        '$data' => [
          'config' => [
            'filter' => (object)$filter,
            'page'   => $page
          ]
        ]
      ];

    } catch (\Exception $e) {
        App::message()->error($e->getMessage());
        return App::redirect('@dpnblog/posts');
    }
  }
  
}


?>
