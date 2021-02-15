<?php
namespace Jan\Component\Routing\Traits;


/**
 * Trait UrlGeneratorTrait
 * @package Jan\Component\Routing\Traits
*/
trait UrlGeneratorTrait
{

     /**
      * @var string
     */
     protected $url;


     /**
      * @param string $url
     */
     public function setBaseURL(string $url)
     {
         $this->url = $url;
     }


     /**
      * @return string
     */
     public function getBaseURL(): string
     {
         return $this->url;
     }



     /**
      * @param string $path
      * @param array $queryParams
      * @param string $fragment
      * @return string
     */
     public function generateUrl(string $path, array $queryParams = [], string $fragment = ''): string
     {
        return implode('/', [
            rtrim($this->url, '\\/'),
            trim($path, '\\/') . ($queryParams ? '?'. http_build_query($queryParams) : '') . $fragment
        ]);
     }
}