<?php
namespace Jan\Component\Routing\Contract;


/**
 * Interface UrlGeneratorInterface
 * @package Jan\Component\Routing\Contract
*/
interface UrlGeneratorInterface
{

     /**
      * set base url
      * @param string $baseUrl
      *
      * @return mixed
     */
     public function setBaseUrl(string $baseUrl);



     /**
      * generate route path by name
      *
      * @param string $name
      * @param array $params
      * @return string
     */
     public function generate(string $name, array $params = []): string;





     /**
      * generate URL
      *
      * @param string $path
      * @param array $queryParams
      * @param string $fragment
      * @return mixed
     */
     public function generateUrl(string $path, array $queryParams = [], string $fragment = '');
}