<?php

namespace Pastheme\Blog\Controller\Api;

use Pagekit\Application as App;
use Pastheme\Blog\Helper\BackAnswer;
use Pastheme\Blog\Model\Category;

/**
* @Access(admin=true)
* @Route("/category" , name="category")
*/
class ApiCategoryController
{

  /**
  * @Route("/" , methods="GET")
  * @Request({"filter":"array" , "page":"int"} , csrf=true)
  */
  public function indexAction( $filter = array() , $page = 0)
  {
    $backanswer = new BackAnswer;
    try {
      $query = Category::query();
      $filter = array_merge(array_fill_keys(['status' , 'search' , 'order'] , '') , $filter);
      extract($filter , EXTR_SKIP);

      if ( !empty($search) ) {
        $query->where(['title LIKE :search' , 'slug LIKE :search'] , ['search' => "%{$search}%"]);
      }

      if ( !empty($status) ) {
        $query->where('status = ?' , [$status]);
      }

      $categories = array_values($query->get());
      $count = $query->count();
      $page = 0;

      return compact('categories' , 'filter' , 'page' , 'count');
    } catch (\Exception $e) {
      return $backanswer->preturn();
    }
  }

  /**
  * @Route("/get/" , methods="GET")
  * @Route("/get/{id}" , methods="GET")
  * @Request({"ids":"integer"} , csrf=true)
  */
  public function getAction($ids = null)
  {
    $backanswer = new BackAnswer;
    try {
      if ( !$query = Category::where('id = ?' , [$ids])->first() ) {
        $query = Category::create([
          'status' => Category::STATUS_PUBLISHED,
          'data'  => [
            'meta' => [
              'og:title' => '',
              'og:description' => '',
            ]
          ]
        ]);
      }
      return $backanswer->success($query , 'Get operation succeeded');
    } catch (\Exception $e) {
      return $backanswer->preturn();
    }
  }

  /**
  * @Route("/save" , methods="POST")
  * @Request({"data":"array" , "ids":"integer"} , csrf=true)
  */
  public function saveAction($data = array() , $ids = null)
  {
    $backanswer = new BackAnswer;
    try {
      if (!$query = Category::find($ids)) {
        unset($data['id']);
        $query = Category::create();

        if (Category::findByTitle($data['title']) == true) {
          $data['title'] = $data['title'] . ' - '.rand(0,999);
        }
      }

      $data['date'] = new \DateTime();

      if (empty($data['slug'])) {
        $data['slug'] = App::filter($data['slug'] ?: $data['title'] , 'slugify');
      }

      $query->save($data);
      return $backanswer->success($query , 'Category add');
    } catch (\Exception $e) {
      return $backanswer->preturn();
    }
  }

  /**
  * @Route("/change" , methods="PUT")
  * @Request({"ids":"integer" , "status":"integer"} , csrf=true)
  */
  public function changeAction($ids = null , $status = null)
  {
    $backanswer = new BackAnswer;
    try {
      if (!$query = Category::find($ids)) {
        $backanswer->abort('404' , 'Category Not Found');
      }

      if ($query->status == 2) {
        $query->status = 3;
      }else{
        $query->status = 2;
      }

      $query->save();
      return $backanswer->success([] , $ids.' Update');
    } catch (\Exception $e) {
      return $backanswer->preturn();
    }
  }

  /**
  * @Route("/allchange" , methods="PUT")
  * @Request({"data":"array", "status":"integer"} , csrf=true)
  */
  public function allChangeAction($data = [] , $status = null)
  {
    $backanswer = new BackAnswer;
    foreach ($data as $value) {
        if ($query = Category::find($value)) {
            $query->status = $status;
            $query->save();
        }
    }
    return $backanswer->success(array() , 'Update');
  }

  /**
  * @Route("/draft" , methods="DELETE")
  * @Request({"data":"array"} , csrf="true")
  */
  public function draftAction($data)
  {
    $backanswer = new BackAnswer;
    foreach ($data as $value) {
      if ($query = Category::find($value)) {
        $query->status = 0;
        $query->save();
      }
    }
    return $backanswer->success(array() , 'Update');
  }

}

?>
