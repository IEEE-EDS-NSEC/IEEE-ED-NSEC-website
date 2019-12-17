<?php
use Pastheme\Blog\Content\ReadmorePlugin;
use Pastheme\Blog\Event\PostListener;
use Pastheme\Blog\Event\RouteListener;
use Pastheme\Blog\Event\CategoryRouteListener;
use Pastheme\Blog\Event\TagsRouteListener;
use Pastheme\Blog\Event\SocialShare;

return [
    'name' => 'dpnblog',
    'autoload' => ['Pastheme\\Blog\\' => 'src'],

    'menu' => [
      'dpnblog' => [
        'label' => 'Blog',
        'icon'  => 'dpnblog:icon.svg',
        'url'   => '@dpnblog/posts',
        'priority' => 110,
      ],
      'dpnblog: posts' => [
        'parent'=> 'dpnblog',
        'label' => _('Posts'),
        'url'   => '@dpnblog/posts',
        'active'=> '@dpnblog/posts*'
      ],
      'dpnblog: categories' => [
        'parent'=> 'dpnblog',
        'label' => _('Categories'),
        'url'   => '@dpnblog/categories',
        'active'=> '@dpnblog/categories*'
      ],
      'dpnblog: settings' => [
        'parent'=> 'dpnblog',
        'label' => _('Settings'),
        'url'   => '@dpnblog/settings',
        'active'=> '@dpnblog/settings*'
      ]
    ],

    'routes' => [
      '/dpnblog' => [
        'name' => '@dpnblog',
        'controller' => [
          'Pastheme\\Blog\\Controller\\Admin\\PostController',
          'Pastheme\\Blog\\Controller\\Admin\\CategoryController',
          'Pastheme\\Blog\\Controller\\Admin\\SettingsController',
        ]
      ],
      '/apidpnblog' => [
        'name' => '@apidpnblog',
        'controller' => [
          'Pastheme\\Blog\\Controller\\Api\\ApiCategoryController',
          'Pastheme\\Blog\\Controller\\Api\\ApiPostController',
          'Pastheme\\Blog\\Controller\\Api\\ApiTagsController',
        ]
      ]
    ],

    'nodes' => [
        'dpnblog' => [
            'name'  => '@dpnblog',
            'label' => _('Blog'),
            'protected' => true,
            'frontpage' => true,
            'controller' => [
                'Pastheme\\Blog\\Controller\\BlogController',
                'Pastheme\\Blog\\Controller\\CategoryController',
                'Pastheme\\Blog\\Controller\\TagController'
            ]
        ],
    ],

    'widgets' => [
        'widgets/categories.php',
        'widgets/tags.php'
    ],

    'permissions' => [
      'dpnblog: manage own posts' => [
        'title' => 'Manage own posts',
        'description' => 'Create, edit, delete and publish posts of their own'
      ],
      'dpnblog: manage all posts' => [
        'title' => 'Manage all posts',
        'description' => 'Create, edit, delete and publish posts by all users'
      ],
      'dpnblog: manage all categories' => [
        'title' => 'Manage all categories',
        'description' => 'Create, edit, delete and publish categories by all users'
      ]
    ],

    'config' => [

        'posts' => [
            'posts_per_page' => 10,
            'markdown_enabled' => true,
            'author_box_show' => true,
            'comment_enabled' => true
        ],

        'permalink' => [
            'type' => '',
            'custom' => '{slug}'
        ],
    ],

    'events' => [

        'boot' => function($event , $app) {
            $app->subscribe(
                new RouteListener,
                new CategoryRouteListener,
                new TagsRouteListener,
                new PostListener(),
                new SocialShare()
            );
        },

        'view.scripts' => function ($event, $scripts) {
            $scripts->register('link-dpnblog', 'dpnblog:app/bundle/link-dpnblog.js', '~panel-link');
        }
    ]
];
