<?php
namespace App\Controller;


use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
use Jan\Foundation\Routing\Controller;


/**
 * Class UserController
 * @package App\Controller
*/
class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
    */
    public function signUp(Request $request)
    {
        if($data = $request->request->all())
        {
            dump($data);
        }
        return $this->render('site/signup.php');
    }
}