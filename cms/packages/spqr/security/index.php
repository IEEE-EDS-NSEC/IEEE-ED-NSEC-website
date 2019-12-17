<?php

use Pagekit\Application;
use Spqr\Security\Event\AuthListener;
use Spqr\Security\Event\EntryListener;
use Spqr\Security\Event\RouteListener;
use Spqr\Security\Event\CommentListener;


return [
    'name' => 'spqr/security',
    'type' => 'extension',
    'main' => function (Application $app) {
    
    },
    
    'autoload' => [
        'Spqr\\Security\\' => 'src',
    ],
    
    'routes' => [
        '/security'     => [
            'name'       => '@security',
            'controller' => ['Spqr\\Security\\Controller\\BanController'],
        ],
        '/api/security' => [
            'name'       => '@security/api',
            'controller' => [
                'Spqr\\Security\\Controller\\BanApiController',
            ],
        ],
    ],
    
    'widgets' => [],
    
    'menu' => [
        'security'           => [
            'label'  => 'Security',
            'url'    => '@security/ban',
            'active' => '@security/ban*',
            'icon'   => 'spqr/security:icon.svg',
        ],
        'security: ban'      => [
            'parent' => 'security',
            'label'  => 'Bans',
            'icon'   => 'spqr/security:icon.svg',
            'url'    => '@security/ban',
            'access' => 'security: manage bans',
            'active' => '@security/ban*',
        ],
        'security: settings' => [
            'parent' => 'security',
            'label'  => 'Settings',
            'url'    => '@security/settings',
            'access' => 'security: manage settings',
        ],
    ],
    
    'permissions' => [
        'security: manage settings' => [
            'title' => 'Manage settings',
        ],
        'security: manage bans'     => [
            'title' => 'Manage bans',
        ],
    ],
    
    'settings' => '@security/settings',
    
    'resources' => [
        'spqr/security:' => '',
    ],
    
    'config' => [
        'items_per_page' => 20,
        'jails'          => [
            'login'        => [
                'enabled'  => true,
                'attempts' => 3,
            ],
            'unauthorized' => [
                'enabled'  => false,
                'attempts' => 3,
            ],
            'forbidden'    => [
                'enabled'  => false,
                'attempts' => 3,
            ],
            'honeypot'     => [
                'enabled'   => true,
                'attempts'  => 3,
                'honeypots' => [
                    'wp-login.php',
                    'wp-admin',
                    'xmlrpc.php',
                    'index.php?option=',
                ],
            ],
            'spam'         => [
                'enabled'  => true,
                'attempts' => 3,
            ],
        ],
        'whitelist'      => ['127.0.0.1'],
    ],
    
    'events' => [
        'boot'         => function ($event, $app) {
            $app->subscribe(new AuthListener, new EntryListener,
                new RouteListener, new CommentListener);
        },
        'site'         => function ($event, $app) {
        },
        'view.scripts' => function ($event, $scripts) use ($app) {
        },
    ],
];