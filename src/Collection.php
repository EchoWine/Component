<?php

namespace CoreWine\Component;

use Iterator;
use ArrayAccess;
use Countable;

class Collection extends \ArrayObject{


    public function has($value){
        return in_array($value,$this -> container);
    }
    
}