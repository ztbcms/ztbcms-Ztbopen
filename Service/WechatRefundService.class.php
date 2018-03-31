<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 13/03/2018
 * Time: 18:04
 */
namespace Ztbopen\Service;

use System\Service\BaseService;
use Ztbopen\Lib\HttpUtil;

class WechatRefundService extends BaseService {

    /**
     * 证书
     *
     * @return string
     */
    protected static function getCertPath(){
        return APP_PATH.'Ztbopen/Cert/apiclient_cert.pem';
    }

    /**
     * 证书
     *
     * @return string
     */
    protected static function getCertKey(){
        return APP_PATH.'Ztbopen/Cert/apiclient_key.pem';
    }

    /**
     * 商户Key
     *
     * @return string
     */
    protected static function getMchKey(){
        //TODO
        return '';
    }

    /**
     * 签名
     *
     * @param $data
     * @return string
     */
    protected static function sign($data){
        ksort($data);
        $str = '';
        foreach ($data as $key => $value) {
            $str .= $key . "=" . trim($value) . '&';
        }
        return strtolower(md5($str . 'key='.self::getMchKey()));
    }

    /**
     * 微信退款
     */
    static function refund($id){

        $wx_order = M('ZtbopenWechatPayOrder')->where(['id' => $id])->find();

        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';

        $nonce_str = md5(time());
        $out_refund_no = date('YmdHis').rand(1000,9999);

        $data = [
            'appid' => $wx_order['appid'],
            'mch_id' => $wx_order['mch_id'],
            'nonce_str' => $nonce_str,
            'out_trade_no' => $wx_order['out_trade_no'],
            'out_refund_no' => $out_refund_no,
            'total_fee' => $wx_order['total_fee'],
            'refund_fee' => $wx_order['total_fee']
        ];
        $data['sign'] = self::sign($data);

        $xml = data_to_xml($data);

        $cert_path = self::getCertPath();
        $cert_key = self::getCertKey();

        $http = new HttpUtil();
        $res = $http->http_post_ssl($url, '<xml>'.$xml.'</xml>', $cert_path, $cert_key);
        if($res){
            $data = self::xmlToArray($res);
            $id = M('ZtbopenWechatRefundOrder')->add($data);
            if($data['result_code'] == 'SUCCESS'){
                return self::createReturn(true, $id);
            }
            return self::createReturn(false, null, $data['err_code_des']);
        }else{
            return self::createReturn(false, null, '请求错误');
        }

    }

    static function xmlToArray($xml){
        if (file_exists($xml)) {
            libxml_disable_entity_loader(false);
            $xml_string = simplexml_load_file($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        }else{
            libxml_disable_entity_loader(true);
            $xml_string = simplexml_load_string($xml,'SimpleXMLElement', LIBXML_NOCDATA);
        }
        $result = json_decode(json_encode($xml_string),true);
        return $result;
    }
}