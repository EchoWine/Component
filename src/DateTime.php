<?php

namespace CoreWine\Component;

class DateTime extends \DateTime{

    /**
     * Construct
     *
     * @param mixed $datetime
     * @param DateTimeZone $timezone
     */
    public function __construct($datetime = null,$timezone = null){
        if($timezone == null){
             new \DateTimeZone('Europe/Rome');
        }
        parent::__construct($datetime,$timezone);
    }

    public static function createFromFormat($format,$value,$object = null){
        $datetime = parent::createFromFormat($format,$value,$object);
        return new static($datetime -> format('Y-m-d H:i:s'));
    }


    /**
     * Return a clone
     *
     * @return self
     */
    public function getClone(){
        return clone $this;
    }

    /**
     * Get week
     *
     * @return string
     */
    public function getWeek(){
        return $this -> format('W');
    }

    /**
     * Get day of week
     *
     * @return string
     */
    public function getDayOfWeek(){
        return $this -> format('N');
    }

    /**
     * Get month
     *
     * @return string
     */
    public function getMonth(){
        return $this -> format('m');
    }
    
    /**
     * Get day
     *
     * @return string
     */
    public function getDay(){
        return $this -> format('d');
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear(){
        return $this -> format('Y');
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getLastDayOfMonth(){
        return $this -> format('t');
    }

    /**
     * Prev month
     *
     * @return self
     */
    public function prevMonth($month = 1){
        return $this -> getClone() -> modify("-{$month} month");
    }

    /**
     * Modify month
     *
     * @return self
     */
    public function modifyMonth($month = 1){
        return $this -> getClone() -> modify("+{$month} month");
    }

    /**
     * Next month
     *
     * @return self
     */
    public function nextMonth($month = 1){
        return $this -> getClone() -> modify("+{$month} month");
    }

    /**
     * Next day
     *
     * @return self
     */
    public function nextDay(){
        return $this -> nextDays(1);
    }

    /**
     * Prev day
     *
     * @return self
     */
    public function prevDay(){
        return $this -> prevDays(1);
    }

    /**
     * Modify day
     *
     * @return self
     */
    public function modifyDay($days = 1){
        return $this -> getClone() -> modify("+{$days} days");
    }

    /**
     * Next days
     *
     * @return self
     */
    public function nextDays($days = 1){
        return $this -> getClone() -> modify("+{$days} days");
    }

    /**
     * Prev days
     *
     * @return self
     */
    public function prevDays($days = 1){
        return $this -> getClone() -> modify("-{$days} days");
    }

    /**
     * Create an instance given a date
     *
     * @param string $day
     * @param string $month
     * @param string $year
     * 
     * @return self
     */
    public static function createByDate($day,$month,$year){
        return new self($year."-".$month."-".$day." 00:00:00");
    }

    /**
     * Create an instance given month and year
     *
     * @param string $month
     * @param string $year
     * 
     * @return self
     */
    public static function createByMonthAndYear($month,$year){
        return new self($year."-".$month."-01 00:00:00");
    }

    /**
     * Retrieve datetime starting month
     * 
     * @return self
     */
    public function startMonth(){
        return self::createByMonthAndYear($this -> format('m'),$this -> format('Y'));
    }

    /**
     * Retrieve datetime ending month
     *
     * @return string
     */
    public function endMonth(){
        return self::createByDate($this -> format('t'),$this -> format('m'),$this -> format('Y'));
    }


    /**
     * Retrieve a collection of days as index of current month
     *
     * @param bool $weeks
     *
     * @return Collection
     */
    public function createCollectionMonth($weeks = false){
        
        $date = $this -> startMonth();

        $collection = new Collection();

        $days = [];

        if($weeks){

            for($i = $date -> getDayOfWeek() - 1; $i > 0; $i--){
                $days[] = $date -> getClone() -> prevDays($i);
            }
        }

        for($i = 0; $i <= $date -> getLastDayOfMonth();$i++){

            $days[] = $date -> getClone() -> modifyDay($i);
        }

        if($weeks){
            $date = $date -> endMonth();
            for($i = $date -> getDayOfWeek(); $i < 7; $i++){
                $days[] = $date -> getClone() -> nextDays($i);
            } 
        }

        foreach($days as $day){
            if($weeks){
                $collection[$day -> getWeek()][$day -> format('Y-m-d')]['datetime'] = $day;
                $collection[$day -> getWeek()][$day -> format('Y-m-d')]['data'] = new Collection();
            }else{
                $collection[$day -> format('Y-m-d')]['datetime'] = $day;
                $collection[$day -> format('Y-m-d')]['data'] = new Collection();
            }
        }

        return $collection;

    }
}