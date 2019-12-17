<?php
namespace Pastheme\Blog\Controller\Api;

use Pagekit\Application as App;
use Pastheme\Blog\Model\Tags;
use Pastheme\Blog\Helper\BackAnswer;

/**
* @Access(admin=true)
* @Route("/tags" , name="post")
*/
class ApiTagsController{

    /**
    * @Route(methods="GET")
    * @Request(csrf=true)
    */
    public function getAllTagsAction(){
        $back = new BackAnswer;
        try {
            $db = App::db()->createQueryBuilder();
            $query = $db
            ->select('tags')
            ->from('@dpnblog_tags')
            ->get();
            if (!$query) {
                return $back->success(array() , 'No Tags At All' , 404);
            }
            $data = [];
            foreach ($query as $key => $value) {
                array_push($data,$value['tags']);
            }
            return $back->success( (array) $data , 'GET All Tags');
        } catch (\Exception $e) {
            return $back->preturn();
        }
    }

    /**
    * @inheritdoc Insert and Check
    */
    public function checkedTags($data = array()){

        $array = array();

        if (empty($data)) {
            return false;
        }

        foreach ($data as $key => $value) {

            $name = ucwords(trim($value));
            $slug = App::filter($name , 'slugify');

            if ( !$query = Tags::where(['tags = ?' , 'slug = ?'] , [$name , $slug])->first() ) {
                $query = Tags::create([
                    'tags' => $name,
                    'slug' => $slug,
                    'user_id' => App::user()->id,
                    'date' => new \DateTime
                ]);
                $query->save();
                array_push($array , $query->id);
            }else{
                array_push($array , $query->id);
            }
        }

        return $array;

    }

}
?>
