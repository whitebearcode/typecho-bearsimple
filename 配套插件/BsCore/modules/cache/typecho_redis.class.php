<?php
use Redis;
class typecho_redis implements BsCache
{
	private static $_instance = null;
	private $redis = null;
	private $host = '127.0.0.1';
	private $port = 6379;
	private $expire = 86400;

	private function __construct($option = null)
	{
		$this->host = $option->host;
		$this->port = $option->port;
		$this->expire = $option->expire;
		$this->init($option);
	}

	static public function getInstance($option)
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new self($option);
		}
		return !is_null(self::$_instance->redis) ? self::$_instance : null;
	}
 
	public function init($option)
	{
		try {
			$this->redisc = new Redis();
			$this->redisc->connect($this->host, $this->port);
            $this->redis = new \MatthiasMullie\Scrapbook\Adapters\Redis($this->redisc);
            $this->redis = new \MatthiasMullie\Scrapbook\Scale\StampedeProtector($this->redis);
		} catch (Exception $e){
			$this->redis = null;
			echo $e->getMessage();
		}
	}

	public function add($key, $value)
	{
		return $this->redis->set($key, $value, $this->expire);
	}

	public function delete($key)
	{
		return $this->redis->del($key);
	}

	public function set($key, $value)
	{
		return $this->redis->set($key, $value,$this->expire);
	}

	public function get($key)
	{
		return $this->redis->get($key);
	}

	public function flush()
	{
		return $this->redis->flush();
	}
}
