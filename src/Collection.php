<?php

namespace CoreWine\Component;

use Countable;
use ArrayAccess;
use Iterator;
use JsonSerializable;

class Collection implements ArrayAccess, Countable, Iterator, JsonSerializable{

    /**
     * The items contained in the collection
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new collection
     *
     * @param  mixed  $items
     */
    public function __construct($items = []){
        
        $this -> fill($items);
    }

    /**
     * Set
     *
     * @param mixed $index
     * @param mixed $value
     */
    public function offsetSet($index, $value) {
        if(is_null($index)){
            $this -> items[] = $value;
        }else{
            $this -> items[$index] = $value;
        }
    }

    /**
     * Get
     *
     * @param mixed $index
     * @param mixed $value
     */
    public function &offsetGet($index) {
        return $this -> items[$index];
    }

    /**
     * Unset
     *
     * @param mixed $index
     * @param mixed $value
     */
    public function offsetUnset($index){
        unset($this -> items[$index]);
    }

    /**
     * Exists
     *
     * @param mixed $index
     * @param mixed $value
     */
    public function offsetExists($index){
        return isset($this -> items[$index]);
    }

    /**
     * Rewind
     */
    public function rewind(){
        reset($this -> items);
    }
  
    /**
     * Current
     */
    public function current(){
        return current($this -> items);
    }

    /**
     * Key
     */
    public function key() {
        return key($this -> items);
    }
  
    /**
     * Next
     */
    public function next() {
        return next($this -> items);
    }
  
    /**
     * Valid
     */
    public function valid(){
        $key = key($this -> items);
        return ($key !== NULL && $key !== FALSE);
    }

    /**
     * Return a count of all elements
     * 
     * @return int
     */
    public function count(){
        return count($this -> items);
    }

    /**
     * to json
     *
     * @return array
     */
    public function jsonSerialize(){
        return $this -> toArray();
    }


    /**
     * Fill the collection
     *
     * @param array/Collection $items
     */
    public function fill($items){
        
        $this -> items = [];

        foreach($items as $n => $k){
            $this -> items[$n] = $k;
        }
    }

    /**
     * Has the collection the value
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function has($value){
        return in_array($value,$this -> items);
    }

    /**
     * Has the collection the index
     *
     * @param mixed $name
     * @param mixed $value
     */
    public function exists($index){
        return $this -> offsetExists($index);
    }

    /**
     * Add an attribute to all elements in items
     *
     * @param mixed $name
     * @param mixed $value
     */
    public function addParam($name,$value){

    	$v = $this -> items;
    	foreach($v as $n => $k){
    		if(is_object($k)){
    			$k -> {$name} = $value;
    		}else{
    			$this -> items[$n][$name] = $value; 
    		}
    	}
        
    }

    /**
     * Merge two array/collection
     *
     * @param mixed $array
     */
    public function merge($array){
        if($array instanceof self){
            $array = $array -> items();
        }

    	return new Collection(array_merge($this -> items,$array));
    }

    /**
     * Retrieve items
     *
     * @return Array
     */
    public function items(){
        return $this -> items;
    }

    /**
     * Retrieve all elements
     *
     * @return Array
     */
    public function all(){
        return $this -> items;
    }

    /**
     * Retrieve all elements as array
     *
     * @return Array
     */
    public function toArray(){
        return $this -> items;
    }

    /**
     * Sort the elements by a value, type and direction
     *
     * @param mixed $value
     * @param string $type
     * @param string $direction
     *
     * @return Collection
     */
    public function sortBy($value,$type = 'string',$direction = 'ASC'){

        $array = $this -> items;
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
    
    public function map($closure){
        return new Collection(array_map($closure,$this -> items));
    }


    /**
     * Retrieve index
     *
     * @param mixed $value
     *
     * @return int
     */
    public function index($value){

        foreach($this -> items as $n => $k){
            if(is_object($value) && is_callable([$value,'equalTo'])){
                if($value -> equalTo($k)){
                    return $n;
                }
            }else{

                if($value == $k){
                    return $n;
                }
            }
        }

        return false;
    }

    /**
     * Remove a value from the collection
     *
     * @param mixed $value
     */
    public function remove($value){
        $index = $this -> index($value);

        if($index !== false)
            $this -> unset($index);
    }


    /**
     * Remove a value using index
     *
     * @param mixed $index
     */
    public function unset($index){
        $this -> offsetUnset($index);
    }

    /**
     * Convert to string the collection
     *
     * @return string
     */
    public function __toString(){
        return json_encode($this -> toArray());
    }
}