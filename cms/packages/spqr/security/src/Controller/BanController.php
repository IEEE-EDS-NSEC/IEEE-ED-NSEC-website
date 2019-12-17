<?php

namespace Spqr\Security\Controller;

use Pagekit\Application as App;
use Spqr\Security\Model\Ban;


/**
 * @Access(admin=true)
 * @return string
 */
class BanController
{
    /**
     * @Access("security: manage bans")
     * @Request({"filter": "array", "page":"int"})
     * @param null $filter
     * @param int  $page
     *
     * @return array
     */
    public function banAction($filter = null, $page = 0)
    {
        return [
            '$view' => [
                'title' => 'Bans',
                'name'  => 'spqr/security:views/admin/ban-index.php',
            ],
            '$data' => [
                'statuses' => Ban::getStatuses(),
                'config'   => [
                    'filter' => (object)$filter,
                    'page'   => $page,
                ],
            ],
        ];
    }
    
    /**
     * @Route("/ban/edit", name="ban/edit")
     * @Access("security: manage bans")
     * @Request({"id": "int"})
     * @param int $id
     *
     * @return array
     */
    public function editAction($id = 0)
    {
        try {
            $module = App::module('spqr/security');
            
            if (!$ban = Ban::where(compact('id'))->related('entries')
                ->first()
            ) {
                if ($id) {
                    App::abort(404, __('Invalid ban id.'));
                }
                $ban = Ban::create([
                        'status' => Ban::STATUS_INACTIVE,
                        'date'   => new \DateTime(),
                    ]);
            }
            
            return [
                '$view' => [
                    'title' => $id ? __('Edit Ban') : __('Add Ban'),
                    'name'  => 'spqr/security:views/admin/ban-edit.php',
                ],
                '$data' => [
                    'ban' => $ban,
                    'statuses' => Ban::getStatuses(),
                ],
            ];
        } catch (\Exception $e) {
            App::message()->error($e->getMessage());
            
            return App::redirect('@security/ban');
        }
    }
    
    /**
     * @Access("security: manage settings")
     */
    public function settingsAction()
    {
        $module = App::module('spqr/security');
        $config = $module->config;
        
        return [
            '$view' => [
                'title' => __('Security Settings'),
                'name'  => 'spqr/security:views/admin/settings.php',
            ],
            '$data' => [
                'config' => App::module('spqr/security')->config(),
            ],
        ];
    }
    
    /**
     * @Request({"config": "array"}, csrf=true)
     * @param array $config
     *
     * @return array
     */
    public function saveAction($config = [])
    {
        App::config()->set('spqr/security', $config);
        
        return ['message' => 'success'];
    }
    
}