<?php
    class Tama {

        private $name;
        private $food;
        private $sleep;
        private $play;
        private $dead;

        function __construct($name, $food, $sleep, $play, $dead){
            $this->name = $name;
            $this->food = $food;
            $this->sleep = $sleep;
            $this->play = $play;
            $this->dead = $dead;
        }

        function getName(){
            return $this->$name;
        }

        function setName($name){
            $this->name = $name;
        }

        function getFood(){
          return $this->$food;
        }

        function setFood($food){
            $this->food = $food;
        }

        function getSleep(){
            return $this->$sleep;
        }

        function setSleep($sleep){
            $this->sleep = $sleep;
        }

        function getPlay(){
            return $this->$play;
        }

        function setPlay($play){
            $this->play = $play;
        }

        function getDead(){
            return $this->$dead;
        }

        function setDead($dead){
            $this->dead = $dead;
        }

        function save(){
            array_push($_SESSION['tama'], $this);
        }

        static function playWith(){
          $play= $this->getPlay();
          $food= $this->getFood();
          $sleep= $this->getSleep();
          $play .= 1;
          $food = $food - 3;
          $sleep = $sleep - 3;

          $tama = array("play"=>$play,"food"=>$food,"sleep"=>$sleep);

          return array_push($_SESSION['tama'],$tama);
        }

        static function getAll()
        {
            return $_SESSION['tama'];
        }
    }

 ?>
