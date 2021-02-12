<?php
namespace Jan\Component\Routing\Contract;


/**
 * Interface RouterInterface
 * @package Jan\Component\Routing\Contract
*/
interface RouterInterface
{


     /**
      * Set Host (That is the base URL)
      *
      * @param string $baseUrl
      *  @return mixed
     */
     public function setBaseURL(string $baseUrl);



     /**
      * @return string
     */
     public function getBaseURL();



     /**
      * get routes
      *
      * @return mixed
     */
     public function getRoutes();



     /**
      * Determine matched route
      *
      * @param string $requestMethod
      * @param string $requestUri
      * @return mixed
     */
     public function match(string $requestMethod, string $requestUri);



     /**
      * Generate route by given name
      *
      * @param string $name
      * @param array $params
      * @return string
     */
     public function generate(string $name, array $params = []);
}
