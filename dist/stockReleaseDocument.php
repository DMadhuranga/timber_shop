<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/28/2017
 * Time: 10:19 PM
 */
include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
include_once("assests/common/classes/Sale.php");
include_once("assests/common/sale_support/sale_support.php");
$sideBar = authenticate($dbh,array("1","0","2"),$_SERVER['REQUEST_URI']);
$user = unserialize($_SESSION["user"]);
if(!isset($_GET["id"])){
    header("location:home.php");
}
$sale = getSale($dbh,$_GET["id"]);
if($sale==null){
    header("location:home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Kalum Timber</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
</head>
<body class="sidebar-mini fixed">
<div class="wrapper">
    <!-- Navbar-->
    <header class="main-header hidden-print"><a class="logo" href="home.php">Kalum Timber</a>
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button--><a class="sidebar-toggle" href="#" data-toggle="offcanvas"></a>
            <!-- Navbar Right Menu-->
            <div class="navbar-custom-menu">
                <ul class="top-nav">
                    <!--Notification Menu-->
                    <li class="dropdown notification-menu"><a class="dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-bell-o fa-lg"></i></a>
                        <ul class="dropdown-menu">
                        </ul>
                    </li>
                    <!-- User Menu-->
                    <li class="dropdown"><a class="dropdown-toggle" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-lg"></i></a>
                        <ul class="dropdown-menu settings-menu">
                            <li><a href="profile.php"><i class="fa fa-user fa-lg"></i> Profile</a></li>
                            <li><a href="logout.php"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Side-Nav-->
    <aside class="main-sidebar hidden-print">
        <section class="sidebar">
            <div class="user-panel">
                <div class="pull-left image"><img class="img-circle" src="images/home_user_white.png" alt="User Image"></div>
                <div class="pull-left info">
                    <p><?php echo $user->getFirstName()." ".$user->getLastName(); ?></p>
                </div>
            </div>
            <!-- Sidebar Menu-->
            <ul class="sidebar-menu">
                <?php echo $sideBar; ?>
            </ul>
        </section>
    </aside>
    <div class="content-wrapper">
        <div class="page-title hidden-print">
            <div >
                <h1><i class="fa fa-file-text-o"></i> Sale</h1>
                <p>Stock release document</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <section class="invoice">
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header"><i class="fa fa-globe"></i> Kalum Timber World<small class="pull-right">Date:&nbsp;&nbsp;<?php echo $sale->getIssueDate(); ?></small></h2>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-xs-4">From
                                <address><strong>Kalum Timber world</strong><br>518 Akshar Avenue<br>Gandhi Marg<br>New Delhi<br>Email: hello@vali.com</address>
                            </div>
                            <div class="col-xs-4">To
                                <address><strong>John Doe</strong><br>            795 Folsom Ave, Suite 600<br>            San Francisco, CA 94107<br>            Phone: (555) 539-1037<br>            Email: john.doe@example.com</address>
                            </div>
                            <div class="col-xs-4"><b>Pass #<?php echo $sale->getIssueId(); ?></b></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Timber type</th>
                                        <th>Stock No</th>
                                        <th>Bundle No</th>
                                        <th>Dimension</th>
                                        <th>Piece Length</th>
                                        <th>Number of pieces</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $table = "";
                                    $i = 1;
                                    foreach (array_keys($sale->getPieces()) as $key){
                                        $pcs = $sale->getPieces()[$key];
                                        if($pcs[0][4]==0){
                                            $up = 0;
                                        }else{
                                            $up = $pcs[0][5]/($pcs[0][3]*$pcs[0][4]);
                                        }
                                        $table = $table."<tr><td rowspan='".strval(sizeof($pcs))."'>".strval($i)."</td><td rowspan='".strval(sizeof($pcs))."'>".$pcs[0][0]."</td><td rowspan='".strval(sizeof($pcs))."'>".$key."</td><td rowspan='".strval(sizeof($pcs))."'>".$pcs[0][6]."</td><td rowspan='".strval(sizeof($pcs))."'>".$pcs[0][1]."X".$pcs[0][2]."</td><td >".strval($pcs[0][3])."</td><td >".number_format($pcs[0][4])."</td></tr>";
                                        for ($k=1;$k<sizeof($pcs);$k++){
                                            if($pcs[$k][4]==0){
                                                $up = 0;
                                            }else{
                                                $up = $pcs[$k][5]/($pcs[$k][3]*$pcs[$k][4]);
                                            }
                                            $table = $table."<tr><td>".strval($pcs[$k][3])."</td><td>".number_format($pcs[$k][4])."</td></tr>";
                                        }
                                        $i++;
                                    }
                                    echo $table;
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row invoice-info">
                            <div class="col-xs-4"></div>
                            <div class="col-xs-3"></div>

                        </div>
                        <div class="row hidden-print mt-20">
                            <div class="col-xs-12 text-right"><a class="btn btn-primary" href="javascript:window.print();" target="_blank"><i class="fa fa-print"></i> Print</a></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Javascripts-->
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/pace.min.js"></script>
<script src="js/main.js"></script>
<script type="text/javascript">$('body').removeClass("sidebar-mini").addClass("sidebar-collapse");</script>
<script type="text/javascript">
    function getReleaseDoc() {
        window.location.href = "stockReleaseDocument.php?id="+document.getElementById("issueId").value;
    }
</script>
</body>
</html>