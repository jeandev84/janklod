<?php
namespace Jan\Component\Form\Type;


use Jan\Component\Form\Type\Support\InputType;


/**
 * Class PasswordType
 * @package Jan\Component\Form\Type
*/
class PasswordType extends InputType
{


    /**
     * @return string
    */
    public function getType(): string
    {
        return 'password';
    }
}