<?php
/**
 * Created by PhpStorm.
 * User: AVARM
 * Date: 1/6/2018
 * Time: 4:51 PM
 */


include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
include_once("assests/common/classes/Shipment.php");
include_once("assests/common/classes/TimberBundle.php");
include_once("assests/common/timberSupport/timber_support.php");
$sideBar = authenticate($dbh,array("1","0","2"),$_SERVER['REQUEST_URI']);
$user = unserialize($_SESSION["user"]);
$id=$_REQUEST['id'];
$shipment=getShipmentById($dbh,$id);
if ($shipment=='0' || $shipment=='-1'){
    header("Location:viewPurchase.php?");
}

$bundles=getBundles($dbh,$id);
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

        <!-- Page content -->
        <div class="page-title">
            <div>
                <h1><i class="fa fa-cart-arrow-down"></i> Timber Purchases</h1>
                <p>View timber purchases</p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <h3><?php echo $shipment->getShipmentName()." ~ ".$shipment->getArrivalDate()?></h3>
                Invoice Number : <?php echo $shipment->getInvoiceNo();?><br>
                Vessel : <?php echo $shipment->getVessel();?><br>
                Buyer : <?php echo getBuyerByID($dbh,$shipment->getBuyerId())?><br>
                Remarks : <?php echo $shipment->getRemarks()?>
            </div>

            <div class="col-lg-12" id="emptyMsg" hidden="hidden">
                <div class="bs-component">
                    <div class="alert alert-dismissible alert-danger">
                        <button class="close" type="button" data-dismiss="alert">×</button><strong>This shipment has no data available</strong>
                    </div>
                </div>
            </div>


            <div class="card" id="card2" >
                <div class="card-body" id="bundlesTable" hidden="hidden" >

                <table class="table table-hover" id="timberStocks">
                    <thead>
                    <tr>
                        <th>Stock Number</th>
                        <th>Bundle Number</th>
                        <th>Type </th>
                        <th>Cross Section </th>
                        <th>Length </th>
                        <th>Quantity </th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php

                    $td='';
                    foreach ($bundles as $bundle){
                        $td=$td.'<tr style="cursor: pointer;"><td>'.$bundle->getStockNo().'</td><td>'.
                            $bundle->getBundleNo().'</td><td>'.getTypeById($dbh,$bundle->getTypeId()).'</td><td>'.
                            getSizeById($dbh,$bundle->getCrossSectionId())[0].'" X '.
                            getSizeById($dbh,$bundle->getCrossSectionId())[1].'"'.'</td><td>'.$bundle->getLength().
                            '</td><td>'.$bundle->getCount().'</td></tr>';
                    }
                    echo $td;
                    ?>

                    </tbody>
                </table>
                </div>



            </div>

        </div>
        <?php if ($bundles==0){
            echo '<script type="text/javascript">document.getElementById("emptyMsg").style.display = "inline";   </script>';
            echo '<script type="text/javascript">document.getElementById("card2").style.display = "none";   </script>';
        }
        else{
            echo '<script type="text/javascript">document.getElementById("bundlesTable").style.display = "inline";   </script>';
        }?>

    </div>

</div>
</div>
<!-- Javascripts-->
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/pace.min.js"></script>
<script src="js/main.js"></script>
<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">$('#timberStocks').DataTable();</script>


</body>
</html>