<?php

namespace Mercator\Gallery\Controller;

use Pagekit\Application as App;

/**
 * @Access(admin=true)
 * @return string
 */
class MercatorController
{
	/**
	 * @Access("assets: manage settings")
	 */
	public function settingsAction()
	{
		return [
			'$view' => [
				'title' => __( 'Mercator Gallery Settings' ),
				'name'  => 'mercator/gallery:views/admin/settings.php'
			],
			'$data' => [
				'config' => App::module( 'mercator/gallery' )->config()
			]
		];
	}

	/**
	 * @Request({"config": "array"}, csrf=true)
	 * @param array $config
	 *
	 * @return array
	 */
	public function saveAction( $config = [] )
	{
		App::config()->set( 'mercator/gallery', $config );

		return [ 'message' => 'success' ];
	}

}
