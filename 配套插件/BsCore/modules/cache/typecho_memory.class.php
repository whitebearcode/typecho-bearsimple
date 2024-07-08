<?php
class typecho_memory implements BsCache
{
	private static $_instance = null;
	private $memory = null;
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
		return !is_null(self::$_instance->memory) ? self::$_instance : null;
	}

	public function init($option)
	{
		try {
			$this->memoryc = new \MatthiasMullie\Scrapbook\Adapters\MemoryStore();
            $this->memory = new \MatthiasMullie\Scrapbook\Scale\StampedeProtector($this->memoryc);
		} catch (Exception $e){
			$this->memory = null;
			echo $m->getResultCode().$e->getMessage();
		}
	}

	public function add($key, $value)
	{
		return $this->memory->set($key, $value, $this->expire);
	}

	public function delete($key)
	{
		return $this->memory->delete($key);
	}

	public function set($key, $value)
	{
		return $this->memory->set($key, $value, $this->expire);
	}

	public function get($key)
	{
		return $this->memory->get($key);
	}

	public function flush()
	{
		return $this->memory->flush();
	}
}
