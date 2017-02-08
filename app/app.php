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
                return $app['twig']->render('homeView.html.twig', array('tama' => Tama::getAll()));
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
