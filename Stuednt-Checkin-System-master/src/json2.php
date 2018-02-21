<?php
/**
 * Created by PhpStorm.
 * User: shaowenyuan
 * Date: 21/04/2017
 * Time: 10:12 PM
 */
include "test.php";

if(isset($_POST['info'])) {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "swy931212";
    $database = "test";
    $gid = $_POST['gid'];

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        echo '{"success":0}';
    }
    $para = $_POST['info'];
    $para = decode($para);
    $para = json_decode($para,true);
    $week = $para['week'];
    $time = $para['time'];
    $class = $para['content'];

    $query_1 = "SELECT Access FROM Class_Maintain WHERE ClassNum = '".$class."'";
    $temp = mysqli_query($conn,$query_1);
    $res = mysqli_fetch_row($temp);
    if ($res[0] != 1) {
        echo '{"success":2}';
    } else {

        $query = "UPDATE `" . $class . "` SET `" . $week . "` = '" . $time . "' WHERE `gid`='" . $gid . "'";
        $tem = mysqli_query($conn, $query);
        //$res = mysqli_fetch_row($tem);
        if ($tem) {
            echo '{"success":1}';
        } else {
            echo '{"success":0}';
        }

        mysqli_close($conn);
    }
} else {
    echo '{"success":0}';
}

