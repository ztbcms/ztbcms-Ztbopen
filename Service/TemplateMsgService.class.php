<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 13/03/2018
 * Time: 18:04
 */
namespace Ztbopen\Service;

use System\Service\BaseService;

class TemplateMsgService extends BaseService {

    /**
     * 发送模板消息
     * @param string $openid 接收用户的openid
     * @param string $template_id 模板消息id
     * @param string $url 点击模板消息跳转页面
     * @param array $data 发送数据
     * @param $appid
     * @return array
     */
    static function sendTemplateMsg($openid, $template_id, $url, $data, $appid = null){
        $app = new ApplicationService($appid);
        $api = '/api/open/w/sendTemplateMsg';
        $data = [
            'touser' => $openid,
            'template_id' => $template_id,
            'url' => $url,
            'data' => serialize($data)
        ];
        return $app->http_post($api, $data);
    }

}