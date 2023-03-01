<?php
use Memcached;
class typecho_memcached implements BsCache
{
	private static $_instance = null;
	private $mc = null;
	private $host = '127.0.0.1';
	private $port = 11211;
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
		return !is_null(self::$_instance->mc) ? self::$_instance : null;
	}

	public function init($option)
	{
		try {
			$this->mc = new Memcached;
			$this->mc->addServer($this->host, $this->port);
		} catch (Exception $e){
			$this->mc = null;
			echo $m->getResultCode().$e->getMessage();
		}
	}

	public function add($key, $value)
	{
		return $this->mc->set($key, $value, $this->expire);
	}

	public function delete($key)
	{
		return $this->mc->delete($key);
	}

	public function set($key, $value)
	{
		return $this->mc->set($key, $value, $this->expire);
	}

	public function get($key)
	{
		return $this->mc->get($key);
	}

	public function flush()
	{
		return $this->mc->flush();
	}
}
