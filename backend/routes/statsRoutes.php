<?php
#options

#get
$router->addRoute('GET', '/stats', function () use ($router) {
    $router->isApi();
    echo $router->useController("StatsController", "getStatsData");
});
#post

#put

#delete

?>