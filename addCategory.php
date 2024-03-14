<?php
include 'helper_functions\DatabaseConfig.php';
include 'helper_functions\AuthenicationFunction.php';


if (isset($_POST['token'])) {
    $isAdmin = isAdmin($_POST['token']);
    if (!$isAdmin) {
        echo json_encode([
            "status" => 403,
            "message" => "You are not authorized to perform this action"
        ]);
        die();
    }
    if (
        isset($_POST['title'])

    ) {
        $title = $_POST['title'];

        $sql = "select * from categories where title='$title'";

        $result = mysqli_query($con, $sql);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            echo json_encode([
                "status" => 400,
                "message" => "Category already exists"
            ]);
            die();
        }


        $sql = "INSERT INTO categories (title) VALUES ('$title')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo json_encode([
                "status" => 200,
                "message" => "Category added successfully"
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
            "message" => "Please fill all the fields (title)"
        ]);
    }
} else {
    echo json_encode([
        "status" => 400,
        "message" => "Please provide token"
    ]);
}
