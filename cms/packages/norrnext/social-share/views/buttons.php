<?php
/**
 * @package    Pkb Social Share
 * @author     Dmitry Rekun and Artem Valchuk <support@norrnext.com>
 * @copyright  Copyright © 2015 - 2016 NorrNext. All rights reserved.
 * @license    GNU General Public License version 3 or later; see license.txt
 */

$view->style('buttons', 'norrnext/social-share:assets/css/share.css', 'uikit');
$view->script('buttons', 'norrnext/social-share:assets/js/share.js', 'uikit');

$url   = $view->url('@blog/id', ['id' => $id]);
$url   = $app["url"]->base(0) . $url;
$image = (!empty($image)) ? $app["url"]->base(true) .'/'. $image : '';
$class = ' pkb-socialshare';
if($config->get('buttons.position', 'static')){
    $class .= ' pkb-socialshare-'.$config->get('buttons.position', 'static');
}
if($config->get('buttons.responsive', 1)){
    $class .= ' pkb-socialshare-responsive';
}
if($config->get('buttons.responsivetext', 1)){
    $class .= ' pkb-socialshare-responsive-text';
}
?>

<div class="uk-width-1-1">
    <div class="<?php echo $class ?>" data-uk-margin data-options='{<?php echo implode(", ", $data); ?>}' data-url="<?php echo $url ?>">
        <?php if ($config->get('buttons.fb', 1)) : ?>
            <div class="facebook" title="<?php echo __('Share on Facebook') ?>">Facebook</div>
        <?php endif; ?>
        <?php if ($config->get('buttons.tw', 1)) : ?>
            <div class="twitter" title="<?php echo __('Share on Twitter') ?>">Twitter</div>
        <?php endif; ?>
        <?php if ($config->get('buttons.gp', 1)) : ?>
            <div class="plusone" title="<?php echo __('Share on Google Plus') ?>"><?php echo __('Google Plus') ?></div>
        <?php endif; ?>
        <?php if ($config->get('buttons.vk', 0)) : ?>
            <div class="vk" title="<?php echo __('Share on Vk') ?>"><?php echo __('Vk') ?></div>
        <?php endif; ?>
        <?php if ($config->get('buttons.li', 0)) : ?>
            <div class="linkedin" title="<?php echo __('Share on LinkedIn') ?>">LinkedIn</div>
        <?php endif; ?>
        <?php if ($config->get('buttons.pt', 0)) : ?>
            <div class="pinterest" data-media="<?php echo $image ?>" title="<?php echo __('Share on Pinterest') ?>">Pinterest</div>
        <?php endif; ?>
    </div>
    <?php
        if($config->get('buttons.position', 'static') == 'static'){
            echo '<div style="font-size:7pt;color:#eeeeee" class="uk-text-left"><a href="https://www.norrnext.com" title="NorrNext - Pagekit extensions" target="_blank" rel="follow">norrnext.com</a></div>';
        }
    ?>
</div>