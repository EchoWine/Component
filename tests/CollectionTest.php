<?php

use PHPUnit\Framework\TestCase;

use CoreWine\Component\Collection;

class CollectionTest extends TestCase{
    
    public function testBasic(){

        $c = new Collection();
        $c[] = 5;
        $c[] = 3;

        $this -> assertEquals($c -> count(),2);

        foreach($c as $n => $k){
            $this -> assertEquals($c[$n],$k);
        }

        $c[0] = new Collection();
        $c[0][1][2] = "Yolo";


        $this -> assertEquals($c[0][1][2],"Yolo");


    }

}