<?php
/**
 * Created by PhpStorm.
 * User: yezhilie
 * Date: 16/03/2018
 * Time: 10:48
 */
namespace Ztbopen\Controller;

use Common\Controller\Base;
use System\Service\OrderService;
use Ztbopen\Service\WechatPayService;

class WechatNotifyController extends Base {

    /**
     * 支付回调
     */
    public function notify(){
        $res = WechatPayService::checkPayNotifySign();
        if($res){
            // TODO 支付成功逻辑
            $order_sn = I('post.out_trade_no'); //订单号
            OrderService::doPay($order_sn);

            echo 'SUCCESS';
        }else{
            echo 'ERROR';
        }
    }

}