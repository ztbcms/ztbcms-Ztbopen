<?php
/**
 * Created by PhpStorm.
 * User: yezhilie
 * Date: 16/03/2018
 * Time: 10:48
 */
namespace Ztbopen\Controller;

use Common\Controller\Base;
use Ztbopen\Service\AuthService;

class WechatAuthController extends Base {

    /**
     * 获取用户授权信息
     */
    public function getUserByCode(){
        $code = I('get.code');
        $appid = I('get.appid', null);
        //获取微信用户资料
        $res = AuthService::getUserByCode($code, $appid);
        if(!$res['status']){
            //TODO
        }
        if($res['data']['id']){
            unset($res['data']['id']);
        }
        session('wx_user_info', $res['data']);
        $wx_user_info = $res['data'];

        if(!$appid){
            $appid = M('ZtbopenApplications')->where(['is_default' => 1])->getField('app_id');
        }
        $wx_user_info['app_id'] = $appid;

        $is_exists = M('ZtbopenWechat')->where([
            "openid" => $wx_user_info['openid'],
            'authorizer_appid' => $wx_user_info['authorizer_appid']
        ])->find();
        if ($is_exists) {
            $ztbopen_wechat_id = $is_exists['id'];
            M('ZtbopenWechat')->where(["id" => $ztbopen_wechat_id])->save($wx_user_info);
        } else {
            $ztbopen_wechat_id = M('ZtbopenWechat')->add($wx_user_info);
        }

        //检查是否有会员登录，有会员登录自动绑定会员信息
        $userinfo = service("Passport")->getInfo();
        if ($userinfo) {
            //如果不是绑定的原有微信，则取消该绑定，绑定现有的微信
            M('ZtbopenWechat')->where(['userid' => $userinfo['userid']])->save(array('userid' => 0));
            M('ZtbopenWechat')->where(["id" => $ztbopen_wechat_id])->save(array('userid' => $userinfo['userid']));
        }
        redirect(session('wechat_auth_url'));
    }

    /**
     * 获取用户静默授权 openid
     */
    public function getSilentUserByCode(){
        $code = I('get.code');
        $appid = I('get.appid', null);
        //获取微信用户资料
        $res = AuthService::getUserByCode($code, $appid);
        if(!$res['status']){
            //TODO
        }
        session('silent_openid', $res['data']['openid']);
        redirect(session('wechat_silent_auth_url'));
    }
}