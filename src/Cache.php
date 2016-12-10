<?php

namespace CoreWine\Component;

class Cache{

	/**
	 * Dir where cache is saved
	 *
	 * @var string
	 */
	public static $dir = __DIR__;

	/**
	 * Set dir
	 *
	 * @param string $dir
	 */
	public static function setDir($dir){
		self::$dir = $dir;
	}

	/**
	 * Get dir
	 *
	 * @return String
	 */
	public static function getDir(){
		return self::$dir;
	}

	/**
	 * Get filename complete
	 *
	 * @param string $name
	 *
	 * @return String
	 */
	public static function getFileExpiring(){
		return self::getDir()."/"."cache.index";
	}

	/**
	 * Get filename complete
	 *
	 * @param string $name
	 *
	 * @return String
	 */
	public static function getFile($name){
		$name = Str::filename($name);

		if(!file_exists(self::getDir())){
			mkdir(self::getDir(),0755,true);
		}
		
		return self::getDir()."/"."cache-".$name.".cache";
	}

	/**
	 * Update index expire
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public static function setExpiring($name,$time){

		$file = self::getFileExpiring();

		if(!file_exists($file)){
			$content = [];
		}else{
			$content = json_decode(file_get_contents($file),true);
		}

		if($time == -1){
			if(isset($content[$name]))
				unset($content[$name]);
		}else{
			$content[$name] = time() + $time;
		}

		file_put_contents($file,json_encode($content));
	}


	/**
	 * Update index expire
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public static function getExpiring($name){

		$file = self::getFileExpiring();

		if(!file_exists($file)){
			$content = [];
		}else{
			$content = json_decode(file_get_contents($file),true);
		}

		if(isset($content[$name]))
			return $content[$name];

		return 0;
	}

	/**
	 * Set cache
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public static function set($name,$value,$expire = 31536000){

		


		file_put_contents(self::getFile($name),serialize($value));
		self::setExpiring($name,$expire);
	}

	/**
	 * Get cache
	 *
	 * @param string $name
	 * 
	 * @return mixed
	 */
	public static function get($name){
		if(!file_exists(self::getFile($name)))
			return null;

		if(self::expired($name))
			return null;

		$content = unserialize(file_get_contents(self::getFile($name)));
		
		return $content;
	}

	/**
	 * is a cache valid
	 *
	 * @param string $name
	 * 
	 * @return mixed
	 */
	public static function valid($name){
		if(!file_exists(self::getFile($name)))
			return false;

		if(self::expired($name,false))
			return false;

		return true;
	}

	/**
	 * Check if expired
	 * 
	 * @param $name
	 * @param $delete
	 *
	 * @return bool
	 */
	public static function expired($name,$delete = true){
		$file = self::getFile($name);
		if(time() > self::getExpiring($name)){

			if($delete)
				self::clear($name);
			
			return true;
		}

		return false;

	}

	/**
	 * Clear cache
	 *
	 * @param string $name
	 */
	public static function clear($name){
		if(file_exists(self::getFile($name)))
			return unlink(self::getFile($name));

		self::setExpiring($name,-1);
	}

}