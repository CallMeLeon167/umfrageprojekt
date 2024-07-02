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
    $user->register("admin", "admin@callmeleon.de", "admin");
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

$router->addRoute('OPTIONS', '/survey/:id', function ($id) use ($router, $user) {
});
$router->addRoute('OPTIONS', '/survey', function () use ($router, $user) {
});
$router->addRoute('OPTIONS', '/survey-evaluation', function () {
});
$router->addRoute('OPTIONS', '/survey-evaluation/:id', function () {
});

//
$router->addRoute('GET', '/survey', function () use ($router) {
    $router->isApi();
    $router->useController("SurveyController", "getAllSurveys");
});
//zum abrufen von surveys
$router->addRoute('GET', '/survey/:id', function ($id) use ($router) 
{
    $router->isApi();
    $router->useController("SurveyController", "getSurveyById", ['id' => $id]);
});

//survey erstellen
$router->addRoute('POST', '/survey', function () use ($router) {
    $router->isApi();
    $router->useController("SurveyController", "newSurvey");
});

//survey löschen
$router->addRoute('DELETE', '/survey/:id', function ($id) use ($router) {
    $router->isApi();
    $router->useController("SurveyController", "deleteSurvey", ['id' => $id]);
});

//survey evaluation
$router->addRoute('GET', '/survey-evaluation/:id', function ($id) use ($router) {
    $router->isApi();
    $router->useController("SurveyController", "surveyResults", ['id' => $id]);
});

$router->addRoute('OPTIONS', '/surveyParticipation', function () use ($router) {
});

//surveyParticipation erstellen
$router->addRoute('POST', '/surveyParticipation', function () use ($router) {
    $router->isApi();
    $router->useController("SurveyParticipationController", "submitSurveyParticipation");
});

//daten für statansicht generieren
$router->addRoute('GET', '/stats', function () use ($router) {
    $router->isApi();
    echo $router->useController("StatsController", "getStatsData");
});

//abrufen der kateogrien (ohne verknüpfungen)
$router->addRoute('GET', '/category', function () use ($router) {
    $router->isApi();
    $router->useController("CategoryController", "getCategories", []);
});

//kategorie erstellen
$router->addRoute('POST', '/category', function () use ($router) {
    $router->isApi();
    $router->useController("CategoryController", "createCategory", []);
});

$router->addRoute('OPTIONS', '/category', function () {
});
//$router->addRoute('OPTIONS', '/category/:id', function () {});

$router->addRoute('DELETE', '/category/:id', function ($id) use ($router) {
    $router->isApi();
    $router->useController("CategoryController", "deleteCategory", ['id' => $id]);
});

$router->addRoute('GET', '/question', function () use ($router) {
    $router->isApi();
    $router->useController("QuestionController", "getAllQuestions");
});

$router->addRoute('GET', '/answerOption', function () use ($router) {
    $router->isApi();
    $router->useController("AnswerOptionController", "getAllAnswerOptions");
});
$router->addRoute('GET', '/userResponse', function () use ($router) {
    $router->isApi();
    $router->useController("StatsController", "getUserResponses");
});

