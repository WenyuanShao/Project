<?php
/**
 * Created by PhpStorm.
 * User: shaowenyuan
 * Date: 02/04/2017
 * Time: 4:30 PM
 */

$signup_username = (_post('username'));
$signup_password = MD5(_post('password'));
$signup_password_conf = MD5(_post('password_conf'));

if ($signup_password != $signup_password_conf) {
    echo "<script>alert('The password does not match!')</script>";
    $url = "http://localhost/php/demo/signup.html";
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

$servername = "127.0.0.1";
$username = "root";
$password = "swy931212";
$database = "test";
$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("connection fail:" . $conn->connect_error);
}

$query = "INSERT INTO user_info VALUES ('".$signup_username."', '".$signup_password."')";

$temp2 = mysqli_query($conn, $query);
$res = mysqli_fetch_row($temp2);

$row_affect = mysqli_affected_rows($conn);

if($row_affect != -1) {
    echo "<script>alert('Sign up success! Please sign in!')</script>";
    $url = "http://localhost/php/demo/login.html";
    mysqli_close($conn);
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
} else {
    echo "<script>alert('Sign up failed! Please try again!')</script>";
    $url = "http://localhost/php/demo/signup.html";
    mysqli_close($conn);
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
}

function _post($str){
    $val = !empty($_POST[$str]) ? $_POST[$str] : null;
    return $val;
}