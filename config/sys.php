<?php
/**
 * 以下配置为系统级的配置，通常放置不同环境下的不同配置
 *
 * @license     http://www.phalapi.net/license GPL 协议
 * @link        http://www.phalapi.net/
 * @author dogstar <chanzonghuang@gmail.com> 2017-07-13
 */

return array(
    /**
     * 默认环境配置
     */
    'debug' => false,

    /**
     * MC缓存服务器参考配置
     */
    'mc' => array(
        'host' => '127.0.0.1',
        'port' => 11211,
    ),

    /**
     * Redis缓存服务器参考配置
     */
    'redis' => [
        'host' => '192.168.90.33',
        'port' => 6379,
        'prefix' => '',
        'auth' => '123456',
    ],
	
    /**
     * 加密
     */
    'crypt' => array(
        'mcrypt_iv' => '12345678', //8位
    ),

    'yar_server_address' => 'http://test.auth.senseplay.cn/yarlist/auth',//rpc 服务器地址
    'api_user_redis_key' => 'global_access_token_info:',//全局缓存在redis access_token键
);
