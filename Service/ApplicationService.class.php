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
use Ztbopen\Model\ApplicationModel;

class ApplicationService extends BaseService {
    public $app_id = null;
    protected $app_secret = null;

    public $domain = 'http://app.ztbopen.cn';

    function __construct($app_id = null) {
        $application = new ApplicationModel();
        $where = [];
        if ($app_id) {
            $where = ['app_id' => $app_id];
        }
        $res = $application->where($where)->order('is_default desc')->find();
        $this->app_id = $res['app_id'];
        $this->app_secret = $res['app_secret'];
    }

    /**
     * 签名
     * @param $data
     * @return string
     */
    public function getSign($data){
        ksort($data);
        $str = '';
        foreach ($data as $key => $value) {
            $str .= $key . "=" . trim($value) . '&';
        }
        return strtolower(md5($str . $this->app_secret));
    }

    public function http_get($api, $data){
        $url = $this->domain . $api;
        $data = array_merge([
            'app_id' => $this->app_id,
            'time' => time()
        ], $data);
        $data['sign'] = $this->getSign($data);

        $http = new HttpUtil();
        $res = $http->http_get($url, $data);
        return json_decode($res, 1);
    }

    public function http_post($api, $data){
        $url = $this->domain . $api;
        $data = array_merge([
            'app_id' => $this->app_id,
            'time' => time()
        ], $data);
        $data['sign'] = $this->getSign($data);

        $http = new HttpUtil();
        $res = $http->http_post($url, $data);
        return json_decode($res, 1);
    }
}