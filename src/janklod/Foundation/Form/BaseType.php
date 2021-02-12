<?php
namespace Jan\Foundation\Form;


use Jan\Component\Form\FormBuilder;


/**
 * Class FormType
 * @package Jan\Foundation\Form
 */
abstract class BaseType
{

    /**
     * @param FormBuilder $builder
     * @param $options
    */
    abstract public function buildForm(FormBuilder $builder, $options);


    /**
     * @param OptionResolver $resolver
     * @return mixed
     */
    public function setOptions(OptionResolver $resolver)
    {

    }
}