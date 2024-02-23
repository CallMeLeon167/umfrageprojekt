<?php 
namespace CML\Classes;
use CML\Classes\DB;
use Firebase\JWT\JWT;
class Login extends DB{
    use \CML\Classes\Functions\Functions;
    use \CML\Classes\Functions\Session;

    public function login(string $user, string $password){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $user_data = (filter_var($user, FILTER_VALIDATE_EMAIL)) ? 
            parent::sql2array_file("SELECT_USERBYUSEMAIL.sql", [$user])[0] : 
            parent::sql2array_file("SELECT_USERBYUSERNAME.sql", [$user])[0];
            if($user_data){
                $user_data = $user_data[0];
                $dbPassword = $user_data['a_password'];
                $savedSalt = $user_data['a_passwordSalt']; // random salt from DB
                $hashedPassword = hash('sha256', $password.$savedSalt); // hashed password with sha256 algorithm
                
                if ($hashedPassword === $dbPassword) {
                    // Einloggen erfolgreich
                    $user_data = JWT::encode($user_data, ENCODE_KEY, 'HS256');
                    $data = ["message" => "User is logged in"];
                    $data["userData"] = $user_data;
                } else {
                    //Password falsch
                    $data = ["message" => "Login is not correct"];
                    http_response_code(401);
                }
            } else {
                //User ist nicht vorhanden
                $data = ["message" => "User is not available"];
                http_response_code(401);
            }

            echo json_encode($data, JSON_PRETTY_PRINT);
        }
    }

    public function register(string $username, string $email, string $password) {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $salt = $this->generateSalt();
            $hashedPassword = hash('sha256', $password . $salt);
            $usernameCheck = parent::sql2array_file("SELECT_USERBYUSERNAME.sql", [$username])[0];
            $emailCheck = parent::sql2array_file("SELECT_USERBYUSEMAIL.sql", [$email])[0];
            if ($usernameCheck) {
                //Username is already taken
                $data = ["message" => "Username is already taken"];
                http_response_code(401);
            } elseif($emailCheck){
                //email is already taken
                $data = ["message" => "Email is already taken"];
                http_response_code(401);
            } else {
                // register users
                parent::sql2db_file("INSERT_USER.sql", [$username, $hashedPassword, $email, $salt]);
                $data = ["message" => "User registered successfully"];
            }
            
            echo json_encode($data, JSON_PRETTY_PRINT);
        } 
    }

    protected static function generateSalt() {
        return bin2hex(random_bytes(16));
    }
}

?>