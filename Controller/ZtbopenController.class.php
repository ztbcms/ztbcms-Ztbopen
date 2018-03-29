<?php
/**
 * Created by PhpStorm.
 * User: zhlhuang
 * Date: 12/03/2018
 * Time: 14:16
 */
namespace Ztbopen\Controller;

use Common\Controller\AdminBase;
use Ztbopen\Model\ApplicationModel;
use Ztbopen\Service\TemplateMsgService;

class ZtbopenController extends AdminBase {
    function index() {
        $this->display('index');
    }

    /**
     * 获取应用详情
     */
    function getApplicationDetail() {
        $id = I('get.id');
        $application = new ApplicationModel();
        $res = $application->where(['id' => $id])->find();
        if ($res) {
            $this->ajaxReturn(self::createReturn(true, $res));
        } else {
            $this->ajaxReturn(self::createReturn(false, [], '找不到该记录'));
        }
    }

    /**
     * 获取应用列表
     */
    function getApplications() {
        $application = new ApplicationModel();
        $page = I('page', 1);
        $limit = I('limit', 20);
        $where = [];
        $res = $application->where($where)->page($page, $limit)->order('id desc')->select();
        $total = $application->where($where)->count();
        $data = [
            'items' => $res ? $res : [],
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil($total / $limit)
        ];
        $this->ajaxReturn(self::createReturn(true, $data, ''));
    }

    /**
     * 创建编辑应用
     */
    function createApplication() {
        if (IS_POST) {
            $id = I('post.id');
            $name = I('post.name');
            $app_id = I('post.app_id');
            $app_secret = I('post.app_secret');
            $is_default = I('post.is_default');
            $application = new ApplicationModel();
            if ($is_default == '1') {
                $application->where(['is_default' => 1])->save(['is_default' => 0]);
            }
            $data = [
                'name' => $name,
                'app_id' => $app_id,
                'app_secret' => $app_secret,
                'is_default' => $is_default,
                'create_time' => time(),
                'update_time' => time()
            ];
            if ($id) {
                $res = $application->where(['id' => $id])->save($data);
            } else {
                $res = $application->add($data);
            }
            if ($res) {
                $this->ajaxReturn(self::createReturn(true, [], '添加成功'));
            } else {
                $this->ajaxReturn(self::createReturn(false, [], '操作失败'));
            }
        } else {
            $this->display('createApplication');
        }
    }

    /**
     * 删除应用
     */
    function deleteApplication() {
        $id = I('post.id');
        $application = new ApplicationModel();
        $res = $application->where(['id' => $id])->delete();
        if ($res) {
            $this->ajaxReturn(self::createReturn(true, $res));
        } else {
            $this->ajaxReturn(self::createReturn(false, [], '找不到该记录'));
        }
    }

    /**
     * 模板消息列表页面
     */
    public function templateList() {
        $this->display();
    }

    /**
     * 获取模版消息列表
     */
    public function getTemplateList(){
        $app_id = I('get.app_id');
        $list = M('ZtbopenWechatTemplate')->where(['app_id' => $app_id])->select();
        $this->ajaxReturn(self::createReturn(true, $list?$list:[]));
    }

    /**
     * 编辑模板消息页
     */
    public function template() {
        $this->display();
    }

    /**
     * 获取模版消息
     */
    public function getTemplate(){
        $app_id = I('get.app_id');
        $id = I('get.id');
        $data = M('ZtbopenWechatTemplate')->where(['app_id' => $app_id, 'id' => $id])->find();
        $this->ajaxReturn(self::createReturn(true, $data));
    }

    /**
     * 编辑模板消息操作
     */
    public function addEditTemplate() {
        $data = I('post.');
        $id = $data['id'];
        if (empty($id)) {
            $id = M('ZtbopenWechatTemplate')->add($data);
        }else{
            unset($data['id']);
            M('ZtbopenWechatTemplate')->where(['id' => $id])->save($data);
        }
        $url = U('Ztbopen/Ztbopen/templateList', ['app_id' => $data['app_id']]);
        $this->ajaxReturn(self::createReturn(true, $id, '操作成功' , '', $url));
    }

    /**
     * 删除模板消息操作
     */
    public function delTemplate(){
        $app_id = I('post.app_id');
        $id = I('post.id');
        $result = M('ZtbopenWechatTemplate')->where(['id' => $id])->delete();
        $url = U('Ztbopen/Ztbopen/templateList', ['app_id' => $app_id]);
        $this->ajaxReturn(self::createReturn(true, $result, '操作成功' , '', $url));
    }

    /**
     * 发送模版消息
     */
    public function sendTplMessage(){
        $app_id = I('get.app_id');
        $id = I('get.id');
        $data = M('ZtbopenWechatTemplate')->where(['app_id' => $app_id, 'id' => $id])->find();
        $this->assign('data', $data);
        $this->display();
    }

    /**
     * 发送模版消息
     */
    public function doSend(){
        $openid = I('post.openid');
        if(!$openid){
            $this->ajaxReturn(self::createReturn(true, null, '缺少参数：openid'));
        }
        $params = I('post.params');
        $id = I('post.id');

        $template = M('ZtbopenWechatTemplate')->where(['id' => $id])->find();
        $template_id = $template['template_id'];
        $app_id = $template['app_id'];

        $res = TemplateMsgService::sendTemplateMsg($openid, $template_id, 'http://www.zhutibang.cn', $params, $app_id);
        if($res['status']){
            $this->ajaxReturn(self::createReturn(true, null, '发送成功'));
        }else{
            $this->ajaxReturn(self::createReturn(true, null, '发送失败'));
        }
    }
}