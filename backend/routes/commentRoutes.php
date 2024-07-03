<?php
#options
$router->addRoute('OPTIONS', '/comment', function () {
});
#get
$router->addRoute('GET', '/comment', function () use ($router) {
    $router->isApi();
    $router->useController("CommentController", "getAllComments", []);
});
#post
$router->addRoute('POST', '/comment', function () use ($router) {
    $router->isApi();
    $router->useController("CommentController", "newSurveyComment", []);
});
#put

#delete

?>