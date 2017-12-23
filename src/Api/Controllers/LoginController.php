<?php

namespace App\Api\Controllers;


use \Slim\Http\Response;

use \Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface as Request;


class LoginController extends Controller
{

    public function __construct()
    {
    }

    public function login(Request $request, Response $response)
    {
        global $app;
        $view=$app->getContainer()->get('view');
        if (isset($_SESSION['email'])) {
            echo "You are logged in as " . $_SESSION['email'] . ". If this is not your account then log out and log in with your account";
            return $view->render($response, 'index.twig');
        } else {
            $response->withRedirect('/');
            return $view->render($response, 'login.twig');
        }


    }

    public function doLogin(Request $request, Response $response)
    {
        global $app;
        $view=$app->getContainer()->get('view');
        $mysqli=$app->getContainer()->get('mysql');
        $email = $mysqli->escape_string($_POST['email']);

        $result = $mysqli->query("SELECT * FROM Users WHERE email = '$email'");
        if ($result->num_rows == 0) {
            echo "Users with email address " . $email . " does not exist";

        } else {
            global $user;
            $user = $result->fetch_assoc();
            if (md5($_POST['password']) === $user['password']) {
                $_SESSION['email'] = $user['email'];
                $_SESSION['first_name'] = $user['firstname'];
                $_SESSION['last_name'] = $user['lastname'];
                return $response->withRedirect('/profile');


            } else {
                echo "The password You have entered is wrong!";
                return $view->render($response, 'index.twig');

            }
        }

    }


}

?>
