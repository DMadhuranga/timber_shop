<?php
/**
 * Created by PhpStorm.
 * User: AVARM
 * Date: 12/26/2017
 * Time: 6:06 PM
 */

include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
include_once("assests/common/classes/Timber.php");
include_once("assests/common/basic_support.php");
$buyers=getBuyer($dbh);
//echo "<script type='text/javascript'>alert('$c');</script>";
$sideBar = authenticate($dbh,array("1","0","2"),$_SERVER['REQUEST_URI']);
$user = unserialize($_SESSION["user"]);
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

    <link rel="stylesheet" type="text/css" href="assests/library/sweetAlert2/sweetalert2.min.css">
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
                <h1><i class="fa fa-ship"></i> Timber Arrival</h1>
                <p>Add timber stocks</p>
            </div>
        </div>
        <div class="col-md-12">


            <div class="card" id="done">
                <h3 class="card-title">Shipment Details</h3>
                <div class="card-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-md-2">Shipment Name<span style="color:red;">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" placeholder="Enter shipment name" id="ship">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Buyer Name<span style="color:red;">*</span></label>
                            <div class="col-md-8">
                                <select class="form-control" id="buyerSelect">
                                    <optgroup >
                                        <option selected="selected" disabled="disabled">Select Buyer</option>
                                        <?php foreach ($buyers as $buyer) {
                                            echo '<option value="'.$buyer->getUserId().'~~~'.$buyer->getAddress().'" >'.$buyer->getFirstName().'</option>';
                                        }?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Buyer Address<span style="color:red;">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" placeholder="Buyer address" id="buyerAddress">
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="control-label col-md-2">GST number</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" placeholder="Enter GST number">
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="control-label col-md-2">Invoice number<span style="color:red;">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" placeholder="Enter invoice number" id="invoice">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Date<span style="color:red;">*</span></label>
                            <div class="col-md-8">
                                <input class="form-control" id="demoDate" type="text" placeholder="Select Date">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Vessel</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" placeholder="Enter vessel name" id="vessel">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Remarks</label>
                            <div class="col-md-8">
                                <textarea class="form-control" rows="4" id="remarks"></textarea>
                            </div>
                        </div>


                    </form>
                </div>

                <div class="bs-component" id="warning-msg" hidden="">
                    <div class="alert alert-dismissible alert-warning">
                        <button class="close" type="button" data-dismiss="alert" hidden="">×</button>
                        <h4>Warning!</h4>
                        <p><a class="alert-link" >Incomplete input!    </a>  Please fill fields with <span style="color:red;">*</span> mark</p>
                    </div>
                </div>


                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-5">
                            <button class="btn btn-primary icon-btn" type="button" onclick="next()"><i class="fa fa-arrow-circle-right"></i>Next</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn" onclick="location.reload()"><i class="fa fa-fw fa-lg fa-times-circle"></i>Reset</a>
                        </div>
                    </div>
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
<script type="text/javascript" src="js/plugins/select2.min.js"></script>
<script type="text/javascript" src="assests/library/sweetAlert2/sweetalert2.min.js"></script>
<script type="text/javascript" src="js/plugins/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#buyerSelect').select2();
    });

    $('#demoDate').datepicker({
        format: "yyyy/mm/dd",
        autoclose: true,
        todayHighlight: true
    });
</script>

<script type="text/javascript">

    document.getElementById("buyerSelect").onchange = function(){
        var e = document.getElementById("buyerSelect");
        var add=e.value.split("~~~");
        document.getElementById("buyerAddress").value=add[1];
    };

    function next() {
        var e = document.getElementById("buyerSelect");
        var add=e.value.split("~~~");
        var ship = document.getElementById("ship").value;
        var invoice = document.getElementById("invoice").value;
        var date = document.getElementById("demoDate").value;
        var vessel = document.getElementById("vessel").value;
        var remarks = document.getElementById("remarks").value;


        if (ship==='' || invoice==='' || add[0]==="Select Buyer"|| date===""){
            document.getElementById("warning-msg").style.display = "block";
        }
        else{
            window.location.href="acceptTimberDetails.php?buyer="+add[0]+"&shipment="+ship+"&invoice="+invoice+"&date="+date+"&vessel="+vessel+"&remarks="+remarks;
        }
        //alert(ship+"*"+add[0]+"*"+"*"+invoice+"*"+date+"*"+vessel+"*"+remarks);
        //window.location.href="acceptTimberDetails.php?buyer="+add[0]+"&shipment="+ship+"&invoice="+invoice+"&date="+date+"&vessel="+vessel+"&remarks="+remarks;
    }
</script>

</body>
</html>