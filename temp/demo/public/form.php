<?php


/*
|----------------------------------------------------------------------
|   Autoloader classes and dependencies of application
|----------------------------------------------------------------------
*/


use Jan\Foundation\Facades\Templating\Asset;
//use Jan\Component\Templating\Asset as TemplateAsset;
use Jan\Foundation\Form\FormBuilder;


require_once __DIR__ . '/../vendor/autoload.php';



/*
|-------------------------------------------------------
|    Require bootstrap of Application
|-------------------------------------------------------
*/

$app = require_once __DIR__ . '/../bootstrap/app.php';


# ALIAS
//class_alias(Jan\Foundation\Facades\Templating\Asset::class, "Asset");


# FILESYSTEM
$filesystem = new \Jan\Component\FileSystem\FileSystem(
    realpath(__DIR__ . '/janklod/')
);


// dump($app);
// dd($app->getServiceProviders());

# BINDING
/*
$app->singleton('asset', function () use ($filesystem) {

    $assets = $filesystem->load('/config/asset.php');
    /* $asset = new TemplateAsset('http://localhost');
    $asset = new TemplateAsset();
    $asset->addStylesheets($assets['css']);
    $asset->addScripts($assets['js']);

    return $asset;
});


# FACADES AND ACCESSOR
Asset::setContainer($app);


# BUILD FORM
$builder = new FormBuilder();
$builder->add('username', \Jan\Component\Form\Type\TextType::class, [
    'label' => 'Логин',
    'attr'  => [
        'class' => 'form-control'
    ]
])->add('password', \Jan\Component\Form\Type\PasswordType::class, [
    'label' => 'Пароль',
    'attr'  => [
        'class' => 'form-control'
    ]
])->add('email', \Jan\Component\Form\Type\EmailType::class, [
    'label' => 'Электронная почта',
    'attr'  => [
        'class' => 'form-control'
    ]
   ])
    ->add('foo', null, [
        'label' => 'Тестовое',
        'attr' => [
            'class' => 'form-control'
        ]
    ])
    ->add('send', \Jan\Component\Form\Type\ButtonType::class, [
        'label' => 'Отправить',
        'attr' => [
            'class' => 'btn btn-primary',
            'style' => "margin-top: 10px;"
        ]
    ]); /*
    ->add('user', \Jan\Component\Form\Type\ButtonSubmitType::class, [
        'label' => 'Создать',
        'attr' => [
            'class' => 'btn btn-success'
        ]
    ]);

dump($builder->getForm());


$form = $builder->getForm();


$view = new \Jan\Component\Templating\View();
$view->setUrl('http://localhost:8000');
*/



/* Asset::css('css/font-awesome.min'); */

/*
|-------------------------------------------------------
|    Check instance of Kernel
|-------------------------------------------------------
*/

$kernel = $app->get(Jan\Contract\Http\Kernel::class);



/*
|-------------------------------------------------------
|    Get Response
|-------------------------------------------------------
*/


$response = $kernel->handle(
    $request = \Jan\Component\Http\Request::createFromGlobals()
);



/*
|-------------------------------------------------------
|    Send all headers to navigator
|-------------------------------------------------------
*/

$response->send();



/*
|-------------------------------------------------------
|    Terminate
|-------------------------------------------------------
*/

$kernel->terminate($request, $response);

?>
<!--
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <? // = Asset::renderCss() ?>
    <title>Welcome</title>
</head>
<body>

<div class="container">
    <h1>Регистрация</h1>
    <? //= $form->createView(); ?>
</div>

<script src="/assets/js/bootstrap.min.js"></script>
<? // = Asset::renderJs() ?>
</body>
</html>
