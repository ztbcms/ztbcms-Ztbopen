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
 * 微信授权登录 静默授权
 * Class WechatBaseController
 * @package Ztbopen\Controller
 */
class WechatSilentBaseController extends Base {

    public $silent_openid = '';

    protected function _initialize() {
        parent::_initialize();

        if (session('silent_openid')) {
            $this->silent_openid = session('silent_openid');
        } else {
            //保存当前地址到session
            session('wechat_silent_auth_url', get_url());
            //获取授权地址并跳转
            $appid = I('get.appid', null);

            $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
            $auth_url = $sys_protocal . $_SERVER['HTTP_HOST'] . '/Ztbopen/WechatAuth/getSilentUserByCode';

            $url = AuthService::oAuthBase($auth_url, $appid);
            redirect($url);
        }
    }

}