<?php
#options
$router->addRoute('OPTIONS', '/login', function () use ($router, $user) {
});
#get

#post

#put

#delete

#*
$router->addRoute('*', '/login', function () use ($router, $user) {
    $router->isApi();
    $username = $_POST["username"] ?? null;
    $password = $_POST["password"] ?? null;
    if (!$username || !$password) {
        http_response_code(400);
        echo json_encode(["message" => "Please fill in all fields"], JSON_PRETTY_PRINT);
    }
    $user->login($username, $password);
});
?>