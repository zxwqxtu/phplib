<?php
/**
 * Mongodb单例模型
 * Mongodb连接
 *
 * @author by wangqiang <wangqiang@e.hunantv.com>
 */
namespace Mongodb;

/**
 * Mongodb连接
 *
 * Mongodb\Connect
 * \Mongodb\Connect::getInstance()->connect($config)
 */
class PhpMongo 
{
    private static $_instance = null; 
    private $_conns = array();

    /**
     * 构造函数
     */
    private function __construct()
    {
        //pass
    }

    /**
     * 单列模式
     *
     * @return \Mongodb\Connect
     */
    public static function getInstance()
    {
        if (!is_null(self::$_instance)) {
            return self::$_instance;
        }

        self::$_instance = new self();
        return self::$_instance;
    }

    /**
     * 连接mongodb
     *
     * @param array  $config array('server'=>'', 'options'=>'')
     * @param string $db     dbName
     *
     * @return MongoClient|MongoDB
     */
    public function connect(array $config = array(), $db='')
    {
        if (empty($config['server'])) {
            throw new \Exception("mongodb connect server fail");
        }
        $server = $config['server'];

        $options = array("connect" => true);
        if (!empty($config['options'])) {
            $options = array_merge($options, $config['options']);
        }

        $_md5 = md5(serialize(array($server, $options)));
        if (empty($this->_conns[$_md5])) {
            $this->_conns[$_md5] = new \MongoClient($server, $options);
        }
        
        if (!empty($db)) {
            return $this->_conns[$_md5]->selectDB($db);
        }
        return $this->_conns[$_md5];
    }
}
