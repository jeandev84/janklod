<?php
namespace App\Controller;


use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
use Jan\Foundation\Routing\Controller;



/**
 * Class SiteController
 * @package App\Controller
*/
class SiteController extends Controller
{
      /**
       * SiteController constructor.
      */
      public function __construct()
      {

      }


      /**
       * @param Request $request
       * @return Response
      */
      public function index(Request $request): Response
      {
          return $this->render('site/index.php');
      }


      /**
       * @param Request $request
       * @return Response
      */
      public function about(Request $request): Response
      {
          return $this->render('site/about.php');
      }

      /**
       * @param Request $request
       * @return Response
      */
      public function contact(Request $request): Response
      {
          if($data = $request->request->all())
          {
              dump($data);
          }

          return $this->render('site/contact.php');
      }
}