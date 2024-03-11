<?php
include_once '../helper_functions/AuthenicationFunction.php';
include_once '../helper_functions/DatabaseConfig.php';

if (isset($_POST['token'])) {
    $user = getUserWithToken($_POST['token']);

    if ($user) {

        $sql = "DELETE FROM personal_access_token WHERE user_id = '$user'";
        $result = mysqli_query($con, $sql);

        if (!$result) {
            echo json_encode([
                "status" => 400,
                "message" => "Something went wrong"
            ]);
            return;
        } else {
            echo json_encode([
                "status" => 200,
                "message" => "User logged out successfully"
            ]);
        }
    } else {
        echo json_encode([
            "status" => 400,
            "message" => "Invalid token"
        ]);
    }
} else {
    echo json_encode([
        "status" => 400,
        "message" => "Please provide token"
    ]);
}
