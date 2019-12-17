<?php

namespace Pagekit\Highlight;

use Pagekit\Application as App;

/**
 * @Access(admin=true)
 */
class HighlightController
{
    /**
     *  Returns several config settings needed for the settings view.
     */
    public function configAction()
    {
        $styles = array_map(function ($fn) {
            return basename($fn, '.css');
        }, glob(App::locator()->get('highlight:assets/styles').'/*.css'));

        return compact('styles');
    }
}
