<?php
namespace Pastheme\Blog\Event;
use Pagekit\Application as App;
use Pastheme\Blog\CategoryUrlResolver;
use Pagekit\Event\EventSubscriberInterface;

class CategoryRouteListener implements EventSubscriberInterface
{
    /**
     * Adds cache breaker to router.
     */
    public function onAppRequest()
    {
        App::router()->setOption('dpnblog.permalink', CategoryUrlResolver::getPermalink());
    }

    /**
     * Registers permalink route alias.
     */
    public function onCategoryRoute($event, $route)
    {
        if ($route->getName() == '@dpnblog/category/id' && CategoryUrlResolver::getPermalink()) {
            App::routes()->alias(dirname($route->getPath()).'/'.ltrim(CategoryUrlResolver::getPermalink(), '/'), '@dpnblog/category/id', ['_resolver' => 'Pastheme\Blog\CategoryUrlResolver']);
        }

    }

    /**
     * Clears resolver cache.
     */
    public function clearCache()
    {
        App::cache()->delete(CategoryUrlResolver::CACHE_KEY);
    }

    /**
     * {@inheritdoc}
     */
    public function subscribe()
    {
        return [
            'request'                 => ['onAppRequest', 130],
            'route.configure'         => 'onCategoryRoute',
            'model.post.saved'        => 'clearCache',
            'model.post.deleted'      => 'clearCache'
        ];
    }
}
