<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/1/2017
 * Time: 7:19 PM
 */
namespace App\Api\Controllers;
use \Slim\Http\Response;
use \Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
class LogoutController extends Controller
{

    public function logout(Request $request, Response $response){
        global $app;
        $view=$app->getContainer()->get('view');

        if(isset($_SESSION['email'])){
            $email =$_SESSION['email'];
//            echo "You were logged in as " .$_SESSION['email'];
            session_destroy();
            $response->withRedirect('/login');
            return $view->render($response, 'logout.twig', array('email'=>$email));
        }
    }


}