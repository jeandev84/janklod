<?php
namespace Jan\Component\Routing;


use Jan\Component\Routing\Contract\RouterInterface;
use Jan\Component\Routing\Contract\UrlGeneratorInterface;
use Jan\Component\Routing\Traits\UrlGeneratorTrait;


/**
 * Class UrlGenerator
 * @package Jan\Component\Routing
*/
class UrlGenerator implements UrlGeneratorInterface
{

      use UrlGeneratorTrait;


      /**
       * @var RouterInterface
      */
      protected $router;


      /**
       * UrlGenerator constructor.
       * @param RouterInterface $router
      */
      public function __construct(RouterInterface $router)
      {
          $this->router = $router;
      }


      /**
       * @param string $name
       * @param array $params
       * @param int|null $mode [ URL_ABSOLUTE, URL_PATH ]
       * @return string
      */
      public function generate(string $name, array $params = [], int $mode = null): string
      {
          return $this->router->generate($name, $params);
      }
}