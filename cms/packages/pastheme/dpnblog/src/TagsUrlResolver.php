<?php
namespace Pastheme\Blog;
use Pagekit\Application as App;
use Pastheme\Blog\Model\Tags;
use Pagekit\Routing\ParamsResolverInterface;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class TagsUrlResolver implements ParamsResolverInterface
{
    const CACHE_KEY = 'dpnblogtags.routing';

    /**
     * @var bool
     */
    protected $cacheDirty = false;

    /**
     * @var array
     */
    protected $cacheEntries;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->cacheEntries = App::cache()->fetch(self::CACHE_KEY) ?: [];
    }

    /**
     * {@inheritdoc}
     */
    public function match(array $parameters = [])
    {
        if (isset($parameters['id'])) {
            return $parameters;
        }

        if (!isset($parameters['slug'])) {
            App::abort(404, 'Tags not found.');
        }

        $slug = $parameters['slug'];

        $id = false;
        foreach ($this->cacheEntries as $entry) {
            if ($entry['slug'] === $slug) {
                $id = $entry['id'];
            }
        }

        if (!$id) {

            if (!$category = Tags::where(compact('slug'))->first()) {
                App::abort(404, 'Tags not found.');
            }

            $this->addCache($category);
            $id = $category->id;
        }

        $parameters['id'] = $id;
        return $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function generate(array $parameters = [])
    {
        $id = $parameters['id'];

        if (!isset($this->cacheEntries[$id])) {

            if (!$category = Tags::where(compact('id'))->first()) {
                throw new RouteNotFoundException('Tags not found!');
            }

            $this->addCache($category);
        }

        $meta = $this->cacheEntries[$id];

        preg_match_all('#{([a-z]+)}#i', self::getPermalink(), $matches);

        if ($matches) {
            foreach($matches[1] as $attribute) {
                if (isset($meta[$attribute])) {
                    $parameters[$attribute] = $meta[$attribute];
                }
            }
        }

        unset($parameters['id']);
        return $parameters;
    }

    public function __destruct()
    {
        if ($this->cacheDirty) {
            App::cache()->save(self::CACHE_KEY, $this->cacheEntries);
        }
    }

    /**
     * Gets the blog's permalink setting.
     *
     * @return string
     */
    public static function getPermalink()
    {
        static $permalink;

        if (null === $permalink) {

            $blog = App::module('dpnblog');
            $permalink = $blog->config('permalink.type');

            if ($permalink == 'custom') {
                $permalink = $blog->config('permalink.custom');
            }

        }

        return $permalink;
    }

    protected function addCache($category)
    {
        $this->cacheEntries[$category->id] = [
            'id'     => $category->id,
            'slug'   => $category->slug,
            'year'   => $category->date->format('Y'),
            'month'  => $category->date->format('m'),
            'day'    => $category->date->format('d'),
            'hour'   => $category->date->format('H'),
            'minute' => $category->date->format('i'),
            'second' => $category->date->format('s'),
        ];

        $this->cacheDirty = true;
    }
}
