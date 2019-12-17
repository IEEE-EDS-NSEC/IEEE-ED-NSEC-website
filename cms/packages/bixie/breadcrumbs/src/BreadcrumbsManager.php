<?php

namespace Bixie\Breadcrumbs;

use Pagekit\Application;

class BreadcrumbsManager implements \IteratorAggregate
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var array
     */
    protected $breadcrumbs = [];

    /**
     * @var array
     */
    protected $defaults = [
        'title' => '',
        'url' => '',
		'data' => ['isFrontpage' => false]
    ];

    /**
     * Constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Gets all breadcrumbs.
     *
     * @return array
     */
    public function all()
    {
        return $this->breadcrumbs;
    }

    /**
     * Add breadcrumb
     *
     * @param  array $data
     * @return self
     */
    public function add($data)
    {
		if (!empty($data['title'])) {
			$this->breadcrumbs[] = new Breadcrumb(array_merge($this->defaults, $data));
		}
		return $this;
    }

    /**
     * Implements the IteratorAggregate.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->all());
    }

}
