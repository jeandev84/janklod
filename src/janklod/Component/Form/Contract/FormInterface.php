<?php
namespace Jan\Component\Form\Contract;



use Jan\Component\Form\Type\Support\Type;

/**
 * Interface FormInterface
 * @package Jan\Component\Form\Contract
*/
interface FormInterface
{
    /**
     * @param string $child
     * @param string|null $type
     * @param array $options
     * @return $this
    */
    public function add(string $child, string $type = null, array $options = []);


    /**
     * Create a view form
     *
     * @return string
    */
    public function createView();
}