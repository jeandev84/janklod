<?php
namespace App\Controller\Security;


use Jan\Component\Http\Request;
use Jan\Component\Http\Response;
use Jan\Foundation\Routing\Controller;


/**
 * Class AuthController
 *
 * @package App\Controller\Security
*/
class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return Response
    */
    public function login(Request $request): Response
    {
        if($data = $request->request->all())
        {
            dump($data);
        }

        return $this->render('auth/login.php');
    }
}