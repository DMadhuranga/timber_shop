<?php
/**
 * Created by PhpStorm.
 * User: AVARM
 * Date: 12/22/2017
 * Time: 7:08 AM
 */

include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
include_once("assests/common/classes/Timber.php");
include_once("assests/common/timberSupport/timber_support.php");
$timberSizes=getTimberSizes($dbh);
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
                <h1><i class="fa fa-cube"></i> Timber Sizes</h1>
                <p>View and add timber sizes</p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-title-w-btn">
                    <h3 class="title">Timber Sizes</h3>
                    <p><a class="btn btn-primary icon-btn" onclick="addNew()"><i class="fa fa-plus"></i>Add New Size	</a></p>

                </div>
                <div class="card-body">

                    <table class="table table-hover" id="sampleTable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Dimensions (thickness x width) </th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $num=1;
                        $td='';
                        foreach ($timberSizes as $size){
                            $td=$td.'<tr style="cursor: pointer;" onclick="rowClick(this)" id="'.$size->getCrossSecId().'~~'.$size->getThickness().'~~'.$size->getWidth().'"><td>'.$num.'</td><td>'.$size->getThickness()."\tX\t".$size->getWidth().'</td></tr>';
                            $num++;
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

<script type="text/javascript">

    function rowClick(timber) {
        var inf=timber.id;
        inf=inf.split("~~");
        var sizeId=inf[0];
        var thickness=inf[1];
        var width=inf[2];
        swal({
            title: thickness+'" X '+width+'"',
            type: 'info',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: '<i class="fa fa-pencil-square-o "></i> '+'Edit size',
            cancelButtonText: '<i class="fa fa-trash-o "></i> '+ 'Delete',
            confirmButtonColor:'#009688',
            cancelButtonColor:'#6d6d6d'
        }).then (function () {
        swal({
            title: 'Enter Timber Size',
            html:
            'Thickness '+'<input type="number" step="0.25" id="swal-input1"  class="swal2-input" value='+thickness+' >' +'<br>'+'Width '+
            '<input type="number" step="0.25" id="swal-input2" class="swal2-input" value='+width+' >',
            showCancelButton: true,
            confirmButtonColor:'#009688',
            cancelButtonColor:'#6d6d6d',
            preConfirm: function () {
                return new Promise(function (resolve,reject) {
                    if ($('#swal-input1').val() ==="" || $('#swal-input1').val() <=0) {
                        reject("Invalid input for timber thickness")
                    }
                    if ($('#swal-input2').val() <=0 || $('#swal-input2').val() <=0) {
                        reject("Invalid input for timber width")
                    }
                    else if (($('#swal-input1').val() === thickness) && ($('#swal-input2').val() === width) ) {
                        reject("No difference in size detected!")
                    }
                    else {
                        resolve([
                            $('#swal-input1').val(),
                            $('#swal-input2').val()
                        ])
                    }
                })
            },
            onOpen: function () {
                $('#swal-input1').focus()

            }
        }).then(function (result) {
            //swal(JSON.stringify(result))
            changeSize(sizeId,result[0],result[1]);

        }).catch(swal.noop)
    },function (dismiss) {
            if (dismiss === 'cancel') {
                swal({
                    title: 'Are you sure?',
                    text: thickness+" X "+width+" will be removed from timber sizes!" ,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F44336',
                    cancelButtonColor: '#6d6d6d',
                    confirmButtonText: 'Yes, Delete it!'
                }).then(function () {
                    deleteSize(sizeId);
                })
            }
        })
    }


    function changeSize(cross_sec_id,thickness,width){
        $.ajax({
            url: "assests/common/timberSupport/timber_ajax.php",
            type: "POST",
            timeout: 3000,
            async: false,
            data: {
                "changeTimberSize": true,
                "id": cross_sec_id,
                "thickness":thickness,
                "width":width
            },
            success: function (data) {
                if (data==="1"){
                    swal({
                        title:'Done!',
                        type:'success',
                        text:'Timber size successfully changed.',
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


    function deleteSize(id) {
        $.ajax({
            url: "assests/common/timberSupport/timber_ajax.php",
            type: "POST",
            timeout: 3000,
            async: false,
            data: {
                "deleteTimberSize": true,
                "id": id,

            },
            success: function (data) {
                if (data==="1"){
                    swal({
                            title: 'Please Wait!',
                            text: 'Updating changes',
                            timer: 1500,
                            onOpen: () => {
                            swal.showLoading()
                }

                })

                    window.location.reload();


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
                })
                ;
            }

        });
    }



    function addNew() {
        swal({
            title: 'Enter Timber Size',
            html:
            'Thickness '+'<input type="number" step="0.25" id="swal-input1"  class="swal2-input" value=0 >' +'<br>'+'Width '+
            '<input type="number" step="0.25" id="swal-input2" class="swal2-input" value=0 >',
            showCancelButton: true,
            confirmButtonColor:'#009688',
            cancelButtonColor:'#6d6d6d',
            preConfirm: function () {
                return new Promise(function (resolve,reject) {
                    if ($('#swal-input1').val() ==="" || $('#swal-input1').val() <=0) {
                        reject("Invalid input for timber thickness")
                    }
                    if ($('#swal-input2').val() <=0 || $('#swal-input2').val() <=0) {
                        reject("Invalid input for timber width")
                    }
                    else {
                        resolve([
                            $('#swal-input1').val(),
                            $('#swal-input2').val()
                        ])
                    }
                })
            },
            onOpen: function () {
                $('#swal-input1').focus()

            }
        })
            .then(function (result) {
                add(result[0],result[1]);
            })
    }


    function add(thickness,width) {
        $.ajax({
            url: "assests/common/timberSupport/timber_ajax.php",
            type: "POST",
            timeout: 3000,
            async: false,
            data: {
                "addNewTimberSize": true,
                "thickness": thickness,
                "width":width

            },
            success: function (data) {
                if(data==='0'){
                    swal({
                        title:'Oops...',
                        text:'Timber size already exists!',
                        type:'error',
                        confirmButtonColor:'#009688'
                    })
                }
                else if (data==='1'){
                    swal({
                            title: 'Please Wait!',
                            text: 'Updating changes',
                            timer: 1500,
                            onOpen: () => {
                            swal.showLoading()
                }

                })

                    window.location.reload();


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



    //}
</script>
</body>
</html>