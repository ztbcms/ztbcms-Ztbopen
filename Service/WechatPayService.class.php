<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 13/03/2018
 * Time: 18:04
 */
namespace Ztbopen\Service;

use System\Service\BaseService;

class WechatPayService extends BaseService {

    /**
     * 获取微信支付配置
     * @param $open_id
     * @param $out_trade_no
     * @param $total_fee
     * @param $body
     * @param null $appid
     * @return array
     */
    static function wxpayJs($open_id, $out_trade_no, $total_fee, $body, $appid = null){
        $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $notify_url = $sys_protocal . $_SERVER['HTTP_HOST'] . '/Ztbopen/WechatNotify/notify';
        $app = new ApplicationService($appid);
        $api = '/api/open/w/wxpayJs';
        $data = [
            'open_id' => $open_id,
            'out_trade_no' => $out_trade_no,
            'total_fee' => $total_fee,
            'body' => $body,
            'notify_url' => $notify_url
        ];
        return $app->http_post($api, $data);
    }

    /**
     * 支付回调签名检测
     */
    static function checkPayNotifySign(){
        $data = I('post.');

        $open_sign = $data['open_sign'];
        unset($data['open_sign']);

        $app_id = M('ZtbopenWechat')->where(['openid' => $data['openid']])->getField('app_id');
        $app = new ApplicationService($app_id);
        $local_sign = $app->getSign($data);
        if($open_sign == $local_sign){
            //签名验证成功
            if($data['result_code'] == 'SUCCESS'){
                self::updateWxpayOrderInfo($data);
                return true;
            }
        }
        return false;
    }


    /**
     * 更新从微信获取支付订单的信息
     *
     * @param $data
     */
    static function updateWxpayOrderInfo($data) {
        $is_exist = M('ZtbopenWechatPayOrder')->where(['out_trade_no' => $data['out_trade_no']])->find();
        if ($is_exist) {
            //如果存在
            $res = M('ZtbopenWechatPayOrder')->where(['id' => $is_exist['id']])->save($data);
        } else {
            $res = M('ZtbopenWechatPayOrder')->add($data);
        }
        if ($res) {
            self::createReturn(true, $res, 'ok');
        } else {
            self::createReturn(false, '', 'fail');
        }
    }
}