<?php
require_once 'app/admin/cml-load.php';

use CML\Classes\{Router, DB, Login};


$db = new DB();
$router = new Router();
$user = new Login();

$allowed_origins = ["http://localhost:5173", "localhost"];
$http_origin = $_SERVER['HTTP_ORIGIN'] ?? "*";

if (in_array($http_origin, $allowed_origins)) {
    header("Access-Control-Allow-Origin: $http_origin", true);
} else {
    header("Access-Control-Allow-Origin: *", true);
}

header("Access-Control-Allow-Methods: 'GET, POST, PUT, DELETE, OPTIONS'", true);
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Cookie', true);
header("Access-Control-Allow-Credentials: true", true);

include 'routes/answerOptionRoutes.php';
include 'routes/categoryRoutes.php';
include 'routes/loginRoutes.php';
include 'routes/questionRoutes.php';
include 'routes/registerRoutes.php';
include 'routes/statsRoutes.php';
include 'routes/surveyParticipationRoutes.php';
include 'routes/surveyRoutes.php';
include 'routes/userResponseRoutes.php';
include 'routes/commentRoutes.php';

$router->addRoute('*', '/sql', function () use ($router, $db) {
    $name = "callmeleon";
    $t = $db->sql2db_file("SELECT_USERBYUSERNAME.sql", [$name]);
    var_dump($t);
});

$router->addRoute('GET', '/', function () use ($router) {
    $router->isApi();
    echo json_encode(["message" => "Hey Na!!!"]);
});

