<?php

/*

Mercator Gallery Extension for Pagekit
Copyright (C) 2018 Helmut Kaufmann

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.

*/

namespace mercator\gallery\Plugin;
use Pagekit\Content\Event\ContentEvent;
use Pagekit\Event\EventSubscriberInterface;

include "MercatorCreateGallery.php";

class MercatorGallery implements EventSubscriberInterface
{

    /**
     * Callback to register one or more content plugins.
     *
     * @param ContentEvent $event            
     */
    public function onContentPlugins(ContentEvent $event)
    {
        $event->addPlugin(
            'mercator_gallery', // The plugin name.
            [ 
                $this,
                'applyPlugin' // The name of the callback to execute the plugin.
            ]
        );
    }

    /**
     * The plugin callback.
     *
     * @param array $options
     *   The options for the plugin (the parsed pluginData).
     * @return string|null
     *   The content which should replace the plugin definition.
     */
    public function applyPlugin(array $options)
    {
    	return create_all_galleries($options);
    }

    /**
     *
     * {@inheritdoc}
     *
     */
    public function subscribe()
    {
        return [
            'content.plugins' => [
                'onContentPlugins', // The name of the callback to register the content plugin(s).
                25                  // Must be at least 11 to get the plugin to work.
            ]
        ];
    }
}