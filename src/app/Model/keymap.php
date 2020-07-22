<?php
namespace App\Model;
/**
 * Created by PhpStorm.
 * User: localuser1
 * Date: 2019/3/8
 * Time: 下午4:56
 */
use App\Common\core\sp_model;
class keymap extends sp_model
{
    /**
     * 数据库名称 严格对应配置文件
     * @var string
     */
    protected $db_name = 'hardware';


    public function test()
    {
        var_dump($this->exec_sp_assoc_all('call sp_tt()'));die;

    }
}