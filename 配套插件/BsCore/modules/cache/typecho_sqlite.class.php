<?php
class typecho_sqlite implements BsCache
{
	private static $_instance = null;
	private $sqlite = null;
	private $expire = 86400;

	private function __construct($option = null)
	{
		$this->expire = $option->expire;
		$this->init($option);
	}

	static public function getInstance($option)
	{
		if (!isset(self::$_instance)) {
			self::$_instance = new self($option);
		}
		return !is_null(self::$_instance->sqlite) ? self::$_instance : null;
	}

	public function init($option)
	{
		try {
			$this->sqlitec = new \PDO('sqlite:usr/plugins/BsCore/cache/bscache.db');
            $this->sqlite = new \MatthiasMullie\Scrapbook\Adapters\SQLite($this->sqlitec);
            $this->sqlite = new \MatthiasMullie\Scrapbook\Scale\StampedeProtector($this->sqlite);
		} catch (Exception $e){
			$this->sqlite = null;
			echo $e->getMessage();
		}
	}

	public function add($key, $value)
	{
		return $this->sqlite->set($key, $value, $this->expire);
	}

	public function delete($key)
	{
		return $this->sqlite->delete($key);
	}

	public function set($key, $value)
	{
		return $this->sqlite->set($key, $value, $this->expire);
	}

	public function get($key)
	{
		return $this->sqlite->get($key);
	}

	public function flush()
	{
		return $this->sqlite->flush();
	}
}
