<?php
/**
 * Created by PhpStorm.
 * User: shaowenyuan
 * Date: 01/04/2017
 * Time: 8:46 PM
 */
function conn(){
    $servername = "127.0.0.1";
    $username = "root";
    $password = "swy931212";
    $database = "test";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("connection fail:" . $conn->connect_error);
    }
    echo "success!";
    echo "\n";

    return $conn;
}

function close($conn){
    mysqli_close($conn);
}