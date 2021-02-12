<?php

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
