<?php
/**
 * @var $view
 * @var $config
 * @var \Bixie\Breadcrumbs\BreadcrumbsModule $breadcrumbs
 * @var \Bixie\Breadcrumbs\Breadcrumb $breadcrumb
 */

?>
<ul class="uk-breadcrumb">
	<?php
	$list = $breadcrumbs->getBreadcrumbs();
	while ($breadcrumb = $list->current()) {

		if ($list->key() == $list->count() - 1) {
			echo sprintf('<li class="uk-active"><strong>%s</strong></li>', $breadcrumb->title);
		} elseif ($breadcrumb->url) {
			$title = sprintf('<a href="%s" itemprop="url"><span itemprop="title">%s</span></a>', $breadcrumb->url, $breadcrumb->title);
			echo sprintf('<li itemprop="child" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">%s</li>', $title);
		} else {
			echo sprintf('<li><span>%s</span></li>', $breadcrumb->title);
		}
		$list->next();
	}
	?>
</ul>
