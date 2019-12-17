<?php
/**
 * @package    Pkb Social Share
 * @author     Dmitry Rekun and Artem Valchuk <support@norrnext.com>
 * @copyright  Copyright © 2015 - 2016 NorrNext. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 */

namespace Norrnext\SocialShare\Content;

use Pagekit\Application as App;
use Pagekit\Content\Event\ContentEvent;
use Pagekit\Event\EventSubscriberInterface;

class SocialSharePlugin implements EventSubscriberInterface
{
    /**
     * Content plugins callback.
     *
     * @param ContentEvent $event
     */
    public function onContentPlugins(ContentEvent $event)
    {
        if (!$event['post']) {
            return;
        }

        if (strpos(App::request()->attributes->get('_route'), '@blog/id') === false) {
            return;
        }

        $config = App::config('norrnext/social-share');
        $post = $event['post'];
        $image = $post->get('image.src');
        $id    = $post->id;
        $title = $post->title;

        $options = array();
        $options['size'] = $config->get('buttons.size', 'default');
        $options['counters'] = $config->get('buttons.counters', 1);
        $options['text'] = $config->get('buttons.text', 1);
        $options['icons'] = $config->get('buttons.icons', 1);

        foreach ($options as $option => $name) {
            $data[] = '"'.$option.'": "'.$name.'"';
        }

        $content = $event->getContent();
        $buttons = App::view(
            'norrnext/social-share:/views/buttons.php', [
                'config' => $config,
                'data' => $data,
                'image' => $image,
                'id' => $id,
                'title' => $title
            ]
        );

        $event->setContent($content . $buttons);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'content.plugins' => ['onContentPlugins', 10]
        ];
    }
}