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

        return $app['twig']->render('homeView.html.twig', array('places' => Tama::getAll()));
    });

    $app->post("/new", function() use ($app) {
        $tama = new Tama($_POST['name'], 10, 10, 10, false);
        $tama->save();
        return $app['twig']->render('new.html.twig', array('newTama' => $tama);
    });

    $app->post("/feed", function() use ($app) {

    });

    $app->post("/play", function() use ($app) {
        Tama::playWith();
        return $app['twig']->render('Play.html.twig');
    });

    $app->post("/sleep", function() use ($app) {

    });

    $app->post("/dead", function() use ($app) {

    });

    return $app;
?>
