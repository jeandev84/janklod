<?php
namespace Jan\Component\Form\Type;



use Jan\Component\Form\Type\Support\Type;


/**
 * Class TextareaType
 * @package Jan\Component\Form\Type
*/
class TextareaType extends Type
{

    /**
     * @return string
    */
    public function buildHtml(): string
    {
        return '<textarea name="'. $this->child .'"'. $this->getAttributes() .'></textarea>';
    }
}