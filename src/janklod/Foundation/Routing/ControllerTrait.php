<?php
namespace Jan\Foundation\Routing;


use Jan\Component\Container\Container;
use Jan\Component\Container\Contract\ContainerInterface;
use Jan\Component\Http\JsonResponse;
use Jan\Component\Http\Response;
use Jan\Foundation\Form\Form;
use Jan\Foundation\Form\FormBuilder;
use Jan\Foundation\Form\OptionResolver;


/**
 * Trait ControllerTrait
 * @package Jan\Foundation\Routing
*/
trait ControllerTrait
{

    /**
     * @param string $formType
     * @param null $data (entity)
     *
     * $form = $this->>createForm(UserType::class, $user = new User());
     * $form->handle($request);
     *
     * if($form->isSubmitted() && $form->isValid())
     * {
     *      $data = $form->getData();
     *      $files = $form->get('brochure');
     * }
     * @param array $options
     * @return Form
    */
    public function createForm(string $formType, $data = null, array $options = []): Form
    {
        $formType = new $formType();
        $formBuilder = new FormBuilder(new Form($options)); // get from container
        $formType->buildForm($formBuilder, $data);
        $optionResolver = new OptionResolver(); // get from container
        $formType->setOptions($optionResolver);

        // get form
        return $formBuilder->getForm();
    }


    /**
     * @param $template
     * @param array $data
     * @param Response|null $response
     * @return Response
    */
    public function render($template, $data = [], Response $response = null): Response
    {
         $output = $this->renderHtml($template, $data);

         /* $template = $this->container->get('twig')->render($template, $data); */

         if(! $response)
         {
             $response = new Response();
         }

         $response->setContent($output);

         return $response;
    }


    /**
     * @param $template
     * @param array $data
     * @return mixed
    */
    public function renderHtml($template, $data = [])
    {
        return $this->container->get('view')->render($template, $data);
    }


    /**
     * @param string $json
     * @param int $code
     * @param array $headers
     * @return JsonResponse
    */
    public function json(string $json, int $code = 200, array $headers = []): JsonResponse
    {
         return new JsonResponse($json, $code, $headers);
    }

}