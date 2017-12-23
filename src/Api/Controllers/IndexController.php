<?php
/**
 * Created by PhpStorm.
 * User: Comp8
 * Date: 12/15/2017
 * Time: 10:57 PM
 */

namespace App\Api\Controllers;


use \Psr\Http\Message\RequestInterface;
use \Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
global $app;
$app->getContainer()->get('mysql');
$app->getContainer()->get('permission');

class IndexController extends Controller
{

}