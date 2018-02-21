<!DOCTYPE html>
<!-- saved from url=(0041)http://v3.bootcss.com/examples/dashboard/ -->
<html lang="zh-CN"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://v3.bootcss.com/favicon.ico">

    <title>Presentation Info</title>

    <!-- Bootstrap core CSS -->
    <link href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://v3.bootcss.com/examples/dashboard/dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./Dashboard Template for Bootstrap_files/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="http://localhost/php/demo/QRCode.php">QRcode Generator</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li><a href="http://localhost/php/demo/6221_info.php">6221_Software_Paradigms</a></li>
                <li class="active"><a href="http://localhost/php/demo/6111_EAP.php">6111_EAP</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

    <h1 class="sub-header">Presentation Info of class 6221_Advanced_Software_Paradigms</h1>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Gid</th>
                <th>Week1</th>
                <th>Week2</th>
                <th>Week3</th>
                <th>Week4</th>
                <th>Week5</th>
                <th>Week6</th>
                <th>Week7</th>
                <th>Attendance</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $servername = "127.0.0.1";
                $username = "root";
                $password = "swy931212";
                $database = "test";
                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("connection fail:" . $conn->connect_error);
                }

				$query ="SELECT * FROM 6111_EAP;";
    			$temp = mysqli_query($conn, $query);

				while ($res = mysqli_fetch_row($temp)) {
				    $i = 1;
				    $count = 0;
				    while ($i < 8) {
                        if ($res[$i] == 0) {
                            $count = $count+1;
                        }
                        $i = $i+1;
                    }
                    $attendance = 1-($count/7);
				    $attendance = round($attendance,4);
				    $attendance = $attendance * 100;
					?>
            <tr><td><?php echo $res[0]?></td>
                <td><?php echo $res[1]?></td>
                <td><?php echo $res[2]?></td>
                <td><?php echo $res[3]?></td>
                <td><?php echo $res[4]?></td>
                <td><?php echo $res[5]?></td>
                <td><?php echo $res[6]?></td>
                <td><?php echo $res[7]?></td>
                <td><?php echo $attendance.'%'?></td>

                <?php }?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>


