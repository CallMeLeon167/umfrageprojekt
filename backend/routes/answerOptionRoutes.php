<?php
#options

#get
$router->addRoute('GET', '/answerOption', function () use ($router) {
    $router->isApi();
    $router->useController("AnswerOptionController", "getAllAnswerOptions");
});
#post

#put

#delete

?>