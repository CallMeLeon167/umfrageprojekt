<?php 
require_once 'app/admin/cml-load.php'; 

use CML\Classes\Router;
use CML\Classes\DB;
use CML\Classes\Login;

$db = new DB();
$router = new Router();
$user = new Login();

$router->addRoute('*', '/sql', function () use ($router, $db) {
    $name = "callmeleon";
    $t = $db->sql2db_file("SELECT_USERBYUSERNAME.sql", [$name]);
    var_dump($t);
});

$router->addRoute('GET', '/', function () use ($router) {
    $router->isApi();
    echo json_encode(["message" => "Hey Na!!!"]);
});

$router->addRoute('*', '/register', function () use ($router, $user) {
    $router->isApi();
    $user->register("callmeleon", "kontakt@callmeleon.de", "TestPassword1234");
});

$router->addRoute('*', '/login', function () use ($router, $user) {
    $router->isApi();
    $user->login("kontakt@callmeleon.de", "TestPassword1234"); //das geht
    // $user->login("callmeleon", "TestPassword1234"); //das geht auch :)
});