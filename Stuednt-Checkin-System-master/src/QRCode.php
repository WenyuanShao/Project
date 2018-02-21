<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>QRCode Generator</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="QRCode.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <SCRIPT LANGUAGE=JavaScript>
        function post(){
            if(document.getElementById('content').value=='') {
                alert('please input your class number!');
                document.getElementById('content').focus();
                return false;
            }
            if(ckregdatapost()==false) {
                return false;
            }
        }
    </SCRIPT>
</head>
<body class="newcrop">
    <div class="er">
    <?php
    include "test.php";

    function _get($str){
        $val = !empty($_GET[$str]) ? $_GET[$str] : null;
        return $val;
    }

    $num=_get('content');
    $name = _get('name');
    $content = $num ."_".$name;
    $week = _get('week');
    $date=date("Y-m-d");
    date_default_timezone_set("EST");
    $time=date("h:i:sa");
    $param = array(
        'content'=>$content,
        'time'=>$time,
        'week'=>$week
    );
    $param = json_encode($param);
    $width=300;
    $height=300;

    $param = encode($param);
    $judge = disable();
    if($num) {
        $judge = class_access($content,1);
        if($judge == 1){
            echo "Please Scan!<br/> ";
            $content_g = urlencode($param);
            echo "<img id=qrcode_img 
                src=https://chart.googleapis.com/chart?cht=qr&chld=H&chs={$width}x{$height}&chl={$content_g}>
                <br/>
                <a href='javascript:history.go(-1);'>Go back!</a>";
        }
    } else {
        ?>
        <form action="" method="get" onsubmit="return post();">
            <h1>QRCode Generator</h1>
            Please Input The Number of The Class<br/>
            <textarea rows="1" cols="30" name="content" id="content" ></textarea> <br/>
            Please Input The Name of The Class<br/>
            <textarea rows="1" cols="30" name="name" id="name" ></textarea> <br/>
            Please Input The Week<br/>
            <textarea rows="1" cols="30" name="week" id="week" ></textarea>
            <br/><br/>
            <input type="submit" value="submit"  /> &nbsp;&nbsp;&nbsp;<INPUT TYPE="RESET" VALUE="re-enter">
            <br/>
        </form>
    <?}
    function class_access($classnum,$p) {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "swy931212";
        $database = "test";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("connection fail:" . $conn->connect_error);
        }

        $query = "UPDATE Class_Maintain SET Access = '$p' WHERE ClassNum='$classnum'";
        $temp = mysqli_query($conn, $query);
        if ($temp) {
            mysqli_close($conn);
            return 1;
        } else {
            mysqli_close($conn);
            return 0;
        }
    }

    function disable() {
        $servername = "127.0.0.1";
        $username = "root";
        $password = "swy931212";
        $database = "test";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("connection fail:" . $conn->connect_error);
        }

        $query = "UPDATE Class_Maintain SET Access = '0'";
        $temp = mysqli_query($conn, $query);
        if ($temp) {
            mysqli_close($conn);
            return 1;
        } else {
            mysqli_close($conn);
            return 0;
        }
    }

    ?>
    <div>
</body>
</html>