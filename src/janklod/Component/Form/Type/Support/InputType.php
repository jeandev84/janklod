<?php
namespace Jan\Component\Form\Type\Support;


/**
 * Class InputType
 * @package Jan\Component\Form\Type\Support
*/
abstract class InputType extends Type
{

    /**
     * @return string
    */
    public function buildHtml(): string
    {
        return $this->buildInput();
    }


    /**
     * @return string
    */
    public function buildInput(): string
    {
        $html = '';

        if(! $this->hasOption('label'))
        {
            $this->setOption('label', ucfirst($this->child));
        }

        if($label = $this->getOption('label'))
        {
            $html .= $this->buildLabel();
        }

        $html .= '<input type="'. $this->getType() .'" name="'. $this->child .'"'. $this->getAttributes() .'>';

        return $html;
    }
}