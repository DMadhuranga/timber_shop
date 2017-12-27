<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/26/2017
 * Time: 5:20 PM
 */
include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
include_once("assests/common/sale_support/sale_support.php");
$sideBar = authenticate($dbh,array("1","0","2"),$_SERVER['REQUEST_URI']);
$user = unserialize($_SESSION["user"]);
$timber_types = getTimberTypes($dbh);
if($timber_types==-1){
    die("Connection error");
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
    <link rel="stylesheet" type="text/css" href="assests/library/sweetAlert2/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="assests/library/loader/src/loading.css">
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
        <div class="page-title">
            <div>
                <h1><i class="fa fa-usd"></i>&nbsp; Sale</h1>
                <p>New sale</p>
            </div>
        </div>
        <!-- Page content





        -->
        <div class="card">
            <h3 class="card-title">Timber</h3>
            <div class="card-body3">
                <form>
                    <div class="form-group">
                        <label class="control-label">Timber Type</label>
                        <select class="form-control" id="timberTypes">
                            <option disabled="" selected="" value="-1">Select Timber Type</option>
                            <?php
                                foreach ($timber_types as $item){
                                    echo "<option value='".$item[0]."'>".$item[1]."</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary icon-btn" type="button" onclick="loadAvailableTimber()"><i class="fa fa-fw fa-lg fa-search"></i>Search</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <table hidden="">
                <thead>

                </thead>
            </table>
            <div class="col-sm-12">
                <div class="card">
                    <h3 class="card-title">Bundles</h3>
                    <div class="card-body" id="resultDiv"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <h3 class="card-title">Cart</h3>
                    <div class="card-body" id="cartDiv">
                        <table class="table table-hover" id="cartTable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Stock No</th>
                                <th>Dimension</th>
                                <th>Piece Length</th>
                                <th>Piece Count</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>0009</td>
                                <td>2.00X4.00</td>
                                <td>12<br>13</td>
                                <td><input type='text' value=''><input type='text' value=''></td>
                                <td><input type='text' value=''><input type='text' value=''></td>
                                <td><input type='text' value=""><input type='text' value=''></td>
                            </tr>
                            </tbody>
                        </table>
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
<script type="text/javascript" src="assests/library/sweetAlert2/sweetalert2.min.js"></script>
<script type="text/javascript" src="assests/library/loader/src/jquery.loading.js"></script>
<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    function loadAvailableTimber(){
        timberType = document.getElementById("timberTypes").value;
        if(timberType==-1){
            swal({
                title:'Please select a timber type',
                text:'',
                type:'info',
                confirmButtonColor:'#009688'
            });
        }else{
            loadTimbers(timberType);
        }
    }
    function loadTimbers(timberType){
        $.showLoading({
            name : "line-pulse"
        });
        $.ajax({
            url : "assests/common/sale_support/sale_ajax.php",
            type : "POST",
            timeout : 3000,
            async : "false",
            data : {
                "timberAvailableData" : true,
                "timberType" : timberType
            },
            success : function(data){
                if(data=="error" || data=="Connection error"){
                    $.hideLoading();
                    document.getElementById("resultDiv").innerHTML = "<div class='alert alert-danger' role='alert'>Database connection failed</div>";
                }else if(data=="empty"){
                    $.hideLoading();
                    document.getElementById("resultDiv").innerHTML = "<div class='alert alert-success' role='alert'>No available stock</div>";
                }else{
                    $.hideLoading();
                    document.getElementById("resultDiv").innerHTML = data;
                    $('#resultTable').DataTable();
                }
            },
            error : function(a,b,c) {
                $.hideLoading();
                swal({
                    title:'Failed!',
                    text:'Network failure',
                    type:'error',
                    confirmButtonColor:'#009688'
                });
            }
        });
    }

    function addThisBundle(me) {
        cels = me.cells;
        stockNo = cels[0].innerHTML;
        dimension = cels[4].innerHTML;
        unitPrice = cels[5].innerHTML;
        pieceLengths = cels[6].innerHTML.split("<br>");
        pieceCounts = cels[7].innerHTML.split("<br>");
        if(isBundleAdded(stockNo)){
            swal({
                title:'Already added',
                text:'Bundle is already added',
                type:'info',
                confirmButtonColor:'#009688'
            });
        }else{
            alert(getRowNumber());
            cartTable = document.getElementById("cartTable");
            var newRow = cartTable.insertRow(cartTable.rows.length);
            str = "<td rowspan='"+pieceCounts.length+"'>"+String(cartTable.rows.length-1)+"</td><td rowspan='"+pieceCounts.length+"'>"+
                stockNo+"</td><td rowspan='"+pieceCounts.length+"'>"+dimension+"</td><td>"+pieceLengths[0]+"</td><td><input type='text' value='"+pieceCounts[0]+"'></td><td><input type='text' value='"+unitPrice+"'></td><td><input type='text'></td>";
            newRow.innerHTML = str;
            for(i=1;i<pieceCounts.length;i++){
                cartTable.insertRow(cartTable.rows.length).innerHTML = "<td>"+pieceLengths[i]+"</td><td><input type='text' value='"+pieceCounts[i]+"'></td><td><input type='text' value='"+unitPrice+"'></td><td><input type='text'></td>";
            }
        }
    }

    function isBundleAdded(stockNo){
        cartTable = document.getElementById("cartTable").rows;
        for(i=1;i<cartTable.length;i++){
            if(cartTable[i].cells[1].innerHTML==stockNo){
                return true;
            }
        }
        return false;
    }

    function getRowNumber() {
        num = 0;
        cartTable = document.getElementById("cartTable").rows;
        for(i=0;i<cartTable.length;i++){
            if(cartTable[i].cells[1].innerHTML!=""){
                alert(cartTable[i].cells[1].innerHTML);
            }
        }
        return num;
    }
</script>
</body>
</html>