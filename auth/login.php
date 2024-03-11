<?php
include_once '../helper_functions/DatabaseConfig.php';
include_once '../helper_functions/AuthenicationFunction.php';


//function for login of a user 


if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $users = mysqli_query($con, $sql);

    $usersCount = mysqli_num_rows($users);

    if ($usersCount > 0) {
        $user = mysqli_fetch_assoc($users);
        $password_hash = $user['password'];
        if (password_verify($password, $password_hash)) {
            login($user['user_id'], $user['role']);
        } else {
            echo json_encode(
                [
                    "status" => 400,
                    "message" => "Wrong password"
                ]
            );
        }
    } else {
        echo json_encode(
            [
                "status" => 400,
                "message" => "User not found"
            ]
        );
    }
} else {
    echo json_encode(
        [
            "status" => 400,
            "message" => "Please fill email and password all the fields"
        ]
    );
}
