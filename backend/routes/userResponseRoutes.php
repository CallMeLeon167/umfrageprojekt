<?php
#options

#get
$router->addRoute('GET', '/userResponse', function () use ($router) {
    $router->isApi();
    $router->useController("StatsController", "getUserResponses");
});
#post

#put

#delete

?>