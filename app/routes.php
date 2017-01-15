<?php

// Home page
$app->get('/', function () use ($app) {
    $articles = $app['dao.article']->findAll();
    return $app['twig']->render('index.html.twig', array('articles' => $articles));
})->bind('home');


// Détail
$app->get('/detail/{id}', function ($id) use ($app) {
    $article = $app['dao.article']->find($id);
    return $app['twig']->render('detail.html.twig', array('article' => $article));
})->bind('detail');

// modifier
$app->get('/modifier/{id}', function ($id) use ($app) {
    $article = $app['dao.article']->find($id);
    return $app['twig']->render('modifier.html.twig', array('article' => $article));
})->bind('modifier');

// supprimer
$app->get('/supprimer/{id}', function ($id) use ($app) {
    $article = $app['dao.article']->delete($id);
    return $app->redirect('/');
})->bind('supprimer');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

$app->match('/creer', function (Request $request) use ($app) {
    
    $form = $app['form.factory']->createBuilder(FormType::class, $data)
        ->add('name', TextType::class, array(
        'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5)))
    ))
    ->add('email', TextType::class, array(
        'constraints' => new Assert\Email()
    ))
    ->add('billing_plan', ChoiceType::class, array(
        'choices' => array(1 => 'free', 2 => 'small_business', 3 => 'corporate'),
        'expanded' => true,
        'constraints' => new Assert\Choice(array(1, 2, 3)),
    ))
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();

        // do something with the data

        // redirect somewhere
        return $app->redirect('/');
        //return $app->redirect($app["url_generator"]->generate("home"));
    }

    // display the form
    return $app['twig']->render('creer.twig.html', array('form' => $form->createView()));
});