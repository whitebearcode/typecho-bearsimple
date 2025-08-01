<?php
class typecho_apcu implements BsCache
{
	private static $_instance = null;
	private $apcu = null;
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
		return !is_null(self::$_instance->apcu) ? self::$_instance : null;
	}

	public function init($option)
	{
		try {
			$this->apcuc = new \MatthiasMullie\Scrapbook\Adapters\Apc();
            $this->apcu = new \MatthiasMullie\Scrapbook\Scale\StampedeProtector($this->apcuc);
		} catch (Exception $e){
			$this->apcu = null;
			echo $m->getResultCode().$e->getMessage();
		}
	}

	public function add($key, $value)
	{
		return $this->apcu->set($key, $value, $this->expire);
	}

	public function delete($key)
	{
		return $this->apcu->delete($key);
	}

	public function set($key, $value)
	{
		return $this->apcu->set($key, $value, $this->expire);
	}

	public function get($key)
	{
		return $this->apcu->get($key);
	}

	public function flush()
	{
		return $this->apcu->flush();
	}
}
