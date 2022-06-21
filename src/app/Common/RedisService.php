<?php
/**
 * @noinspection PhpUnused
 * @noinspection PhpMultipleClassDeclarationsInspection
 */

namespace App\Common;

use PhalApi\Exception;
use Redis;

class RedisService
{
    private static $_instance;
    public $redis;
    private $host;
    private $auth;
    private $db;
    private $port;
    private $timeout;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        if (!class_exists('Redis')) {
            throw new Exception('redis not install!');
        }

        $conf = config('sys.redis');
        $this->host = $conf['host'] ?? 'localhost';
        $this->db = $conf['db'] ?? 0;
        $this->port = $conf['port'] ?? 6379;
        $this->timeout = $conf['timeout'] ?? 0;

        $this->redis = new Redis();
        $result = $this->redis->connect($this->host, $this->port, $this->timeout);
        if (!$result) {
            throw new Exception('redis connect fail');
        }

        if ($conf['auth']) {
            $this->auth($conf['auth']);
            $this->auth = $conf['auth'];
        }
        if ($this->db) {
            $this->redis->select($this->db);
        }
    }


    public static function getInstance(): RedisService
    {
        if (is_null(self::$_instance) || empty(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    /*****************hash表操作函数*******************/

    /**
     * 得到hash表中一个字段的值
     * @param string $key 缓存key
     * @param string $field 字段
     * @return string|false
     */
    public function hGet(string $key, string $field)
    {
        return $this->redis->hGet($key, $field);
    }

    /**
     * 为hash表设定一个字段的值
     * @param string $key 缓存key
     * @param string $field 字段
     * @param string $value 值。
     * @return bool
     */
    public function hSet(string $key, string $field, string $value): bool
    {
        return $this->redis->hSet($key, $field, $value);
    }

    /**
     * 判断hash表中，指定field是不是存在
     * @param string $key 缓存key
     * @param string $field 字段
     * @return bool
     */
    public function hExists(string $key, string $field): bool
    {
        return $this->redis->hExists($key, $field);
    }

    /**
     * 删除hash表中指定字段 ,支持批量删除
     * @param string $key 缓存key
     * @param string $field 字段
     * @return int
     */
    public function hDel(string $key, string $field): int
    {
        $fieldArr = explode(',', $field);
        $delNum = 0;

        foreach ($fieldArr as $row) {
            $row = trim($row);
            $delNum += $this->redis->hDel($key, $row);
        }

        return $delNum;
    }

    /**
     * 返回hash表元素个数
     * @param string $key 缓存key
     * @return int|bool
     */
    public function hLen(string $key)
    {
        return $this->redis->hLen($key);
    }

    /**
     * 为hash表设定一个字段的值,如果字段存在，返回false
     * @param string $key 缓存key
     * @param string $field 字段
     * @param string $value 值。
     * @return bool
     */
    public function hSetNx(string $key, string $field, string $value): bool
    {
        return $this->redis->hSetNx($key, $field, $value);
    }

    /**
     * 为hash表多个字段设定值。
     * @param string $key
     * @param array $value
     * @return bool|Redis
     */
    public function hMset(string $key, array $value)
    {
        return $this->redis->hMset($key, $value);
    }

    /**
     * 为hash表多个字段设定值。
     * @param string $key
     * @param array|string $field string以','号分隔字段
     * @return array|Redis
     */
    public function hMget(string $key, $field)
    {
        if (!is_array($field)) {
            $field = explode(',', $field);
        }
        return $this->redis->hMget($key, $field);
    }

    /**
     * 为hash表设这累加，可以负数
     * @param string $key
     * @param int $field
     * @param string $value
     * @return bool
     */
    public function hIncrBy(string $key, int $field, string $value): bool
    {
        $value = intval($value);
        return $this->redis->hIncrBy($key, $field, $value);
    }

    /**
     * 返回所有hash表的所有字段
     * @param string $key
     * @return array
     */
    public function hKeys(string $key): array
    {
        return $this->redis->hKeys($key);
    }

    /**
     * 返回所有hash表的字段值，为一个索引数组
     * @param string $key
     * @return array
     */
    public function hVals(string $key): array
    {
        return $this->redis->hVals($key);
    }

    /**
     * 返回所有hash表的字段值，为一个关联数组
     * @param string $key
     * @return array
     */
    public function hGetAll(string $key): array
    {
        return $this->redis->hGetAll($key);
    }

    /*********************有序集合操作*********************/

    /**
     * 给当前集合添加一个元素
     * 如果value已经存在，会更新order的值。
     * @param string $key
     * @param string $order 序号
     * @param string $value 值
     * @return int|Redis
     */
    public function zAdd(string $key, string $order, string $value)
    {
        return $this->redis->zAdd($key, $order, $value);
    }

    /**
     * 给$value成员的order值，增加$num,可以为负数
     * @param string $key
     * @param string $num 序号
     * @param string $value 值
     * @return float|Redis
     */
    public function zIncrBy(string $key, string $num, string $value)
    {
        return $this->redis->zIncrBy($key, $num, $value);
    }

    /**
     * 删除值为value的元素
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function zRem(string $key, string $value): bool
    {
        return $this->redis->zRem($key, $value);
    }

    /**
     * 集合以order递增排列后，0表示第一个元素，-1表示最后一个元素
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array
     */
    public function zRange(string $key, int $start, int $end): array
    {
        return $this->redis->zRange($key, $start, $end);
    }

    /**
     * 集合以order递减排列后，0表示第一个元素，-1表示最后一个元素
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array
     */
    public function zRevRange(string $key, int $start, int $end): array
    {
        return $this->redis->zRevRange($key, $start, $end);
    }

    /**
     * 集合以order递增排列后，返回指定order之间的元素。
     * min和max可以是-inf和+inf　表示最大值，最小值
     * @param string $key
     * @param string $start
     * @param string $end
     * @param array $option
     * @return array
     * @package array $option 参数
     *     withscores=>true，表示数组下标为Order值，默认返回索引数组
     *     limit=>array(0,1) 表示从0开始，取一条记录。
     */
    public function zRangeByScore(string $key, string $start = '-inf', string $end = "+inf", array $option = array()): array
    {
        return $this->redis->zRangeByScore($key, $start, $end, $option);
    }

    /**
     * 集合以order递减排列后，返回指定order之间的元素。
     * min和max可以是-inf和+inf　表示最大值，最小值
     * @param string $key
     * @param string $start
     * @param string $end
     * @param array $option
     * @return array
     * @package array $option 参数
     *     withscores=>true，表示数组下标为Order值，默认返回索引数组
     *     limit=>array(0,1) 表示从0开始，取一条记录。
     */
    public function zRevRangeByScore(string $key, string $start = '-inf', string $end = "+inf", array $option = array()): array
    {
        return $this->redis->zRevRangeByScore($key, $start, $end, $option);
    }

    /**
     * 返回order值在start end之间的数量
     * @param string $key
     * @param string $start
     * @param string $end
     * @return int|Redis
     */
    public function zCount(string $key, string $start, string $end)
    {
        return $this->redis->zCount($key, $start, $end);
    }

    /**
     * 返回值为value的order值
     * @param string $key
     * @param string|mixed $value
     * @return bool|float|Redis
     */
    public function zScore(string $key, $value)
    {
        return $this->redis->zScore($key, $value);
    }

    /**
     * 返回集合以score递增加排序后，指定成员的排序号，从0开始。
     * @param string $key
     * @param string|mixed $value
     * @return false|int|Redis
     */
    public function zRank(string $key, $value)
    {
        return $this->redis->zRank($key, $value);
    }

    /**
     * 返回集合以score递增加排序后，指定成员的排序号，从0开始。
     * @param string $key
     * @param string|mixed $value
     * @return false|int|Redis
     */
    public function zRevRank(string $key, $value)
    {
        return $this->redis->zRevRank($key, $value);
    }

    /**
     * 删除集合中，score值在start end之间的元素　包括start end
     * min和max可以是-inf和+inf　表示最大值，最小值
     * @param string $key
     * @param string $start
     * @param string $end
     * @return int|Redis
     */
    public function zRemRangeByScore(string $key, string $start, string $end)
    {
        return $this->redis->zRemRangeByScore($key, $start, $end);
    }

    /**
     * 返回集合元素个数。
     * @param string $key
     * @return int|Redis
     */
    public function zCard(string $key)
    {
        return $this->redis->zCard($key);
    }
    /*********************队列操作命令************************/

    /**
     * 在队列尾部插入一个元素
     * @param string $key
     * @param string $value
     * 返回队列长度
     * @return false|int|Redis
     */
    public function rPush(string $key, string $value)
    {
        return $this->redis->rPush($key, $value);
    }

    /**
     * 在队列尾部插入一个元素 如果key不存在，什么也不做
     * @param string $key
     * @param string $value
     * 返回队列长度
     * @return false|int|Redis
     */
    public function rPushx(string $key, string $value)
    {
        return $this->redis->rPushx($key, $value);
    }

    /**
     * 在队列头部插入一个元素
     * @param string $key
     * @param string $value
     * 返回队列长度
     * @return false|int|Redis
     */
    public function lPush(string $key, string $value)
    {
        return $this->redis->lPush($key, $value);
    }

    /**
     * 在队列头插入一个元素 如果key不存在，什么也不做
     * @param string $key
     * @param string $value
     * 返回队列长度
     * @return false|int|Redis
     */
    public function lPushx(string $key, string $value)
    {
        return $this->redis->lPushx($key, $value);
    }

    /**
     * 返回队列长度
     * @param string $key
     * @return bool|int|Redis
     */
    public function lLen(string $key)
    {
        return $this->redis->lLen($key);
    }

    /**
     * 返回队列指定区间的元素
     * @param string $key
     * @param int $start
     * @param int $end
     * @return array|Redis
     */
    public function lRange(string $key, int $start, int $end)
    {
        return $this->redis->lrange($key, $start, $end);
    }

    /**
     * 返回队列中指定索引的元素
     * @param string $key
     * @param int $index
     * @return bool|mixed|Redis
     */
    public function lIndex(string $key, int $index)
    {
        return $this->redis->lIndex($key, $index);
    }

    /**
     * 设定队列中指定index的值。
     * @param string $key
     * @param int $index
     * @param string $value
     * @return bool|Redis
     */
    public function lSet(string $key, int $index, string $value)
    {
        return $this->redis->lSet($key, $index, $value);
    }

    /**
     * 删除值为vaule的count个元素
     * PHP-REDIS扩展的数据顺序与命令的顺序不太一样，不知道是不是bug
     * count>0 从尾部开始
     *  >0　从头部开始
     *  =0　删除全部
     * @param string $key
     * @param string $count
     * @param int $value
     * @return bool|int|Redis
     */
    public function lRem(string $key, string $count, int $value)
    {
        return $this->redis->lRem($key, $value, $count);
    }

    /**
     * 删除并返回队列中的头元素。
     * @param string $key
     * @return bool|mixed|Redis
     */
    public function lPop(string $key)
    {
        return $this->redis->lPop($key);
    }

    /**
     * 删除并返回队列中的尾元素
     * @param string $key
     * @return bool|mixed|Redis
     */
    public function rPop(string $key)
    {
        return $this->redis->rPop($key);
    }

    /*************redis字符串操作命令*****************/

    /**
     * 设置一个key
     * @param string $key
     * @param string $value
     * @param int|null $timeout
     * @return bool|Redis
     */
    public function set(string $key, string $value, int $timeout = null)
    {
        return $this->redis->set($key, $value, $timeout);
    }

    /**
     * 得到一个key
     * @param string $key
     * @return string
     */
    public function get(string $key): ?string
    {
        return $this->redis->get($key);
    }

    /**
     * 设置一个有过期时间的key
     * @param string $key
     * @param int $expire
     * @param string|mixed $value
     * @return bool|Redis
     */
    public function setex(string $key, int $expire, $value)
    {
        return $this->redis->setex($key, $expire, $value);
    }


    /**
     * 设置一个key,如果key存在,不做任何操作.
     * @param string $key
     * @param mixed $value
     * @return array|bool|Redis
     */
    public function setnx(string $key, $value)
    {
        return $this->redis->setnx($key, $value);
    }

    /**
     * 批量设置key
     * @param array $arr
     * @return bool|Redis
     */
    public function mset(array $arr)
    {
        return $this->redis->mset($arr);
    }

    /*************redis　无序集合操作命令*****************/

    /**
     * 返回集合中所有元素
     * @param string $key
     * @return array|Redis
     */
    public function sMembers(string $key)
    {
        return $this->redis->sMembers($key);
    }

    /**
     * 求2个集合的差集
     * @param string $key1
     * @param string $key2
     * @return array|Redis
     */
    public function sDiff(string $key1, string $key2)
    {
        return $this->redis->sDiff($key1, $key2);
    }

    /**
     * 添加集合。由于版本问题，扩展不支持批量添加。这里做了封装
     * @param string $key
     * @param string|array $value
     */
    public function sAdd(string $key, $value)
    {
        if (!is_array($value))
            $arr = array($value);
        else
            $arr = $value;
        foreach ($arr as $row)
            $this->redis->sAdd($key, $row);
    }

    /**
     * 返回无序集合的元素个数
     * @param string $key
     * @return int|Redis
     */
    public function scard(string $key)
    {
        return $this->redis->scard($key);
    }

    /**
     * 从集合中删除一个元素
     * @param string $key
     * @param string|mixed $value
     * @return int|Redis
     */
    public function srem(string $key, $value)
    {
        return $this->redis->srem($key, $value);
    }

    public function auth($auth)
    {
        return $this->redis->auth($auth);
    }

    public function getConnInfo(): array
    {
        return [
            'host' => $this->host,
            'port' => $this->port,
            'auth' => $this->auth,
        ];
    }

    private function __clone()
    {
    }
}
