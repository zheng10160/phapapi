<?php
/**
 * 统一访问入口
 */
require_once dirname(__FILE__) . '/init.php';

//上传的文件都使用当前常量
define('ROOT_PATH', __DIR__ . '/');

//显式初始化，并调用分发
\PhalApi\DI()->fastRoute = new PhalApi\FastRoute\Lite();
\PhalApi\DI()->fastRoute->dispatch();

// 惰性加载Redis
\PhalApi\DI()->redis = function () {
    return new \PhalApi\Redis\Lite(\PhalApi\DI()->config->get("sys.redis"));
};


//存储过程直接操作pdo
\PhalApi\DI()->dbsp = new App\Common\core\Db($di->config->get('dbs.servers.db_master'));

$pai = new \PhalApi\PhalApi();

$pai->response()->output();

