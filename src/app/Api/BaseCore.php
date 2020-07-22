<?php
/**
 * Created by PhpStorm.
 * User: localuser1
 * Date: 2019/3/8
 * Time: 下午3:03
 */

namespace App\Api;


class BaseCore
{
    /**
     * 用户登陆的 token
     * @var
     */
    protected $access_token;


    /**
     * 系统办法的项目 app_id
     * @var
     */
    protected $client_id;

    /**
     * 用户的openid
     * @var
     */
    protected $openid;


    /**
     * 用户的唯一userid
     * @var
     */
    protected $userid;

    /**
     * 共硬件使用 相当于openid
     * @var
     */
    protected $uuid;
}