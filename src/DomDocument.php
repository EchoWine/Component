<?php

namespace CoreWine\Component;

use DomXPath;

/**
 * A helper class for strings
 */
class DomDocument extends \DomDocument{

	public function __construct($html){
		parent::__construct();
		$this -> loadHTML($html);
	}

	public function loadHtml($source,$options = NULL){

		$e = libxml_use_internal_errors(true);
		parent::loadHTML($source,$options);
		libxml_use_internal_errors($e);
	}

	public function getElementsByAttribute($attribute,$value){
		$finder = new DomXPath($this);
		return $finder -> query("//*[@$attribute='$value']");
	}

}

?>