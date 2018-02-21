<?php
/**
 * Created by PhpStorm.
 * User: shaowenyuan
 * Date: 20/04/2017
 * Time: 6:06 PM
 */
if(isset($_POST['gid'])) {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "swy931212";
    $database = "test";
    $gid = $_POST['gid'];
    $password_gid = $_POST['password'];

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        echo '{"success":0}';
    }

    $query = "SELECT * FROM User WHERE gid = '".$gid."' AND password='".$password_gid."'";
    $temp = mysqli_query($conn, $query);
    $res = mysqli_fetch_row($temp);
    if ($res) {
        echo '{"success":1}';
    } else {
        echo '{"success":0}';
    }

    mysqli_close($conn);

} else {
    echo '{"success":0}';
}



function _post($str){
    $val = !empty($_POST[$str]) ? $_POST[$str] : null;
    return $val;
}


?>