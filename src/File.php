<?php

namespace CoreWine\Component;

class File{

	public static function set($filename,$content){
		return file_put_contents($filename,$content);
	}

	public static function get($filename){
		return file_get_contents($filename);
	}

	public static function exists($filename){
		return file_exists($filename);
	}

	public static function remove($filename){
		unlink($filename);
	}

}