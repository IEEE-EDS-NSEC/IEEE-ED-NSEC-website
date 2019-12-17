<?php

return [

    'name' => 'bixie/widget-breadcrumbs',

    'label' => 'Breadcrumbs',

    'render' => function ($widget) use ($app) {

		return $app['view']('bixie/breadcrumbs/widget-breadcrumbs.php');
    }

];
