<?php
use Pastheme\Blog\Model\Tags;
return [
    'name' => 'dpnblog/tags',

    'label' => 'DPN - Tags',

    'events' => [
        'view.scripts' => function ($event , $scripts) use ($app) {
            $scripts->register('tags-widget' , 'dpnblog:app/bundle/tags-widget.js' , ['~widgets']);
        }
    ],

    'render' => function ($widget) use ($app){
        $tags = Tags::findAll();
        return $app->view('dpnblog/widgets/tags.php' , compact('tags'));
    }

]
?>
