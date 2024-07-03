<?php
#options

#get
$router->addRoute('OPTIONS', '/surveyParticipation', function () use ($router) {
});

//surveyParticipation erstellen
$router->addRoute('POST', '/surveyParticipation', function () use ($router) {
    $router->isApi();
    $router->useController("SurveyParticipationController", "submitSurveyParticipation");
});
#post

#put

#delete

?>