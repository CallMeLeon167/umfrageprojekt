<?php 
require_once 'app/admin/cml-load.php'; 

use CML\Classes\Router;
use CML\Classes\DB;
use CML\Classes\Login;

$db = new DB();
$router = new Router();
$user = new Login();

$router->addRoute('GET', '/', function () use ($router) {
    $router->isApi();
    echo json_encode(["message" => "Hey Na!!!"]);
});

$router->addRoute('GET', '/register', function () use ($router, $user) {
    $router->isApi();
    $user->register("callmeleon", "kontakt@callmeleon.de", "TestPassword1234");
});

$router->addRoute('GET', '/login', function () use ($router, $user) {
    $router->isApi();
    $user->login("kontakt@callmeleon.de", "TestPassword1234"); //das geht
    // $user->login("callmeleon", "TestPassword1234"); //das geht auch :)
});