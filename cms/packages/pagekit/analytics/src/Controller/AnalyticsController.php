<?php

namespace Pagekit\Analytics\Controller;

use Pagekit\Application as App;

/**
 * @Access(admin=true)
 * @Route("analytics", name="analytics")
 */
class AnalyticsController
{
    const API = 'https://www.googleapis.com/analytics/v3';
    const REDIRECT_URI = 'urn:ietf:wg:oauth:2.0:oob';
    const CACHE_TIME = 3600;
    const REALTIME_CACHE_TIME = 20;

    protected $extension, $oauth;

    /**
     * @Route("/auth", methods="GET")
     */
    public function authRedirectAction()
    {
        try {
            $config = App::module('analytics')->config();
            $service = App::get('analytics/oauth')->create('google', $config['credentials'], false, self::REDIRECT_URI, array('ANALYTICS', 'USERINFO_PROFILE'));

            $service->setAccessType('offline');
            $authorizationUri = $service->getAuthorizationUri(array('approval_prompt' => 'force'));

            return App::response()->redirect($authorizationUri);
        } catch (\Exception $e) {
            return App::response($e->getMessage(), 400);
        }
    }

    /**
     * @Route("/code", methods="POST")
     * @Request({"code": "string"})
     */
    public function authCodeAction($code)
    {
        try {
            $oauth = App::get('analytics/oauth');
            $config = App::module('analytics')->config();

            $token = $oauth->requestToken('google', $code, $config['credentials'], self::REDIRECT_URI);

            App::config('analytics')->set('token', $oauth->tokenToArray($token));

            return App::response()->json(['success' => true]);
        } catch (\Exception $e) {
            return App::response()->json(array('message' => $e->getMessage()), 400);
        }
    }

    /**
     * @Route("/user", methods="GET")
     */
    public function userAction()
    {
        try {
            return App::response()->json($this->request('https://www.googleapis.com/oauth2/v1/userinfo', ['id', 'name']));
        } catch (\Exception $e) {
            return App::response()->json(array('message' => $e->getMessage()), 400);
        }
    }

    /**
     * @Route("/api", methods="GET")
     * @Request({"metrics": "string", "dimensions":"string", "startDate":"string", "filters":"string", "invalidCache": "boolean", "sort":"string", "maxResults": "int"})
     */
    public function apiAction($metrics, $dimensions, $startDate, $filters = false, $invalidCache = false, $sort = false, $maxResults = false)
    {
        $config = App::module('analytics')->config();

        if (!isset($config['profile']['profileId'])) {
            return App::response()->json(array('message' => 'Not configured'), 400);
        }

        $data = array('metrics' => $metrics,
            'dimensions' => $dimensions,
            'start-date' => $startDate,
            'ids' => 'ga:' . $config['profile']['profileId'],
            'end-date' => 'today',
            'output' => 'dataTable');

        if ($sort) {
            $data['sort'] = $sort;
        }

        if ($maxResults) {
            $data['max-results'] = $maxResults;
        }

        if ($filters) {
            $data['filters'] = $filters;
        }

        $url = self::API . '/data/ga?' . http_build_query($data);

        if ($invalidCache || !$result = App::get('cache')->fetch($url)) {
            try {
                $result = $this->request($url, ['columnHeaders', 'totalsForAllResults', 'dataTable']);
                $result['time'] = time();

                App::get('cache')->save($url, $result, self::CACHE_TIME);
            } catch (\Exception $e) {
                return App::response()->json(array('message' => $e->getMessage()), 400);
            }
        }

        return App::response()->json($result);
    }

    /**
     * @Route("/realtime", methods="GET")
     * @Request({"metrics": "string", "dimensions":"string", "invalidCache": "boolean"})
     */
    public function realtimeAction($metrics, $dimensions, $invalidCache = false)
    {
        $config = App::module('analytics')->config();

        if (!isset($config['profile']['profileId'])) {
            return $this['response']->json(array('message' => 'Not configured'), 400);
        }

        $data = array('metrics' => $metrics,
            'dimensions' => $dimensions,
            'ids' => 'ga:' . $config['profile']['profileId'],
            'output' => 'dataTable');

        $url = self::API . '/data/realtime?' . http_build_query($data);

        if ($invalidCache || !$result = App::get('cache')->fetch(md5($url))) {
            try {
                $result = $this->request($url, ['columnHeaders', 'totalsForAllResults', 'dataTable']);
                $result['time'] = time();

                App::get('cache')->save(md5($url), $result, self::REALTIME_CACHE_TIME);
            } catch (\Exception $e) {
                return App::response()->json(array('message' => $e->getMessage()), 400);
            }
        }

        return App::response()->json($result);
    }

    /**
     * @Route("/profile", methods="GET")
     */
    public function profileAction()
    {
        try {
            return App::response()->json($this->request(self::API . '/management/accounts/~all/webproperties/~all/profiles', ['items']));
        } catch (\Exception $e) {
            return App::response()->json(array('message' => $e->getMessage()), 400);
        }
    }

    /**
     * @Route("/profile", methods="POST")
     * @Request({"accountId": "int", "propertyId": "int", "profileId": "int"})
     */
    public function saveProfileAction($accountId, $propertyId = 0, $profileId = 0)
    {
        if ($accountId == 0) {
            unset(App::config('analytics')['profile']);
        } else {
            App::config('analytics')->set('profile', compact("accountId", "propertyId", "profileId"));
        }

        return App::response()->json(array('profile' => App::config('analytics')->get('profile')));
    }

    /**
     * @Route("/disconnect", methods="DELETE")
     */
    public function disconnectAction()
    {
        unset(App::config('analytics')['profile']);
        unset(App::config('analytics')['token']);

        return App::response()->json(array());
    }

    protected function request($url, $filter = [])
    {
        $config = App::module('analytics')->config();
        $service = App::get('analytics/oauth')->create('google', $config['credentials'], $config['token']);
        $result = json_decode($service->request($url), true);

        if ($filter) {
            $return = [];
            foreach ($filter as $key) {
                if (isset($result[$key])) {
                    $return[$key] = $result[$key];
                }
            }
        } else {
            $return = $result;
        }

        return $return;
    }
}
