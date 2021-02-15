<?php
namespace Jan\Component\Form\Type;



use Jan\Component\Form\Type\Support\Type;


/**
 * Class ChoiceType
 * @package Jan\Component\Form\Type
*/
class ChoiceType extends Type
{

    /**
     * @return string
    */
    public function buildHtml(): string
    {
        // if options (checkbox, radio, select)
        $html  = '<select name="'. $this->child .'">';
        $html .= '<option>-Ничего-</option>';
        return $html .= '</select>';
    }
}