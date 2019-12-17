# Pagekit Breadcrumbs

Shows breadcrumbs in widget

## Installation

Please install Breadcrumbs via the built-in Marketplace in your Pagekit Installation.

The extension will be installed automatically.

## Pagekit developers

To add items to the breadcrumbs, simply do so in your controller when preparing the view:

```php
if ($breadcrumbs = App::module('bixie/breadcrumbs')) {

    $breadcrumbs->addUrl([
        'title' => 'My item',
        'url' => '/sub/sub/my-item'
    ]);

}
```

An example for adding a category tree to the breadcrumbs

```php
if ($breadcrumbs = App::module('bixie/breadcrumbs')) {
    
    $crumbs = [['title' => $category->title, 'url' => $category->getUrl()]];
    while ($parent_id = $category->parent_id) {
        if ($category = $category->find($parent_id, true)) {
            $crumbs[] = ['title' => $category->title, 'url' => $category->getUrl()];
        }
    }
    foreach (array_reverse($crumbs) as $data) {
        $breadcrumbs->addUrl($data);
    }
}
```

## Issues and feature requests

Please use the [issues section](https://github.com/Bixie/pagekit-breadcrumbs/issues) to file any bugs or feature requests.
