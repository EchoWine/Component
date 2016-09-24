<?php

namespace CoreWine\Component;

/**
 * A helper class for debugging.
 */
class Debug{

	public static $data = [];

	/**
	 * Add to stack.
	 *
	 * @param DataType $data
	 */
	public static function add($data){
		self::$data[] = $data;
	}

	/**
	 * Print the stack.
	 */
	public static function print(){
		print_r(self::$data);
	}
	/**
	 * Print the stack.
	 */
	public static function get(){
		return self::$data;
	}
}

?>