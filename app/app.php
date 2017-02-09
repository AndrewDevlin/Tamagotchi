<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/tamagotchi.php";
    // require_once __DIR__."/../css/styles.css";


    session_start();

    if (empty($_SESSION['tama'])) {
      $_SESSION['tama'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        if(!empty($_SESSION['tama'])){
            if ($_SESSION['tama'][0]->getPlay() <= 0 || $_SESSION['tama'][0]->getSleep() <= 0 || $_SESSION['tama'][0]->getFood() <= 0) {
                return $app['twig']->render("Dead.html.twig");
            } else {
                $play = $_SESSION['tama'][0]->getPlay();
                $sleep = $_SESSION['tama'][0]->getSleep();
                $food = $_SESSION['tama'][0]->getFood();
                $level = (($play + $sleep + $food)/300)*100;
                if($level<=20 || $play <= 20 || $sleep <= 20 || $food <= 20){
                  $health = "http://data.whicdn.com/images/34312692/large.gif";
                }else if ($level<=40 || $play <= 40 || $sleep <= 40 || $food <= 40){
                  $health = "http://static.fjcdn.com/gifs/Lucario+bein+a+thug+pokemon+for+kids+they+say_7b1c90_5183486.gif";
                }else if($level<=60 || $play <= 60 || $sleep <= 60 || $food <= 60){
                  $health="https://media.giphy.com/media/ghUeyOoEx3uPS/giphy.gif";
                }else if($level<=80 || $play <= 80 || $sleep <= 80 || $food <= 80){
                  $health="https://media.giphy.com/media/12Bpme5pTzGmg8/giphy.gif";
                }else{
                  $health="https://media.giphy.com/media/NDO26aNYH0bXq/giphy.gif";
                }
                return $app['twig']->render('homeView.html.twig', array('tama' => Tama::getAll(), 'health'=>$health));
            }
        }else {
          return $app['twig']->render('homeView.html.twig', array('tama' => Tama::getAll()));
        }
    });

    $app->post("/new", function() use ($app) {
        $tama = new Tama($_POST['name'], 100, 100, 100);
        $tama->save();
        return $app->redirect('/');

    });

    $app->post("/feed", function() use ($app) {
      Tama::eatWith();
      return $app->redirect('/');
    });

    $app->post("/play", function() use ($app) {
        Tama::playWith();
        return $app->redirect('/');
    });

    $app->post("/sleep", function() use ($app) {
      Tama::sleepWith();
      return $app->redirect('/');
    });

    $app->post("/dead", function() use ($app) {
      return $app['twig']->render("Dead.html.twig");
    });

    $app->post("/delete", function() use ($app) {
        Tama::deleteAll();
        return $app['twig']->render('homeView.html.twig');
    });

    return $app;
?>
