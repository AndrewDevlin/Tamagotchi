<?php
    class Tama {

        private $name;
        private $food;
        private $sleep;
        private $play;

        function __construct($name, $food, $sleep, $play, $dead){
            $this->name = $name;
            $this->food = $food;
            $this->sleep = $sleep;
            $this->play = $play;
        }

        function getName(){
            return $this->name;
        }

        function setName($name){
            $this->name = (string) $name;
        }

        function getFood(){
          return $this->food;
        }

        function setFood($food){
            $this->food = $food;
        }

        function getSleep(){
            return $this->sleep;
        }

        function setSleep($sleep){
            $this->sleep = $sleep;
        }

        function getPlay(){
            return $this->play;
        }

        function setPlay($play){
            $this->play = $play;
        }

        function save(){
            $_SESSION['tama']= array($this);
        }

        static function playWith(){
          $play= $_SESSION['tama'][0]->getPlay();
          $food= $_SESSION['tama'][0]->getFood();
          $sleep= $_SESSION['tama'][0]->getSleep();
          $play = $play + 1;
          $food = $food - 2;
          $sleep = $sleep - 2;
          $_SESSION['tama'][0]->setFood($food);
          $_SESSION['tama'][0]->setPlay($play);
          $_SESSION['tama'][0]->setSleep($sleep);

          return $_SESSION['tama'];
        }

        static function sleepWith(){
          $play= $_SESSION['tama'][0]->getPlay();
          $food= $_SESSION['tama'][0]->getFood();
          $sleep= $_SESSION['tama'][0]->getSleep();
          $play = $play - 2;
          $food = $food - 2;
          $sleep = $sleep + 1;
          $_SESSION['tama'][0]->setFood($food);
          $_SESSION['tama'][0]->setPlay($play);
          $_SESSION['tama'][0]->setSleep($sleep);

          return $_SESSION['tama'];
        }

        static function eatWith(){
          $play= $_SESSION['tama'][0]->getPlay();
          $food= $_SESSION['tama'][0]->getFood();
          $sleep= $_SESSION['tama'][0]->getSleep();
          $play = $play - 2;
          $food = $food + 1;
          $sleep = $sleep - 2;
          $_SESSION['tama'][0]->setFood($food);
          $_SESSION['tama'][0]->setPlay($play);
          $_SESSION['tama'][0]->setSleep($sleep);

          return $_SESSION['tama'];
        }

        static function getAll()
        {
            return $_SESSION['tama'];
        }

        static function deleteAll()
        {
            $_SESSION['tama'] = array();
        }
    }

 ?>
