<?php
/**
 * @package    Pkb Social Share
 * @author     Dmitry Rekun and Artem Valchuk <support@norrnext.com>
 * @copyright  Copyright © 2015 - 2016 NorrNext. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 */

use Norrnext\SocialShare\Content\SocialSharePlugin;

return [

    'name' => 'norrnext/social-share',

    'type' => 'extension',

    'autoload' => [

        'Norrnext\\SocialShare\\' => 'src'

    ],

    'resources' => [
        'norrnext/social-share:'  => '',
    ],

    'settings' => 'settings-social-share',

    'config' => [
        'buttons' => [
            'position' => 'static',
            'size' => 'default',
            'counters' => true,
            'text' => true,
            'icons' => true,
            'responsive' => true,
            'responsivetext' => true,
            'fb' => true,
            'gp' => true,
            'tw' => true,
            'pt' => false,
            'li' => false,
            'vk' => false
        ]
    ],

    'events' => [
        'boot' => function ($event, $app) {
            $app->subscribe(new SocialSharePlugin);
        },

        'view.scripts' => function ($event, $scripts) use ($app) {
            $scripts->register('social-share-settings', 'norrnext/social-share:app/bundle/settings.js', '~extensions');
        },
    ]

];
