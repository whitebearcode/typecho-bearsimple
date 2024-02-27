<?php
class typecho_flysystem implements BsCache
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
		return !is_null(self::$_instance->flysystem) ? self::$_instance : null;
	}

	public function init($option)
	{
		try {
		    $adapter = new \League\Flysystem\Local\LocalFilesystemAdapter('usr/plugins/BsCore/cache', null, LOCK_EX);
           $filesystem = new \League\Flysystem\Filesystem($adapter);
          $this->flysystem = new \MatthiasMullie\Scrapbook\Adapters\Flysystem($filesystem);
		} catch (Exception $e){
			$this->flysystem = null;
			echo $e->getMessage();
		}
	}

	public function add($key, $value)
	{
		return $this->flysystem->set($key, $value, $this->expire);
	}

	public function delete($key)
	{
		return $this->flysystem->delete($key);
	}

	public function set($key, $value)
	{
		return $this->flysystem->set($key, $value, $this->expire);
	}

	public function get($key)
	{
		return $this->flysystem->get($key);
	}

	public function flush()
	{
		return $this->flysystem->flush();
	}
}
