<?php
namespace Pastheme\Blog\Event;
use Pagekit\Application as App;
use Pastheme\Blog\TagsUrlResolver;
use Pagekit\Event\EventSubscriberInterface;

class TagsRouteListener implements EventSubscriberInterface
{
    /**
     * Adds cache breaker to router.
     */
    public function onAppRequest()
    {
        App::router()->setOption('dpnblog.permalink', TagsUrlResolver::getPermalink());
    }

    /**
     * Registers permalink route alias.
     */
    public function onTagsRoute($event, $route)
    {
        if ($route->getName() == '@dpnblog/tags/id' && TagsUrlResolver::getPermalink()) {
            App::routes()->alias(dirname($route->getPath()).'/'.ltrim(TagsUrlResolver::getPermalink(), '/'), '@dpnblog/tags/id', ['_resolver' => 'Pastheme\Blog\TagsUrlResolver']);
        }

    }

    /**
     * Clears resolver cache.
     */
    public function clearCache()
    {
        App::cache()->delete(TagsUrlResolver::CACHE_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'request'                 => ['onAppRequest', 130],
            'route.configure'         => 'onTagsRoute',
            'model.post.saved'        => 'clearCache',
            'model.post.deleted'      => 'clearCache'
        ];
    }
}
