<?php

namespace CoreWine\Component;

/**
 * A helper class for strings
 */
class Str{

	/**
	 * Convert string json to object
	 *
	 * @param string $str
	 * @param bool $array
	 * 
	 * @return object
	 */
	public static function json($str,$array = true){
		return json_decode($str,$array);
	}

	/**
	 * Convert given string to xml object
	 *
	 * @param string $str
	 *
	 * @return object
	 */
	public static function xml($str){
		libxml_use_internal_errors(true);
		try{
			return json_decode(json_encode((array)simplexml_load_string($str)));
		}catch(\Exception $e){
			return null;
		}
	}

	/**
	 * Sanatize string in order to save as filename
	 *
	 * @param string $str
	 *
	 * @return string 
	 */
	public static function filename($str){
		$str = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $str);
		$str = mb_ereg_replace("([\.]{2,})", '', $str);
		return $str;
	}
}

?>