<?php
/**
 * Created by PhpStorm.
 * User: localuser1
 * Date: 2019/3/8
 * Time: 下午2:37
 */

namespace App\Api;

use PhalApi\Api;

use App\Common\IFilter;
class KeymapController extends Api
{
    /**
     * 定制接口请求参数
     * @return array
     */
    public function getRules() {
        return array(
             'josnView' => array(
                 'rc'  => array('name' => 'rc', 'default' => '', 'desc' => 'sn 序列号'),
             ),

        );
    }


    public function jsonView()
    {
        $rc = IFilter::act($this->rc,'string',18);
    }

}