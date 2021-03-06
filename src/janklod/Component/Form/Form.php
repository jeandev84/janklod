<?php
namespace Jan\Component\Form;


use Jan\Component\Form\Contract\FormInterface;
use Jan\Component\Form\Type\CsrfTokenType;
use Jan\Component\Form\Type\Support\Type;
use Jan\Component\Form\Type\TextType;
use Jan\Component\Form\Type\Traits\FormTrait;
use Jan\Component\Http\Request;
use Jan\Component\Security\CsrfToken;
use Jan\Component\Validation\Contract\ValidationInterface;
use Jan\Component\Validation\Validator;


/**
 * Class Form
 *
 * @package Jan\Component\Form
*/
class Form implements FormInterface
{

       use FormTrait;


       /**
        * @var array
       */
       protected $items = [];


       /**
        * @var array
       */
       protected $data = [];


       /**
        * @var array
       */
       protected $options = [];



       /**
        * @var array
       */
       protected $html  = [];


       /**
        * @var array
       */
       protected $errors = [];


       /**
        * @var string[]
       */
       protected $defaultOptions = [
           'method' => 'POST',
           'enctype' => 'multipart/form-data'
       ];



       /**
        * @var Request
       */
       protected $request;


       /**
        * @var Validator
       */
       protected $validator;


       /**
        * @var CsrfToken
       */
       protected $csrfToken;



       /**
        * @var bool
       */
       protected $enabled = false;


       /**
        * @var bool
       */
       protected $disabled = false;


       /**
        * Form constructor.
        * @param ValidationInterface|null $validator
       */
       public function __construct(ValidationInterface $validator = null)
       {
            if(! $validator)
            {
                $validator = new Validator();
            }

            $this->validator = $validator;
       }


       /**
        * start form
        *
        * @param array $attrs
       */
       public function start(array $attrs = [])
       {
            if($this->disabled === false)
            {
                $attrs = array_merge($attrs, $this->defaultOptions);
                $this->html[] = '<form '. $this->buildAttributes($attrs) . '>';
                $this->disabled = true;
            }
       }



       /**
        * close form
       */
       public function end()
       {
           if($this->disabled === true)
           {
               $this->add('_token', CsrfTokenType::class, [
                   'label' => false,
                   'attr' => [
                       'value' => md5(uniqid())
                   ]
               ]);

               $this->html[] = "</form>";
               $this->disabled = false;
           }
       }


       /**
        * @param string $child
        * @param string|null $type
        * @param array $options
        * @return $this
       */
       public function add(string $child, string $type = null, array $options = []): Form
       {
           if($this->disabled === false)
           {
               $this->items[] = $type = $this->resolveFieldType($type, $child, $options);

               if($type instanceof Type)
               {
                   $this->html[] = $type->buildHtml();
               }

               $this->validator->add($child);
           }

           return $this;
       }


       /**
        * Form handle request
        *
        * @param Request $request
        * @return Form
       */
       public function handle(Request $request): Form
       {
             $method = $request->getMethod();

             if(\in_array($method, ['POST', 'PUT', 'HEAD', 'PATCH']))
             {
                 $this->data =  array_merge($request->request->all(), $request->files->all());

                 // $this->enabled  = true;

                 // $request->session->set('_token', $this->data['_token']);
             }

             if($request->getMethod() == 'GET')
             {
                 $this->data = $request->queryParams->all();

                 // $this->enabled = true;
             }

             $this->request = $request;

             return $this;
       }


       /**
        * @return bool
       */
       public function isSubmitted(): bool
       {
            return ! empty($this->data) && $this->enabled;
       }


       /**
         * @return bool
       */
       public function isValid(): bool
       {
           // Validation

           $this->errors = $this->validator->getErrors();

           return $this->isSubmitted() && $this->validator->isValid();
       }


       /**
        * @param array $data
        * @return Form
       */
       public function setData(array $data)
       {
           $this->data = $data;

           return $this;
       }


       /**
        * @param array $options
        * @return Form
       */
       public function setOptions(array $options)
       {
            $this->options = $options;

            return $this;
       }


       /**
        * Get form errors
        * @return array
       */
       public function getErrors(): array
       {
           return $this->errors;
       }


       /**
        * @param $name
        * @return $this
        *
        * $form = new Form();
        * $form->getData();
        * $form->get('brochure')->getData();
        *
       */
       public function get($name)
       {
           $data = $this->data[$name] ?? [];

           $this->setData($data);

           return $this;
       }


       /**
        * @return array
       */
       public function getData(): array
       {
           return $this->data;
       }



       /**
        * @return array
       */
       public function getItems(): array
       {
           return $this->items;
       }


       /**
        * Create a view form
       */
       public function createView(): string
       {
           /*
           $this->end();

           return join("\n", $this->html);
           */
           $this->start();
           $this->end();

           return join("\n", $this->html);
       }


      /**
      * @param string|null $type
      * @param string $child
      * @param array $options
      * @return Type|null
     */
     protected function createType(?string $type, string $child, array $options = []): ?Type
     {
         if(is_null($type))
         {
             return new TextType($child, $options);
         }

         $type = new $type($child, $options);

         return $type instanceof Type ? $type : null;
     }
}