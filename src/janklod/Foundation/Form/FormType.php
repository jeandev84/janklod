<?php
namespace Jan\Foundation\Form;


use Jan\Component\Form\Type\CsrfTokenType;
use Jan\Component\Form\FormBuilder;



/**
 * Class FormType
 * @package Jan\Component\Form
*/
class FormType extends BaseType
{

    /**
     * @param FormBuilder $builder
     * @param $options
    */
    public function buildForm(FormBuilder $builder, $options)
    {
          $builder->add('_token', CsrfTokenType::class, [

          ])->add('_token', CsrfTokenType::class, [
              'constraints' => [
                  'required' => true,
                  'min' => 5,
                  'max' => 30
              ]
          ])
          ->add('date', '');
    }


    /**
     * @param OptionResolver $resolver
     * @return mixed
    */
    public function setOptions(OptionResolver $resolver)
    {

    }
}