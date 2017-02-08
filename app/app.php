<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/tamagotchi.php";

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
                return $app['twig']->render('homeView.html.twig', array('tama' => Tama::getAll()));
            }
        }else {
          return $app['twig']->render('homeView.html.twig', array('tama' => Tama::getAll()));
        }
    });

    $app->post("/new", function() use ($app) {
        $tama = new Tama($_POST['name'], 30, 30, 30, false);
        $tama->save();
        return $app['twig']->render('New.html.twig', array('newTama' => $tama));
    });

    $app->post("/feed", function() use ($app) {
      Tama::eatWith();
      return $app['twig']->render('Feed.html.twig');
    });

    $app->post("/play", function() use ($app) {
        Tama::playWith();
        return $app['twig']->render('Play.html.twig');
    });

    $app->post("/sleep", function() use ($app) {
      Tama::sleepWith();
      return $app['twig']->render('Sleep.html.twig');
    });

    $app->post("/dead", function() use ($app) {

    });

    $app->post("/delete", function() use ($app) {
        Tama::deleteAll();
        return $app['twig']->render('homeView.html.twig');
    });

    return $app;
?>
