<?php
/**
 * Json
 * https://www.bearnotion.org/
 */

use Typecho\Db;
require_once 'functions/options.php';

if (!class_exists('bsOptions')) {
    class bsOptions {

        private static $instance = null;

        public function __construct()
        {

        }

        public static function getInstance(): bsOptions
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public static function get_option($option, $default = false)
        {
            return get_option($option, $default);
        }

        public static function update_option($option, $value, $autoload = null): void
        {
            update_option($option, $value, $autoload);
        }
public static function getValue($array, $key, $default = null)
        {
            if (is_array($key)) {
                $lastKey = array_pop($key);
                foreach ($key as $keyPart) {
                    $array = self::getValue($array, $keyPart);
                }
                $key = $lastKey;
            }
            if (is_array($array) && array_key_exists($key, $array)) {
                return $array[$key];
            }
            if (($pos = strrpos($key, '.')) !== false) {
                $array = self::getValue($array, substr($key, 0, $pos), $default);
                $key = substr($key, $pos + 1);
            }
            if (is_object($array)) {
                return $array->$key;
            } elseif (is_array($array)) {
                return array_key_exists($key, $array) ? $array[$key] : $default;
            } else {
                return $default;
            }
        }
    }
}