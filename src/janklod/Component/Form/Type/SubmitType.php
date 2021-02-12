<?php
namespace Jan\Component\Form\Type;


use Jan\Component\Form\Type\Support\InputType;


/**
 * Class SubmitType
 * @package Jan\Component\Form\Type
*/
class SubmitType extends InputType
{

    /**
     * @return string
    */
    public function getType(): string
    {
        return 'submit';
    }
}