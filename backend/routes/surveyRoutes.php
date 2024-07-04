<?php
#options
$router->addRoute('OPTIONS', '/survey/:id', function ($id) use ($router, $user) {
});
$router->addRoute('OPTIONS', '/survey', function () use ($router, $user) {
});
$router->addRoute('OPTIONS', '/survey-evaluation', function () {
});
$router->addRoute('OPTIONS', '/survey-evaluation/:id', function ($id) use ($router) {
});
#get
$router->addRoute('GET', '/survey', function () use ($router) {
    $router->isApi();
    $router->useController("SurveyController", "getAllSurveys");
});

$router->addRoute('GET', '/survey/:id', function ($id) use ($router) 
{
    $router->isApi();
    $router->useController("SurveyController", "getSurveyById", ['id' => $id]);
});

$router->addRoute('GET', '/survey-evaluation/:id', function ($id) use ($router) {
    $router->isApi();
    $router->useController("SurveyController", "surveyResults", ['id' => $id]);
});
#post
$router->addRoute('POST', '/survey', function () use ($router) {
    $router->isApi();
    $router->useController("SurveyController", "newSurvey");
});
#put

#delete
$router->addRoute('DELETE', '/survey/:id', function ($id) use ($router) {
    $router->isApi();
    $router->useController("SurveyController", "deleteSurvey", ['id' => $id]);
});
?>