<?php
namespace Jan\Component\Form\Type;



/**
 * Class ButtonSubmitType
 * @package Jan\Component\Form\Type
*/
class ButtonSubmitType extends ButtonType
{

    /**
     * @return string
    */
    public function getType(): string
    {
        return 'submit';
    }
}