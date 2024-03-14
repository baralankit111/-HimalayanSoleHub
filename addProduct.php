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
        isset($_POST['name']) &&
        isset($_POST['price']) &&
        isset($_POST['description']) &&
        isset($_POST['category']) &&
        isset($_FILES['image'])

    ) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['category'];

        //get image
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];

        if ($image_size > 5000000) {
            echo json_encode([
                "status" => 400,
                "message" => "Image size should be less than 5MB"
            ]);
            die();
        }

        $image_path = "images/$image";

        if (!(move_uploaded_file($image_tmp, $image_path))) {
            echo json_encode([
                "status" => 400,
                "message" => "Image upload failed"
            ]);
            die();
        }


        $sql = "INSERT INTO products (title, price, description, category_id, image_url) VALUES ('$name', '$price', '$description', '$category', '$image_path')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            echo json_encode([
                "status" => 200,
                "message" => "Product added successfully"
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
            "message" => "Please fill all the fields (name, price, description, category and image)"
        ]);
    }
} else {
    echo json_encode([
        "status" => 400,
        "message" => "Please provide token"
    ]);
}
