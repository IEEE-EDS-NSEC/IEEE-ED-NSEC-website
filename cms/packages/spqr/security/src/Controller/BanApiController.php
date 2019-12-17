<?php

namespace Spqr\Security\Controller;

use Pagekit\Application as App;
use Spqr\Security\Model\Ban;

/**
 * @Access("security: manage bans")
 * @Route("ban", name="ban")
 */
class BanApiController
{
    /**
     * @param array $filter
     * @param int   $page
     * @param int   $limit
     * @Route("/", methods="GET")
     * @Request({"filter": "array", "page":"int", "limit":"int"})
     *
     * @return mixed
     */
    public function indexAction($filter = [], $page = 0, $limit = 0)
    {
        $query  = Ban::query();
        $filter = array_merge(array_fill_keys([
            'status',
            'search',
            'limit',
            'order',
        ], ''), $filter);
        extract($filter, EXTR_SKIP);
        if (is_numeric($status)) {
            $query->where(['status' => (int)$status]);
        }
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->orWhere([
                    'ip LIKE :search',
                ], ['search' => "%{$search}%"]);
            });
        }
        if (preg_match('/^(ip|jail|date)\s(asc|desc)$/i', $order, $match)) {
            $order = $match;
        } else {
            $order = [1 => 'date', 2 => 'asc'];
        }
        $default = App::module('spqr/security')->config('items_per_page');
        $limit   = min(max(0, $limit), $default) ? : $default;
        $count   = $query->count();
        $pages   = ceil($count / $limit);
        $page    = max(0, min($pages - 1, $page));
        $bans    = array_values($query->offset($page * $limit)->limit($limit)
            ->orderBy($order[1], $order[2])->get());
        
        return compact('bans', 'pages', 'count');
    }
    
    /**
     * @Route("/{id}", methods="GET", requirements={"id"="\d+"})
     * @param $id
     *
     * @return static
     */
    public function getAction($id)
    {
        if (!$ban = Ban::where(compact('id'))->related('entries')->first()) {
            App::abort(404, 'Ban not found.');
        }
        
        return $ban;
    }
    
    /**
     * @Route(methods="POST")
     * @Request({"ids": "int[]"}, csrf=true)
     * @param array $ids
     *
     * @return array
     */
    public function copyAction($ids = [])
    {
        foreach ($ids as $id) {
            if ($ban = Ban::find((int)$id)) {
                if (!App::user()->hasAccess('security: manage bans')) {
                    continue;
                }
                $ban         = clone $ban;
                $ban->id     = null;
                $ban->status = $ban::STATUS_INACTIVE;
                $ban->date   = new \DateTime();
                $ban->save();
            }
        }
        
        return ['message' => 'success'];
    }
    
    /**
     * @Route("/bulk", methods="POST")
     * @Request({"bans": "array"}, csrf=true)
     * @param array $bans
     *
     * @return array
     */
    public function bulkSaveAction($bans = [])
    {
        foreach ($bans as $data) {
            $this->saveAction($data, isset($data['id']) ? $data['id'] : 0);
        }
        
        return ['message' => 'success'];
    }
    
    /**
     * @Route("/", methods="POST")
     * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
     * @Request({"ban": "array", "id": "int"}, csrf=true)
     */
    public function saveAction($data, $id = 0)
    {
        if (!$id || !$ban = Ban::find($id)) {
            if ($id) {
                App::abort(404, __('Ban not found.'));
            }
            $ban = Ban::create();
        }
        
        $ban->save($data);
        
        return ['message' => 'success', 'ban' => $ban];
    }
    
    /**
     * @Route("/bulk", methods="DELETE")
     * @Request({"ids": "array"}, csrf=true)
     * @param array $ids
     *
     * @return array
     */
    public function bulkDeleteAction($ids = [])
    {
        foreach (array_filter($ids) as $id) {
            $this->deleteAction($id);
        }
        
        return ['message' => 'success'];
    }
    
    /**
     * @Route("/{id}", methods="DELETE", requirements={"id"="\d+"})
     * @Request({"id": "int"}, csrf=true)
     * @param $id
     *
     * @return array
     */
    public function deleteAction($id)
    {
        if ($ban = Ban::find($id)) {
            if (!App::user()->hasAccess('security: manage bans')) {
                App::abort(400, __('Access denied.'));
            }
            $ban->delete();
        }
        
        return ['message' => 'success'];
    }
    
}