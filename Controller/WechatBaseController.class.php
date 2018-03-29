<?php
/**
 * Created by PhpStorm.
 * User: yezhilie
 * Date: 16/03/2018
 * Time: 09:16
 */
namespace Ztbopen\Controller;

use Common\Controller\Base;
use Ztbopen\Service\AuthService;

/**
 * 微信授权登录
 * Class WechatBaseController
 * @package Ztbopen\Controller
 */
class WechatBaseController extends Base {

    public $wx_user_info = array();

    protected function _initialize() {
        parent::_initialize();

        if (session('wx_user_info')) {
            $this->wx_user_info = session('wx_user_info');
        } else {
            //保存当前地址到session
            session('wechat_auth_url', get_url());
            //获取授权地址并跳转
            $appid = I('get.appid', null);

            $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
            $auth_url = $sys_protocal . $_SERVER['HTTP_HOST'] . '/Ztbopen/WechatAuth/getUserByCode';

            $url = AuthService::oAuth($auth_url, $appid);
            redirect($url);
        }
    }

}