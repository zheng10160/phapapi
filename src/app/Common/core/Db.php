<?php
namespace App\Common\core;

use PDO;
use PDOException;
/**
 * 数据库操作类。
 * 其$pdo属性为静态属性，所以在页面执行周期内，
 * 只要一次赋值，以后的获取还是首次赋值的内容。
 * 这里就是PDO对象，这样可以确保运行期间只有一个
 * 数据库连接对象，这是一种简单的单例模式
 * Class Db
 */
class Db
{
    private static $pdo = null;

    /**
     *
     * @param $db_key  配置字段 不同连接需要字段区分
     * @param $dbHandler 配置wwenjian     * @return null|PDO
     */
    public static function pdo($db_key)
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        try {
            $db_arr = \PhalApi\DI()->config->get('dbs.servers');//数据库数组

            return self::$pdo = self::newDb($db_arr[$db_key]);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function newDb($db_conf)
    {
        $dsn    = sprintf('mysql:host=%s;dbname=%s;charset=utf8', $db_conf['host'], $db_conf['name']);
        $option = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

        return new PDO($dsn, $db_conf['user'], $db_conf['password'], $option);
    }
}