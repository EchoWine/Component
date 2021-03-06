<?php

namespace CoreWine\Component;

class Cfg{

	public static $resource = [];

	public static function set($name,$value){
		static::$resource[$name] = $value;
	}

	public static function get($name,$default = null){
		return isset(static::$resource[$name]) ? static::$resource[$name] : $default;
	}

	public static function all(){
		return static::$resource;
	}

	public static function add($name,$values){
		
		if(is_array($values)){
			foreach($values as $n => $value){
				self::add($name.".".$n,$value);
			}
		}else{
			self::set($name,$values);
		}
	}
}
?>