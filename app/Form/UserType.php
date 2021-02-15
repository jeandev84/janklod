<?php
namespace App\Form;


use Jan\Foundation\Form\OptionResolver;
use Jan\Component\Form\Type\HiddenType;
use Jan\Component\Form\Type\TextType;
use Jan\Foundation\Form\FormBuilder;
use Jan\Foundation\Form\FormType;



/**
 * Class UserType
 * @package App\Form
*/
class UserType extends FormType
{

    /**
     * @param FormBuilder $builder
     * @param $options
    */
    public function buildForm(FormBuilder $builder, $options)
    {
        $builder->add('username', TextType::class, [
            'label' => 'Логин',
            'attr'  => [
                'class' => 'form-control'
            ]
        ])->add('password', HiddenType::class, [
            'label' => 'Пароль',
            'attr'  => [
                'class' => 'form-control'
            ]
        ]);
    }


    /**
     * @param OptionResolver $resolver
    */
    public function setOptions(OptionResolver $resolver)
    {
        $resolver->setDefaults([

        ]);
    }
}


/*
$formTypes = [
  UserType::class,
  CategoryType::class
];


foreach ($formTypes as $formType)
{
    // $formType->buildForm();
    // $formType->setOptions();
}
*/