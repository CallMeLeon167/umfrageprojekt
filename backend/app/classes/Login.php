<?php 
namespace CML\Classes;
use CML\Classes\DB;

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
                    $data = ["success" => "User is logged in"];
                    $data["userData"] = $user_data;
                } else {
                    //Password falsch
                    $data = ["error" => "Password is not correct"];
                }
            } else {
                //User ist nicht vorhanden
                $data = ["error" => "User is not available"];
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
                $data = ["error" => "Username is already taken"];
            } elseif($emailCheck){
                //email is already taken
                $data = ["error" => "Email is already taken"];
            } else {
                // register users
                parent::sql2db_file("INSERT_USER.sql", [$username, $hashedPassword, $email, $salt]);
                $data = ["success" => "User registered successfully"];
            }
            
            echo json_encode($data, JSON_PRETTY_PRINT);
        } 
    }

    protected static function generateSalt() {
        return bin2hex(random_bytes(16));
    }
}

?>