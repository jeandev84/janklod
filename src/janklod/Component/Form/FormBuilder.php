<?php
namespace Jan\Component\Form;


use Jan\Component\Form\Contract\FormBuilderInterface;



/**
 * Class FormBuilder
 * @package Jan\Component\Form
 *
 *
*/
class FormBuilder implements FormBuilderInterface
{

    /**
     * @var Form
    */
    protected $form;


    /**
     * FormBuilder constructor.
     * @param Form $form
    */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }


    /**
     * @param string $child
     * @param string|null $type
     * @param array $options
     * @return $this
    */
    public function add(string $child, string $type = null, array $options = []): FormBuilder
    {
         $this->form->add($child, $type, $options);

         return $this;
    }


    /**
     * @param $type
     * @param null $data
     * @param array $options
     * @return Form
    */
    public function create($type, $data = null, array $options = []): Form
    {
          // name : FormType
          // data: User::class
          $this->form->setData($data);
          $this->form->setOptions($options);

          return $this->form;
    }



    /**
      * @return Form
    */
    public function getForm(): Form
    {
        return $this->form;
    }
}

