<?php 
require_once 'app/admin/cml-load.php'; 

use CML\Classes\{ Router, DB, Login };

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
// zum ändern von accountdaten
$router->addRoute('PUT', '/register', function () use ($router, $user) {
    $router->isApi();
});

$router->addRoute('*', '/login', function () use ($router, $user) {
    $router->isApi();
    $user->login("kontakt@callmeleon.de", "TestPassword1234"); //das geht
    // $user->login("callmeleon", "TestPassword1234"); //das geht auch :)
});
//filterung per form, gibt komplettes Survey objekt zurück
$router->addRoute('GET', '/survey', function () use ($router) {
    $router->isApi(); 
    $router->useController("SurveyController", "getAllSurveys");  
    echo "test";     
});
//zum abrufen von surveys
$router->addRoute('GET', '/survey/:id', function ($id) use ($router) {
    $router->isApi();        
});
//survey erstellen
$router->addRoute('POST', '/survey', function () use ($router) {
    $router->isApi();        
});
//survey löschen
$router->addRoute('DELETE', '/survey/:id', function ($id) use ($router) {
    $router->isApi();        
});
//surveyParticipation erstellen
$router->addRoute('POST', '/surveyParticipation', function () use ($router) {
    $router->isApi();        
});
//daten für statansicht generieren
$router->addRoute('GET', '/stats', function () use ($router) {
    $router->isApi();        
});
//abrufen der kateogrien (ohne verknüpfungen)
$router->addRoute('GET', '/category', function () use ($router) {
    $router->isApi();
    $router->useController("CategoryController", "getCategorys",[]);        
});