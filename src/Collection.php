<?php

namespace CoreWine\Component;

use Iterator;
use ArrayAccess;
use Countable;

class Collection extends \ArrayObject{

    public function has($value){
        return in_array($value,$this -> container);
    }

    public function addParam($name,$value){

    	$v = $this;
    	foreach($v as $n => $k){
    		if(is_object($k)){
    			$k -> {$name} = $value;
    		}else{
    			$v[$n][$name] = $value; 
    		}
    	}
    }

    public function merge($array){
    	return new Collection(array_merge((array)$this,(array)$array));
    }

    public function toArray(){
        $array = [];
        foreach($this as $n => $k){
            $array[$n] = $k;
        }
        return $array;
    }

    public function sortBy($value,$type = 'string',$direction = 'ASC'){
        $array = (array)$this;

        usort($array,function($a,$b) use($value,$type,$direction){

            $a = $a -> {$value};
            $b = $b -> {$value};

            switch($type){
                case 'string':
                    return $direction == 'ASC' ? strcmp($a,$b) : strcmp($b,$a);
                break;
                case 'number':
                    return $direction == 'ASC' ? $a > $b : $b > $a;
                break;
            }
        });

        return new Collection($array);
    }
    
}