<?php
#options
$router->addRoute('OPTIONS', '/category', function () {
});
#get
$router->addRoute('GET', '/category', function () use ($router) {
    $router->isApi();
    $router->useController("CategoryController", "getCategories", []);
});
#post
$router->addRoute('POST', '/category', function () use ($router) {
    $router->isApi();
    $router->useController("CategoryController", "createCategory", []);
});
#put

#delete
$router->addRoute('DELETE', '/category/:id', function ($id) use ($router) {
    $router->isApi();
    $router->useController("CategoryController", "deleteCategory", ['id' => $id]);
});
?>