<?php
namespace Jan\Foundation\Routing;


use Jan\Component\Container\Container;
use Jan\Component\Http\Response;


/**
 * Class DefaultController
 *
 * @package Jan\Foundation\Routing
 */
class DefaultController extends Controller
{

    /**
     * @var bool
    */
    protected $layout = false;


    /**
     * DefaultController constructor.
     * @param Container $container
     * @throws \Exception
    */
    public function __construct(Container $container)
    {
         $container->get('view')->resource(__DIR__ . '/Resources/views/');
    }


    /**
     * @return Response
    */
    public function index(): Response
    {
        return $this->render('welcome.php');
    }
}