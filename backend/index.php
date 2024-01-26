<?php 
require_once 'app/admin/cml-load.php'; 

use CML\Classes\Router;
use CML\Classes\DB;

$db = new DB();
$router = new Router();

$router->addRoute('GET', '/', function () use ($router) {
    $router->isApi();
    echo json_encode(["message" => "Hey Na!!!"]);
});