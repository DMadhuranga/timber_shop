<?php
/**
 * Created by PhpStorm.
 * User: AVARM
 * Date: 12/26/2017
 * Time: 8:22 PM
 */

include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
include_once("assests/common/classes/Timber.php");
include_once("assests/common/timberSupport/timber_support.php");
$timberSizes=getTimberSizes($dbh);
$timberTypes=getTimberTypes($dbh);
$sideBar = authenticate($dbh,array("1","0","2"),$_SERVER['REQUEST_URI']);
$user = unserialize($_SESSION["user"]);
$remarks=$_REQUEST["remarks"];
$buyer_id=$_REQUEST["buyer"];
$shipment=$_REQUEST["shipment"];
$invoice=$_REQUEST["invoice"];
$date=$_REQUEST["date"];
$vessel=$_REQUEST["vessel"];

$stockNumber=getNextStockNumber($dbh);

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
                <h1><i class="fa fa-ship"></i><?php echo " ".$shipment." ~~ ".$date?></h1>
                <p>New Shipment</p>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-title">Timber Details</h3>
                <div class="card-body">
                    <div class="well bs-component">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="control-label col-md-2">Bundle number</label>
                                <div class="col-md-3">
                                    <input class="form-control" type="text" placeholder="Enter bundle number" id="bundle">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">Stock number</label>
                                <div class="col-md-3">
                                    <input class="form-control" type="text" placeholder="Enter stock number" id="stock" value="<?php echo $stockNumber?>" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="well bs-component">
                        <div class="form-group">
                            <div class="form-group">
                                <label class="control-label col-md-2">Timber Type</label>
                                <div class="col-md-3">
                                    <select class="form-control" id="timberSelect">
                                        <optgroup >
                                            <option selected="selected" disabled="disabled" >Select Type</option>
                                            <?php foreach ($timberTypes as $timberType) {
                                                    echo '<option value="'.$timberType->getTypeId().'~~~'.$timberType->getTimberName().'" >'.$timberType->getTimberName().'</option>';
                                                }?>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2">Cross Section</label>
                            <div class="col-md-3">
                                <select class="form-control" id="sizeSelect">
                                    <optgroup >
                                        <option selected="selected" disabled="disabled">Select Size</option>
                                        <?php foreach ($timberSizes as $timberSize) {
                                            echo '<option value="'.$timberSize->getCrossSecId().'~~~'.$timberSize->getThickness().'~~~'.$timberSize->getWidth().'" >'.$timberSize->getThickness().'" X '.$timberSize->getWidth().'"</option>';
                                        }?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="well bs-component">
                        <div class="form-group">

                            <div class="form-group">
                                <label class="control-label col-md-2">Length</label>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" placeholder="Enter timber lenth" id="length">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2">PCS</label>
                                <div class="col-md-3">
                                    <input class="form-control" type="number" placeholder="Enter number of pieces" id="count">
                                </div>
                            </div>



                        </div>
                    </div>

                </div>
                <br><br>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-2">
                            <button class="btn btn-primary icon-btn" type="button" onclick="addTimber()"><i class="fa fa-fw fa-lg fa-plus-circle"></i>Add</button>
                        </div>
                        <!--<div class="col-lg-4">
                            <div class="bs-component">
                                <div class="alert alert-dismissible alert-danger">
                                    <button class="close" type="button" data-dismiss="alert">×</button><strong>Oh snap!</strong><a class="alert-link" href="#">Change a few things up</a> and try submitting again.
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-title-w-btn">
                <h3 class="card-title">Timber List</h3>
                    <p><button class="btn btn-primary icon-btn" type="button" onclick="addShipment()"><i class="fa fa-fw fa-lg fa-check-circle"></i>Finish</button></p>
                </div>
                <table class="table table-striped" id="timberCart">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Bundle Number</th>
                        <th>Stock Number</th>
                        <th>Timber Type</th>
                        <th>Cross Section</th>
                        <th>Length</th>
                        <th>Pieces</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
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
        $('#timberSelect').select2();
        $('#sizeSelect').select2();

    });

    $('#demoDate').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });


</script>

<script type="text/javascript">
    function addTimber() {
        var bundle=document.getElementById("bundle").value;
        var stock=document.getElementById("stock").value;
        var type=document.getElementById("timberSelect").value.split("~~~")[1];
        var size=document.getElementById("sizeSelect").value.split("~~~")[1]+'" X '+document.getElementById("sizeSelect").value.split("~~~")[2]+'"';
        var length=document.getElementById("length").value;
        var count=document.getElementById("count").value;

        if (bundle===''){
            error('bundle number');
        }
        else if(stock===''){
            error('stock number');
        }
        else if(type==='' || type===undefined){
            error('timber type');
        }
        else if(size==='' ||size==='undefined" X undefined"'){
            error('timber size');
        }
        else if(length==='' || length<=0){
            error('length');
        }
        else if(count==='' || count<=0){
            error('PCS');
        }
        else {

            var table = document.getElementById("timberCart");
            var rows = table.rows.length - 1;
            var row = table.insertRow();
            row.insertCell(0).innerHTML = rows + 1;
            row.insertCell(1).innerHTML = bundle;
            row.insertCell(2).innerHTML = stock;
            row.insertCell(3).innerHTML = type;
            row.insertCell(4).innerHTML = size;
            row.insertCell(5).innerHTML = length;
            row.insertCell(6).innerHTML = count;
            rows = rows + 1;
            row.insertCell(7).innerHTML = '<a class="btn btn-default" onclick="remove(this)" >Remove';
            document.getElementById("bundle").value = "";
            document.getElementById("length").value = "";
            document.getElementById("count").value = "";

            document.getElementById("stock").value = parseInt(stock) + 1;


            $('#timberSelect').val(null).trigger('change');
            $('#sizeSelect').val(null).trigger('change');
        }

    }


    function remove(id) {
        document.getElementById("timberCart").deleteRow(id.parentNode.parentNode.rowIndex);
    }

    function addShipment() {
        var oTable=document.getElementById("timberCart");

        var rowLength = oTable.rows.length;

        for (i = 1; i < rowLength; i++){
             var oCells = oTable.rows.item(i).cells;
            var cellLength = oCells.length-1;

            for(var j = 1; j < cellLength; j++){
                var cellVal = oCells.item(j).innerHTML;
                alert(cellVal);
            }
        }

    }

    function error(name) {
        swal({
            position: 'top-left',
            type: 'error',
            title: 'Please complete '+name,
            showConfirmButton: false,
            timer: 2500
        })
    }

    /*function finish() {
        $.ajax({
            url: "assests/common/timberSupport/timber_ajax.php",
            type: "POST",
            timeout: 3000,
            async: false,
            data: {
                "addShipment": true,
                "name": name
                row.insertCell(1).innerHTML = bundle;
        row.insertCell(2).innerHTML = stock;
        row.insertCell(3).innerHTML = type;
        row.insertCell(4).innerHTML = size;
        row.insertCell(5).innerHTML = length;
        row.insertCell(6).innerHTML = count;
        $remarks=$_REQUEST["remarks"];
        $buyer_id=$_REQUEST["buyer"];
        $shipment=$_REQUEST["shipment"];
        $invoice=$_REQUEST["invoice"];
        $date=$_REQUEST["date"];
        $vessel=$_REQUEST["vessel"];
            },
            success: function (data) {
                if(data==='0'){
                    swal({
                        title:'Oops...',
                        text:'Timber type already exists!',
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
    }*/

</script>


</body>
</html>