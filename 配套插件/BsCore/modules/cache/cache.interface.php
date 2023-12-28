<?php
interface BsCache
{
	public function init($option);
	public function add($key, $value);
	public function delete($key);
	public function set($key, $value);
	public function get($key);
	public function flush();
}
