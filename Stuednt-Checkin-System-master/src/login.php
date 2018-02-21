<?php
/**
 * Created by PhpStorm.
 * User: shaowenyuan
 * Date: 30/03/2017
 * Time: 8:14 PM
 */
/*
$judgement = _post("submit");
if(!isset($judgement)){
    exit('Illegal visit!');
}
*/
$user_name = htmlspecialchars(_post('username'));
$pass_word = MD5(_post('password'));

$servername = "127.0.0.1";
$username = "root";
$password = "swy931212";
$database = "test";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("connection fail:" . $conn->connect_error);
}

$query = "SELECT * FROM user_info WHERE email_add = '".$user_name."' AND password='".$pass_word."'";
$temp = mysqli_query($conn, $query);
$res = mysqli_fetch_row($temp);
if ($res) {
    echo "<script>alert('Login successful!')</script>";
    $url = "http://localhost/php/demo/6221_info.php";
    mysqli_close($conn);
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";
} else {
    echo "<script>alert('Please check your username and password!')</script>";
    $url = "http://localhost/php/demo/login.html";
    mysqli_close($conn);
    echo "<script language='javascript' type='text/javascript'>";
    echo "window.location.href='$url'";
    echo "</script>";

}

mysqli_close($conn);

function _post($str){
    $val = !empty($_POST[$str]) ? $_POST[$str] : null;
    return $val;
}














