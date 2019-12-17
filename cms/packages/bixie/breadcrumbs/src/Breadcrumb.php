<?php

namespace Bixie\Breadcrumbs;

use Pagekit\Application as App;
use Pagekit\Util\Arr;

class Breadcrumb
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $url;

    /**
     * @var array
     */
    public $data;

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->title = $data['title'];
        $this->url = $data['url'];
        $this->data = $data;
    }

	/**
	 * @param string $key
	 * @param null $default
	 * @return array|mixed
	 */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return Arr::extract($this->data, $key);
        }

        return Arr::get($this->data, $key, $default);
    }

}
