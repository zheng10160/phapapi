<?php
/**
 * Created by PhpStorm.
 * User: localuser1
 * Date: 2019/3/8
 * Time: 下午5:35
 */

namespace App\Common\core;


class sp_model
{

    /**
     * 数据库名称 严格对应配置文件
     * @var string
     */
    protected $db_name;

    /**********************************************存储过程可以使用的几个方法***************************************************************/
    /**
     * 有返回参数 @ret 处理方法
     * @param $sql
     * @return bool|mixed
     */
    public function exec_call_sp($sql)
    {

        try {
            //使用PDO中的方法执行语句
            /*  $this->connection->query("call sp_boot_test(@ret)");*/
            Db::pdo($this->db_name)->query($sql);

            $stmt = Db::pdo($this->db_name)->query('select @ret');
            $rows = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $rows;

        }catch(\Exception $e) {

            return "The call to the stored procedure {$sql} failed"."\r\n";
        }
    }

    /**
     * no parameter  无参数的存储过程调用
     * 处理返回多个结果集的处理 多个select
     * @param $sql
     * @return array
     */
    public function exec_sp_multiple_data($sql)
    {
        $stmt = Db::pdo($this->db_name)->query($sql);

        $res = [];//结果集数组
        $i = 0;
        try{
            do {
                $rows = $stmt->fetch(\PDO::FETCH_ASSOC);
                if($rows){
                    $res[$i] = $rows;

                    $i +=1;
                }
            } while ($stmt->nextRowset());
        }catch (\Exception $e){
            //特殊错误不处理
        }

        return $res;
    }
    /**
     *  \PDO::FETCH_NUM 键是数字
     * no parameter  无参数的存储过程调用
     * @param $sql
     * @return bool|mixed 返回对象 如：$obj->name,$obj->id
     */
    public function exec_sp_obj($sql)
    {

        try {
            //使用PDO中的方法执行语句
            $stmt = Db::pdo($this->db_name)->prepare($sql);
            // $stmt->bindParam(1, $return_value, \PDO::PARAM_STR, 4000); //执行存储过程
            $stmt->execute();
            $row = $stmt->fetchObject();

            return $row;

        }catch(\Exception $e) {

            return "The call to the stored procedure {$sql} failed"."\r\n";
        }
    }

    /**
     * no parameter  无参数的存储过程调用
     * @param $sql
     * @return [] 返回数组
     */
    public function exec_sp_assoc($sql)
    {

        try {
            //使用PDO中的方法执行语句
            $stmt = Db::pdo($this->db_name)->prepare($sql);
            // $stmt->bindParam(1, $return_value, \PDO::PARAM_STR, 4000); //执行存储过程
            $stmt->execute();
            $row = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $row;

        }catch(\Exception $e) {

            return "The call to the stored procedure {$sql} failed"."\r\n";
        }
    }

    /**
     * 多条数据
     * no parameter  无参数的存储过程调用
     * @param $sql
     * @return [] 返回数组
     */
    public function exec_sp_assoc_all($sql)
    {

        try {
            //使用PDO中的方法执行语句
            $stmt = Db::pdo($this->db_name)->prepare($sql);
            // $stmt->bindParam(1, $return_value, \PDO::PARAM_STR, 4000); //执行存储过程
            $stmt->execute();
            $row = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $row;

        }catch(\Exception $e) {

            return "The call to the stored procedure {$sql} failed"."\r\n";
        }
    }
    /**************************************end *****************************************/
}