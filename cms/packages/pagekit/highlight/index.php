<?php

use Pagekit\Application as App;

return [

    'name' => 'highlight',

    'resources' => [
        'highlight:' => ''
    ],

    'autoload' => [
        'Pagekit\\Highlight\\' => 'src'
    ],

    'routes' => [
        '/highlight' => [
            'name' => '@highlight',
            'controller' => [
                'Pagekit\\Highlight\\HighlightController'
            ]
        ],
    ],

    'config' => [
        // default style. styles are located as css files in the styles folder
        'style' => 'github',

        // Only load if page contains pre or code
        'autodetect' => true,

        // ids of pages where highlighting should be enabled
        'nodes' => []
    ],

    'settings' => 'highlight-settings',

    'events' => [
        'view.scripts' => function ($event, $scripts) use ($app) {
            $scripts->register('highlight-settings', 'highlight:app/bundle/highlight-settings.js', ['~extensions', 'input-tree']);
        },

        'site' => function ($event, $app) {

            $app->on('view.content', function ($event, $test) use ($app) {
                if ((!$this->config['nodes'] || in_array($app['node']->id, $this->config['nodes']))
                    && (!$this->config['autodetect'] || (strpos($event->getResult(), '<pre') !== false || strpos($event->getResult(), '<code') !== false))
                ) {
                    $app['scripts']->add('highlight', 'highlight:assets/highlight.pack.js');
                    $app['scripts']->add('highlight-init', 'highlight:assets/highlight.js', 'highlight');
                    $app['styles']->add('highlight', 'highlight:assets/styles/'.$this->config['style'].'.css');
                    $app['styles']->add('highlight-override', 'highlight:assets/style.css', 'highlight');
                }
            });
        }

    ]

];
