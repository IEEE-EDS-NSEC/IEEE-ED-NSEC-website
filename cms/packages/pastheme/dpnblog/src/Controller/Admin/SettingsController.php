<?php
namespace Pastheme\Blog\Controller\Admin;
use Pagekit\Application as App;
/**
* @Access(admin=true)
*/
class SettingsController{
    public function settingsAction(){
        $changelog = App::content()->applyPlugins( file_get_contents(App::module('dpnblog')->path.'/CHANGELOG.md')  , ['markdown' => file_get_contents(App::module('dpnblog')->path.'/CHANGELOG.md')]);
        $readmelog = App::content()->applyPlugins( file_get_contents(App::module('dpnblog')->path.'/README.md')  , ['markdown' => file_get_contents(App::module('dpnblog')->path.'/README.md')]);
        return [
            '$view' => [
                'title' => __('Settings'),
                'name' => 'dpnblog:views/admin/settings.php'
            ],
            '$data' => [
                'config' => App::module('dpnblog')->config()
            ],
            'package' => json_decode(file_get_contents(App::module('dpnblog')->path.'/composer.json')),
            'content' => ['changelog' => $changelog , 'readme' => $readmelog]
        ];
    }
}
?>
