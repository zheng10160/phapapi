<?php
/**
 * Created by PhpStorm.
 * User: localuser1
 * Date: 2019/3/8
 * Time: 下午3:03
 */

namespace App\Api;

use App\Common\IReq;
use App\Common\IFilter;

use App\Common\rpc\RpcClient;
class BaseController extends BaseCore
{

    //预先执行
     public function beforeAction()
      {
          $client_id = IFilter::act(IReq::get('client_id'),'string',32);

          $access_token = IFilter::act(IReq::get('access_token'),'string',50);


          if(!$client_id){
             return \App\show_json(100105,'lack client_id parameter');
          }
          if(!$access_token){
             return \App\show_json(100105,'lack access_token parameter');
          }

          $this->getUserinfoFromLocalRedis($access_token,$client_id);
          return true;
      }


    /**
     * 验证是否有登陆 access_tokenshi是否有效
     * @param $access_token
     * @param $client_id
     */
    protected function getUserinfoFromLocalRedis($access_token,$client_id)
    {

        try{
            $userinfo = json_decode($this->getLocalUserInfoFromRedis($access_token),true);//查询redis是否有缓存数据

            if(!$userinfo){//说明本地redis没有记录用户信息或者已经⃣️过期 所以需要重新请求验证access_toekn

                $userinfo = $this->getUserInfoRpc($client_id,$access_token,\PhalApi\DI()->config->get('app.yar_server_address'));

                if($userinfo['code'] === 0){
                    $userinfo = $userinfo['data'];
                }else{
                    //100012 只要获取失败 都需要从新登陆
                    return \App\show_json(100012,'Please log in again');
                    exit;
                }
                //redis 只保存部分基本信息
                $userinfo['access_token'] = $access_token;

                $this->setLocalUserInfoFromRedis($access_token,$userinfo);//查询redis是否有缓存数据

            }

            $this->userid = $userinfo['user_id'];
            $this->openid = $userinfo['openid'];
            $this->access_token  = $userinfo['access_token'];
            $this->uuid = $userinfo['uuid'];
        }catch (\Exception $e){
            return \App\show_json(100000,'Interface fails to validate user token information');//接口验证用户token信息失败
        }


    }

    /**
     * 获取本地用户缓存信息
     * @param $access_token
     * @param $redis_handler
     * @return mixed
     */
    protected function getLocalUserInfoFromRedis($access_token){

        $key = \PhalApi\DI()->config->get('sys.api_user_redis_key').$access_token;//查询本地服务器是否有用户信息缓存

        $userInfo = \PhalApi\DI()->redis->get_forever($key,1);

        return $userInfo;
    }

    /**
     * 缓存本地用户数据信息
     * @param $access_token
     * @param $userInfo
     * @param $redis_handler
     */
    protected function setLocalUserInfoFromRedis($access_token,$userInfo)
    {
        $key = \PhalApi\DI()->config->get('sys.api_user_redis_key').$access_token;//查询本地服务器是否有用户信息缓存

        \PhalApi\DI()->redis->set_time($key,json_encode($userInfo),1800,1);

    }

    /**
     * 实例化 rpc调用模式
     * @param $client_id
     * @param $access_token
     * @param $url 请求的远程地址
     * @return mixed
     */
    protected function getUserInfoRpc($client_id,$access_token,$url)
    {

        $condition = ['class'=>'\app\controllers\AuthController'];
        $AuthController = RpcClient::getClient($condition,$url);

        return $AuthController->checkUserInfo($client_id,$access_token);

    }
}