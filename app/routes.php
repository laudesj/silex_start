<?php

// Home page
$app->get('/', function () use ($app) {
    $articles = $app['dao.article']->findAll();
    return $app['twig']->render('index.html.twig', array('articles' => $articles));
});

$app->get('/detail/{id}', function ($id) use ($app) {
    $article = $app['dao.article']->find($id);
    return $app['twig']->render('detail.html.twig', array('article' => $article));
});