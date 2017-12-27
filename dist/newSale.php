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
                        <form class="form-inline">
                            <div class="form-group">
                                <label class="control-label">Total : 12205.65 &nbsp;&nbsp;&nbsp;&nbsp;</label>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Discount :&nbsp;</label>
                                <input id="discountInp" type="text" placeholder="">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="form-group">
                                <label class="control-label">Final : 12205.65 &nbsp;&nbsp;&nbsp;&nbsp;</label>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary icon-btn" type="button"><i class="fa fa-fw fa-lg fa-check-circle"></i>Finish</button>
                            </div>
                            <br>&nbsp;<br>&nbsp;<br>
                        </form>
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
            num = getRowNumber();
            cartTable = document.getElementById("cartTable");
            var newRow = cartTable.insertRow(cartTable.rows.length);
            if(unitPrice==""){
                unitPrice = "0.00";
            }
            str = "<td rowspan='"+pieceCounts.length+"'>"+String(num)+"</td><td rowspan='"+pieceCounts.length+"'>"+
                stockNo+"</td><td rowspan='"+pieceCounts.length+"'>"+dimension+"</td><td id='"+stockNo+"#pl0"+"'>"+pieceLengths[0]+"</td><td><input id='"+stockNo+"#pc0"+"' data-maxCount='"+pieceCounts[0]+"' type='text' value='"+pieceCounts[0]+"' onchange='checkCount(this)'></td><td><input id='"+stockNo+"#up0"+"' onchange='changeUnitPrice(this)' data-original='"+unitPrice+"' type='text' value='"+unitPrice+"'></td><td><input onchange='checkTotalPrice(this)' id='"+stockNo+"#tp0"+"' type='text' value='"+parseFloat(String(parseInt(pieceLengths[0])*parseInt(pieceCounts[0])*parseFloat(unitPrice))).toFixed(2)+"'></td><td rowspan='"+pieceCounts.length+"'><a data-stockNo='"+stockNo+"' class='btn btn-default' onclick='remove(this)' >Remove</a></td>";
            newRow.innerHTML = str;
            for(i=1;i<pieceCounts.length;i++){
                cartTable.insertRow(cartTable.rows.length).innerHTML = "<td id='"+stockNo+"#pl"+String(i)+"'>"+pieceLengths[i]+"</td><td><input id='"+stockNo+"#pc"+String(i)+"' data-maxCount='"+pieceCounts[i]+"' type='text' value='"+pieceCounts[i]+"' onchange='checkCount(this)'></td><td><input id='"+stockNo+"#up"+String(i)+"' onchange='changeUnitPrice(this)' data-original='"+unitPrice+"' type='text' value='"+unitPrice+"'></td><td><input onchange='checkTotalPrice(this)' id='"+stockNo+"#tp"+String(i)+"' type='text' value='"+parseFloat(String(parseInt(pieceLengths[i])*parseInt(pieceCounts[i])*parseFloat(unitPrice))).toFixed(2)+"'></td>";
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
            if(cartTable[i].cells.length==8){
                num++;
            }
        }
        return num;
    }

    function checkCount(me){
        newCount = me.value;
        maxCount = me.getAttribute("data-maxCount");
        if(isNaN(newCount) || (newCount % 1 != 0) || (newCount<0)){
            me.value = maxCount;
            swal({
                title:'Invalid count!',
                text:'',
                type:'info',
                confirmButtonColor:'#009688'
            });
            checkCount(me)
        }else if(newCount>maxCount){
            swal({
                title:'Invalid count!',
                text:'Input number of pieces is larger than available',
                type:'info',
                confirmButtonColor:'#009688'
            });
            me.value = maxCount;
            checkCount(me)
        }else{
            stockNo = me.id.substr(0,me.id.length-3);
            pieceLength = parseInt(document.getElementById(stockNo+"pl"+me.id.substr(-1)).innerHTML);
            price = document.getElementById(stockNo+"up"+me.id.substr(-1)).value;
            document.getElementById(stockNo+"tp"+me.id.substr(-1)).value = parseFloat(String(pieceLength*newCount*price)).toFixed(2);
        }

    }

    function changeUnitPrice(me){
        price = me.value;
        if(isNaN(price) || (price<0)){
            swal({
                title:'Invalid price!',
                text:'',
                type:'info',
                confirmButtonColor:'#009688'
            });
            me.value = me.getAttribute("data-original");
            changeUnitPrice(me)
        }else{
            me.value = parseFloat(String(price)).toFixed(2);
            price = me.value;
            stockNo = me.id.substr(0,me.id.length-3);
            pieceLength = parseInt(document.getElementById(stockNo+"pl"+me.id.substr(-1)).innerHTML);
            pieceCount = document.getElementById(stockNo+"pc"+me.id.substr(-1)).value;
            document.getElementById(stockNo+"tp"+me.id.substr(-1)).value = parseFloat(String(pieceLength*pieceCount*price)).toFixed(2);
        }
    }
    function getCellRow(me){
        table = document.getElementById("cartDiv").rows;
        for(i=0;i<table.length;i++){
            for(j=0;j<table[i].cells.length;j++){
                if(me.id==table[i].cells[j].id){
                    return table[i];
                }
            }
        }
    }

    function remove(me){
        stockNo = me.getAttribute("data-stockNo");
        table = document.getElementById("cartTable").rows;
        for(i=0;i<table.length;i++){
            if(table[i].cells[1].innerHTML==stockNo){
                document.getElementById("cartTable").deleteRow(i);
                while(table[i].cells.length!=8){
                    document.getElementById("cartTable").deleteRow(i);
                }
                orderTable();
            }
        }
    }

    function orderTable(){
        table = document.getElementById("cartTable").rows;
        cnt = 1;
        for(i=1;i<table.length;i++){
            if(table[i].cells.length==8){
                table[i].cells[0].innerHTML = cnt;
                cnt++;
            }
        }
    }

    function checkTotalPrice(me){
        totalPrice = me.value;
        stockNo = me.id.substr(0,me.id.length-3);
        pieceLength = parseInt(document.getElementById(stockNo+"pl"+me.id.substr(-1)).innerHTML);
        priceCount = document.getElementById(stockNo+"pc"+me.id.substr(-1)).value;
        if(isNaN(totalPrice) || (totalPrice<0)){
            swal({
                title:'Invalid price!',
                text:'',
                type:'info',
                confirmButtonColor:'#009688'
            });
            price = document.getElementById(stockNo+"up"+me.id.substr(-1)).value;
            me.value = parseFloat(String(pieceLength*priceCount*price)).toFixed(2);
        }else if(parseInt(priceCount)==0 && parseFloat(String(totalPrice)).toFixed(2)!=0.00){
            swal({
                title:'Invalid price!',
                text:'Piece count is zero',
                type:'info',
                confirmButtonColor:'#009688'
            });
            me.value = "0.00";
        }else if(parseInt(priceCount)==0){
            me.value = "0.00";
        }else{
            totalPrice = parseFloat(String(totalPrice)).toFixed(2);
            me.value = totalPrice;
            document.getElementById(stockNo+"up"+me.id.substr(-1)).value = parseFloat(String(totalPrice/(priceCount*pieceLength))).toFixed(2);
        }
    }
</script>
</body>
</html>