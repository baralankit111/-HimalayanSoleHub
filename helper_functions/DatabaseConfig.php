<?php

$HOST = "localhost";
$USER = "root";
$PASSWORD = "";
$DATABASE = "ecom";

$con = mysqli_connect($HOST, $USER, $PASSWORD, $DATABASE);


if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
