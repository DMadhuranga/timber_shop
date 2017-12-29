<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/29/2017
 * Time: 7:03 AM
 */
include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
include_once("assests/common/classes/Sale.php");
include_once("assests/common/sale_support/sale_support.php");
$sideBar = authenticate($dbh,array("1","0","2"),$_SERVER['REQUEST_URI']);
$user = unserialize($_SESSION["user"]);
if(isset($_GET["endDate"])){
    $endDate = $_GET["endDate"];
}else{
    $endDate = date("Y-m-d");
}
if(isset($_GET["startDate"])){
    $startDate = $_GET["startDate"];
}else{
    $startDate = date('Y-m-d', strtotime($endDate.' - 7 days'));
}
$sales = getSales($dbh,$startDate,$endDate);

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
    <link rel="stylesheet" type="text/css" href="assests/library/daterangepicker/daterangepicker.css" />
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
        <div class="page-title hidden-print">
            <div >
                <h1><i class="fa fa-file-text-o"></i> Sale</h1>
                <p></p>
            </div>
        </div>
        <div class="card">
            <p class="card-title">
                <form class="form-control-static">
                    <div class="form-group">
                        <label class="control-label">Date Range</label>
                        <input name="datefilter" id="dateRange" value=""  class="form-control" type="text" placeholder="Enter date range">
                    </div>
                    <div class="form-group">
                        <button onclick="viewSales()" class="btn btn-primary icon-btn" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Show</button>
                    </div>
                </form>
            </p>
            <div class="card-body3">

                <?php echo $sales; ?>
            </div>
        </div>
        <!-- Page content





        -->
    </div>
</div>
<!-- Javascripts-->
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/pace.min.js"></script>
<script src="js/main.js"></script>
<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="assests/library/daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="assests/library/daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="assests/library/sweetAlert2/sweetalert2.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
</script>

<script type="text/javascript">
    function validDate(date) {
        if(date.length==23){
            dates = date.split("-");
            if(dates.length==6){
                if(isvaliddate(dates[0],dates[1],dates[2]) && isvaliddate(dates[3],dates[4],dates[5])){
                    return true;
                }
            }
        }
        return false;
    }
    function isvaliddate(year,month,xday) {
        if((isNaN(year) || isNaN(month)) || isNaN(xday)){
            return false;
        }else if((year<1900) || (year>2040)){
            return false;
        }else if((month>12) || (month<1)){
            return false;
        }else if((xday>31) || (xday<1)){
            return false;
        }else{
            if(((month%2==0) && (month<7)) || ((month%2==1) && (month>8))){
                if(xday>30){
                    return false;
                }
                if(month==2){
                    if(xday>29){
                        return false;
                    }
                }
                if((month==2)&&(year%4!=0)){
                    if(xday>28){
                        return false;
                    }
                }
            }
        }
        return true;
    }
    function viewSales() {
        range = document.getElementById("dateRange").value;
        if(range==""){
            error = true;
            swal({
                title:'Please select a date!',
                text:'',
                type:'info',
                confirmButtonColor:'#009688'
            });
        }else if(!validDate(range)){
            error = true;
            swal({
                title:'Date format error!',
                text:'',
                type:'info',
                confirmButtonColor:'#009688'
            });
        }else{
            start_date = Date.parse(range.split(" - ")[0]);
            end_date = Date.parse(range.split(" - ")[1]);
            if(start_date>end_date){
                swal({
                    title:'Invalid date range!',
                    text:'',
                    type:'info',
                    confirmButtonColor:'#009688'
                });
            }else{
                window.location.href="sales.php?startDate="+range.split(" - ")[0]+"&"+"endDate="+range.split(" - ")[1];
            }
        }
    }

    function viewSale(me){
        window.location.href = "viewSale.php?id="+me.id;
    }
    $(document).ready(function () {
        $(document.getElementById("saleTable")).DataTable();
    });

</script>
</body>
</html>