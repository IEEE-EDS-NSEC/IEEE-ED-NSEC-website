<?php
use Pastheme\Blog\Model\Category;
return [
    'name' => 'dpnblog/categories',

    'label' => 'DPN - Categories',

    'events' => [
        'view.scripts' => function ($event , $scripts) use ($app) {
            $scripts->register('categories-widget' , 'dpnblog:app/bundle/categories-widget.js' , ['~widgets']);
        }
    ],

    'render' => function ($widget) use ($app){
        $categories = Category::query()->where('status = ?' , [Category::STATUS_PUBLISHED])
        ->orderBy('id' , $widget->data['order'])
        ->get();

        return $app->view('dpnblog/widgets/categories.php' , compact('categories'));
    }

]
?>
