<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 13/03/2018
 * Time: 18:04
 */
namespace Ztbopen\Service;

use System\Service\BaseService;

class QrcodeService extends BaseService {

    /**
     * 获取永久二维码
     * @param $scene_id
     * @param $description
     * @param null $appid
     * @return mixed
     */
    static function getLimitScene($scene_id, $description, $appid = null){
        $app = new ApplicationService($appid);
        $api = '/api/open/w/getLimitScene';
        $data = [
            'scene_id' => $scene_id,
            'description' => $description,
        ];
        return $app->http_get($api, $data);
    }

    /**
     * 获取临时二维码
     * @param $scene_id
     * @param $expire_seconds
     * @param $description
     * @param null $appid
     * @return array
     */
    static function getScene($scene_id, $expire_seconds, $description, $appid = null){
        $app = new ApplicationService($appid);
        $api = '/api/open/w/getScene';
        $data = [
            'scene_id' => $scene_id,
            'expire_seconds' => $expire_seconds,
            'description' => $description
        ];
        return $app->http_get($api, $data);
    }

    /**
     * 通过OpenId获取扫描记录
     * @param $open_id
     * @param $event //subscribe|SCAN
     * @param $page
     * @param $limit
     * @param $order
     * @param null $appid
     * @return array
     */
    static function getSceneByOpenId($open_id, $event = '', $page = '', $limit = '', $order = '', $appid = null){
        $app = new ApplicationService($appid);
        $api = '/api/open/w/getSceneByOpenId';
        $data = [
            'open_id' => $open_id,
            'event' => $event,
            'page' => $page,
            'limit' => $limit,
            'order' => $order
        ];
        return $app->http_get($api, $data);
    }


}