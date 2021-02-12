<?php
namespace Jan\Component\Form\Type;


use Jan\Component\Form\Type\Support\Type;


/**
 * Class ButtonType
 * @package Jan\Component\Form\Type
*/
class ButtonType extends Type
{

    /**
     * @return string
    */
    public function getType(): string
    {
         return 'button';
    }


    /**
     * @return string
    */
    public function buildHtml(): string
    {
         return $this->buildButton();
    }



    /**
     * @return string
    */
    public function buildButton(): string
    {
        return '<button type="'. $this->getType() .'" name="'. $this->child .'" '. $this->getAttributes() .'>'. $this->getLabel() .'</button>';
    }

}