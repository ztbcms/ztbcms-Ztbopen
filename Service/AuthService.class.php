<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 13/03/2018
 * Time: 18:04
 */
namespace Ztbopen\Service;

use System\Service\BaseService;

class AuthService extends BaseService {

    /**
     * 获取用户授权链接
     * @param $redirect_url
     * @param $appid
     * @return string
     */
    static function oAuth($redirect_url, $appid = null){
        $app = new ApplicationService($appid);
        $data = [
            'app_id' => $app->app_id,
            'time' => time(),
            'redirect_url' => $redirect_url
        ];
        $data['sign'] = $app->getSign($data);
        //urlencode回调地址
        $data['redirect_url'] = urlencode($redirect_url);

        $url = $app->domain . '/open/w/oAuth' . '?';
        foreach($data as $key => $value){
            $url .= $key . '=' . $value . '&';
        }
        return $url;
    }

    /**
     * 获取用户授权链接 静默授权
     * @param $redirect_url
     * @param $appid
     * @return string
     */
    static function oAuthBase($redirect_url, $appid = null){
        $app = new ApplicationService($appid);
        $data = [
            'app_id' => $app->app_id,
            'time' => time(),
            'scope' => 'snsapi_base',
            'redirect_url' => $redirect_url
        ];
        $data['sign'] = $app->getSign($data);
        //urlencode回调地址
        $data['redirect_url'] = urlencode($redirect_url);

        $url = $app->domain . '/open/w/oAuth' . '?';
        foreach($data as $key => $value){
            $url .= $key . '=' . $value . '&';
        }
        return $url;
    }

    /**
     * 获取用户授权信息
     * @param $code
     * @param $appid
     * @return mixed
     */
    static function getUserByCode($code, $appid = null){
        $app = new ApplicationService($appid);
        $api = '/api/open/w/getUserByCode';
        $data = [
            'code' => $code
        ];
        return $app->http_get($api, $data);
    }
}