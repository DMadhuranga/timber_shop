<?php
/**
 * Created by PhpStorm.
 * User: AVARM
 * Date: 12/23/2017
 * Time: 3:28 PM
 */

include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
include_once("assests/common/classes/Timber.php");
include_once("assests/common/timberSupport/timber_support.php");
$timberPrices=getTimberPrices($dbh);
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
    <title>Vali Admin</title>
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
                <h1><i class="fa fa-money"></i> Timber Prices</h1>
                <p>View and edit timber prices</p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">

                <div class="card-body">

                    <table class="table table-hover" id="sampleTable">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Dimensions (thickness x width) </th>
                            <th>Price </th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $td='';
                        foreach ($timberPrices as $timber){
                            $td=$td.'<tr style="cursor: pointer;" onclick="rowClick(this)" id="'.$timber->getCrossSecId().'~~'.$timber->getTypeId().'~~'.$timber->getTimberName().'~~'.$timber->getThickness().'~~'.$timber->getWidth().'~~'.$timber->getPrice().'"><td>'.$timber->getTimberName().'</td><td>'.$timber->getThickness()."\tX\t".$timber->getWidth().'</td><td>'.$timber->getPrice().'</td></tr>';
                        }
                        echo $td;
                        ?>


                        </tbody>
                    </table>
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
<script type="text/javascript" src="assests/library/sweetAlert2/sweetalert2.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">$('#sampleTable').DataTable();</script>
<script type="text/javascript">

    function rowClick(timber) {
        var info=timber.id;
        info=info.split("~~");
        var sizeId=info[0];
        var typeId=info[1];
        var name=info[2];
        var thickness=info[3];
        var width=info[4];
        var price=info[5];
        swal({
            title:name,
            text: thickness+'" X '+width+'"',
            type: 'info',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="fa fa-pencil-square-o "></i> '+'Change price',
            cancelButtonText: 'Cancel',
            confirmButtonColor:'#009688',
            cancelButtonColor:'#6d6d6d'
        }).then (function () {

            swal({
                title: 'Enter Timber Price',
                input: 'number',
                inputValue: price,
                showCancelButton: true,
                confirmButtonColor:'#009688',
                cancelButtonColor:'#6d6d6d',
                preConfirm: function (value) {
                    return new Promise(function (resolve, reject) {
                        if (value === '' || value<=0) {
                            reject("Please enter a valid price")
                        }
                        else if (value ===price){
                            reject("No difference in price detected!")
                        }
                        else {
                            resolve()
                        }
                    })
                }
            })
                .then(function (newPrice) {
                    changePrice(typeId,sizeId,newPrice,price);

                })
        })
    }


    function changePrice(type_id,cross_sec_id,newPrice,oldPrice){
        $.ajax({
            url: "assests/common/timberSupport/timber_ajax.php",
            type: "POST",
            timeout: 3000,
            async: false,
            data: {
                "changeTimberPrice": true,
                "typeId":type_id,
                "sizeId": cross_sec_id,
                "price":newPrice,
                "oldPrice":oldPrice
            },
            success: function (data) {
                if (data==="1"){
                    swal({
                        title:'Done!',
                        type:'success',
                        text:'Timber price successfully changed.',
                        confirmButtonColor:'#009688'
                    }).then(function () {
                        swal({
                                title: 'Please Wait!',
                                text: 'Updating changes',
                                timer: 1500,
                                onOpen: () => {
                                swal.showLoading()
                    }
                    })
                    }).then(function () {
                        window.location.reload();
                    });

                }
                else{
                    swal({
                        title:'Connection Error',
                        text:'',
                        type:'error',
                        confirmButtonColor:'#009688'
                    });
                }
            },
            error: function () {
                swal({
                    title:'Connection Error',
                    text:'',
                    type:'error',
                    confirmButtonColor:'#009688'
                });
            }
        });
    }


</script>
</body>
</html>