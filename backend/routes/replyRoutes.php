<?php
#options
$router->addRoute('OPTIONS', '/reply', function () {
});
#get
$router->addRoute('GET', '/reply', function () use ($router) {
    $router->isApi();
    $router->useController("ReplyController", "getAllReplys", []);
});
#post
$router->addRoute('POST', '/reply', function () use ($router) {
    $router->isApi();
    $router->useController("ReplyController", "newCommentReply");
});
#put

#delete

?>