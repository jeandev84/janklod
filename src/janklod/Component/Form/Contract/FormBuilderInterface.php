<?php
namespace Jan\Component\Form\Contract;


/**
 * Interface FormBuilderInterface
 * @package Jan\Component\Form\Contract
*/
interface FormBuilderInterface
{
    /**
     * @param string $child
     * @param string|null $type
     * @param array $options
     *
     * @return self
    */
    public function add(string $child, string $type = null, array $options = []);


    /**
     * @param $name
     * @param null $data
     * @param array $options
     * @return mixed
    */
    public function create($type, $data = null, array $options = []);


    /**
     * @return FormInterface
    */
    public function getForm();
}