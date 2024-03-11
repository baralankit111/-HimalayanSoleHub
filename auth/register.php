<?php

//function for registering a user
include_once '../helper_functions/AuthenicationFunction.php';
include_once '../helper_functions/DatabaseConfig.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password'];

    if (isset($email) && isset($fullname) && isset($password)) {

        $sql = "SELECT * FROM users WHERE email = '$email'";

        $users = mysqli_query($con, $sql);
        $usersCount = mysqli_num_rows($users);

        if ($usersCount > 0) {
            echo json_encode([
                "status" => 409,
                "message" => "User already exists"
            ]);
            return;
        }

        $result =  register($fullname, $email, $password, 'user');

        if ($result) {
            echo json_encode([
                "status" => 200,
                "message" => "User registered successfully"
            ]);
        } else {
            echo json_encode([
                "status" => 500,
                "message" => "Something went wrong"
            ]);
        }
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Please fill all the fields"
        ]);
    }
}
