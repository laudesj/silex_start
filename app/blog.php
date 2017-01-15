<?php
$blog = $app['controllers_factory'];
// Home page
$blog->get('/', function () use ($app) {
    $articles = $app['dao.article']->findAll();
    return $app['twig']->render('index.html.twig', array('articles' => $articles));
})->bind('home');


// Détail
$blog->get('/detail/{id}', function ($id) use ($app) {
    $article = $app['dao.article']->find($id);
    return $app['twig']->render('detail.html.twig', array('article' => $article));
})->bind('detail');

// modifier
$blog->get('/modifier/{id}', function ($id) use ($app) {
    $article = $app['dao.article']->find($id);
    return $app['twig']->render('modifier.html.twig', array('article' => $article));
})->bind('modifier');

// supprimer
$blog->get('/supprimer/{id}', function ($id) use ($app) {
    $article = $app['dao.article']->delete($id);
    return $app->redirect('/blog');
})->bind('supprimer');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;

$blog->match('/creer', function (Request $request) use ($app) {
    $data = array();
    $form = $app['form.factory']->createBuilder(FormType::class, $data)
        ->add('titre', TextType::class, array(
        'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => 5, 'max'=>50)))
    ))
    ->add('contenu', TextType::class, array('constraints' => array(new Assert\NotBlank())))
    // ->add('email', TextType::class, array(
    //     'constraints' => new Assert\Email()
    // ))
    // ->add('billing_plan', ChoiceType::class, array(
    //     'choices' => array(1 => 'free', 2 => 'small_business', 3 => 'corporate'),
    //     'expanded' => true,
    //     'constraints' => new Assert\Choice(array(1, 2, 3)),
    // ))
        ->getForm();

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();
        $app['dao.article']->insert($data);
        // redirect somewhere
        return $app->redirect('/blog');
        //return $app->redirect($app["url_generator"]->generate("home"));
    }

    // display the form
    return $app['twig']->render('creer.twig.html', array('form' => $form->createView()));
});

return $blog;