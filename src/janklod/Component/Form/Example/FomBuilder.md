# FORM BUILDER
```
$builder = new \Jan\Component\Form\FormBuilder();
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
->add('send', \Jan\Component\Form\Type\ButtonType::class, [])
->add('lunch', \Jan\Component\Form\Type\ButtonSubmitType::class, [])
->add('method', \Jan\Component\Form\Type\HiddenType::class, [])
->add('user', null);

dump($builder->getForms());


echo $builder->createView();
```