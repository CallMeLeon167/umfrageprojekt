<?php
#options
$router->addRoute('OPTIONS', '/register', function () use ($router, $user) {
});
#get

#post
$router->addRoute('POST', '/register', function () use ($router, $user) {
    $router->isApi();
    $username = $_POST["username"] ?? null;
    $email = $_POST["email"] ?? null;
    $password = $_POST["password"] ?? null;
    if (!$username || !$email || !$password) {
        http_response_code(400);
        echo json_encode(["message" => "Please fill in all fields"], JSON_PRETTY_PRINT);
    }
    $user->register($username, $email, $password);
});

#put
$router->addRoute('PUT', '/register', function () use ($router, $user) {
    $router->isApi();
});
#delete

?>