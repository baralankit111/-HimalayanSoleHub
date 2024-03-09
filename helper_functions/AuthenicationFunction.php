<?php
include_once 'DatabaseConfig.php';

//function for registering a user 

function register($fullname, $email, $password, $role)
{
    global $con;

    //encrypting the password with hashing algorithm
    $encrypted_password = password_hash($password, PASSWORD_DEFAULT);


    //inserting the user into the database
    $sql = "INSERT INTO users (full_name, email, password,role) VALUES ('$fullname', '$email', '$encrypted_password','$role')";
    $result = mysqli_query($con, $sql);

    //checking if the user is inserted or not
    if ($result) {
        return true;
    } else {
        return false;
    }
}


//function for geting the user with token
function getUserWithToken($token)
{
    global $con;


    //getting the user with token
    $sql = 'SELECT * FROM personal_access_token WHERE token = "' . $token . '"';

    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        $user = mysqli_fetch_assoc($result);
        $userId = $user['user_id'];
        return $userId;
    } else {
        return null;
    }
}


//function for checking if the user is admin or not
function isAdmin($token)
{

    global $con;

    $userId = getUserWithToken($token);

    if ($userId) {
        //getting the user with token
        $sql = 'SELECT * FROM users WHERE user_id = "' . $userId . '"';
        $result = mysqli_query($con, $sql);

        if ($result) {
            //checking if the user is admin or not
            $user = mysqli_fetch_assoc($result);
            if ($user['role'] == 'admin') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}


//function for logging in a user

function login($userId, $role)
{
    global $con;

    //generating a random token for logged in user
    $token = bin2hex(openssl_random_pseudo_bytes(16));

    //inserting the token into the database
    $sql = "INSERT INTO personal_access_token (user_id, token) VALUES ('$userId', '$token')";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo json_encode(
            [
                "status" => 200,
                "message" => "User logged in successfully",
                "token" => $token,
                "role" => $role
            ]
        );
    } else {
        echo json_encode(
            [
                "status" => 500,
                "message" => "Something went wrong"
            ]
        );
    }
}
