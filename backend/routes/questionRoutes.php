<?php
#options

#get
$router->addRoute('GET', '/question', function () use ($router) {
    $router->isApi();
    $router->useController("QuestionController", "getAllQuestions");
});
#post

#put

#delete

?>