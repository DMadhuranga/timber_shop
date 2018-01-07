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
                            <input type="text" hidden="" id="shipmentName" value="<?php echo $shipment;?>">
                            <input type="text" hidden="" id="buyerId" value="<?php echo $buyer_id;?>">
                            <input type="text" hidden="" id="arrivalDate" value="<?php echo $date;?>">
                            <input type="text" hidden="" id="invoiceNo" value="<?php echo $invoice;?>">
                            <input type="text" hidden="" id="vessel" value="<?php echo $vessel;?>">
                            <input type="text" hidden="" id="remarks" value="<?php echo $remarks;?>">
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


                    <div class="well bs-component" id="ldiv">
                        <div class="form-group">
                            <div class="stock-list">
                                <div class=" timber-input form-group">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Length</label>
                                        <div class="col-md-3">
                                            <input class="form-control" name="length" type="number" placeholder="Enter timber lenth" id="length">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Pieces</label>
                                        <div class="col-md-3">
                                            <input class="form-control" name="pcs" type="number" placeholder="Enter number of pieces" id="count">
                                        </div>
                                    </div>

                                </div>

                            <button type="button" class="btn btn-primary icon-btn btn-add-phone"><i class="fa fa-fw fa-lg fa-plus-circle"></i> Add Length</button>
                            </div>
                        </div>
                    </div>

                </div>
                <br><br>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-2">
                            <button class="btn btn-primary icon-btn" type="button" onclick="addTimber()"><i class="fa fa-fw fa-lg fa-plus-circle"></i>Add to Timber List</button>
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
                    <p><button class="btn btn-primary icon-btn" type="button" onclick="completePurchase()"><i class="fa fa-fw fa-lg fa-check-circle"></i>Finish</button></p>
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

    $(function(){



        $(document.body).on('click', '.btn-remove-phone' ,function(){
            $(this).closest('.timber-input').remove();
        });


        $('.btn-add-phone').click(function(){

            var index = $('.timber-input').length ;

            $('.stock-list').append(''+
                '<div class=" timber-input form-group" id="addl">'+
                '<div class="form-group">'+
                '<label class="control-label col-md-2">Length</label>'+
                '<div class="col-md-3">'+
                '<input class="form-control" name="length" type="number" placeholder="Enter timber lenth" id="length">'+
                '</div>'+
                '</div>'+
                '<div class="form-group">'+
                '<label class="control-label col-md-2">Pieces</label>'+
                '<div class="col-md-3">'+
                '<input class="form-control" name="pcs" type="number" placeholder="Enter number of pieces" id="count">'+
                '</div>'+
                '<button class="btn btn-danger btn-remove-phone" type="button"><i class="fa fa-times"></i> </button>'+
                '</div>'+
                '</div>'

            );


        });

    });


</script>

<script type="text/javascript">
    var stockNo=0;


    function addTimber() {
        var bundle=document.getElementById("bundle").value;
        var stock=document.getElementById("stock").value;
        var type=document.getElementById("timberSelect").value.split("~~~")[1];
        var size=document.getElementById("sizeSelect").value.split("~~~")[1]+'" X '+document.getElementById("sizeSelect").value.split("~~~")[2]+'"';
        var length=document.getElementsByName("length")[0].value;
        var count=document.getElementsByName("pcs")[0].value;
        var index = $('.timber-input').length ;
        var err=false;
        //var idArray=new Array();

        if (bundle===''){
            error('bundle number');
            err=true;
        }
        else if(stock===''){
            error('stock number');
            err=true;
        }
        else if(validateStockNo(stock)==='-1'){
            //alert('SDF');
            swal({
                position: 'top-left',
                type: 'error',
                title: 'Stock number already exits!',
                showConfirmButton: false,
                timer: 1500
            });
            err=true;
        }
        else if(validateStockNo(stock)==='0'){
            swal({
                title:'Connection Error',
                text:'Unable to validate stock number. Please Retry',
                type:'error',
                confirmButtonColor:'#009688'
            });
            err=true;
        }
        else if(type==='' || type===undefined){
            error('timber type');
            err=true;
        }
        else if(size==='' ||size==='undefined" X undefined"'){
            error('timber size');
            err=true;
        }
        else {

            for(i=0;i<index;i++) {
                if (document.getElementsByName("length")[i].value === '' || document.getElementsByName("length")[i].value <= 0) {
                    error('length');
                    err=true;
                }
            }
            if(!err){
                for(i=0;i<index;i++) {
                    if (document.getElementsByName("pcs")[i].value === '' || document.getElementsByName("pcs")[i].value <= 0) {
                        error('piece');
                        err=true;
                    }
                }
            }

        }
        /*else if(length==='' || length<=0){
            error('length');
        }
        else if(count==='' || count<=0){
            error('PCS');
        }*/

        if(!err) {
            //alert('V'+validateStockNo(stock));
            stockNo++;
            var table = document.getElementById("timberCart");
            var rows = table.rows.length - 1;
            var row = table.insertRow();
            row.insertCell(0).innerHTML = stockNo;//rows + 1;
            row.insertCell(1).innerHTML = bundle;
            row.insertCell(2).innerHTML = stock;
            row.insertCell(3).innerHTML = type;
            row.insertCell(4).innerHTML = size;
            row.insertCell(5).innerHTML = length;
            row.insertCell(6).innerHTML = count;
            row.insertCell(7).innerHTML = '<a class="btn btn-default" onclick="remove(this)" >Remove';

            //alert('ind'+index);
            for (i = 2; i < index+1; i++){
                //alert(document.getElementsByName("length")[i-1].value);
                var nrow=table.insertRow();
                nrow.insertCell(0).innerHTML = stockNo;
                nrow.insertCell(1).innerHTML=bundle;
                nrow.insertCell(2).innerHTML=stock;
                nrow.insertCell(3).innerHTML=type;
                nrow.insertCell(4).innerHTML=size;
                nrow.insertCell(5).innerHTML = document.getElementsByName("length")[i-1].value;
                nrow.insertCell(6).innerHTML = document.getElementsByName("pcs")[i-1].value;
                nrow.insertCell(7).innerHTML = '<a class="btn btn-default" onclick="remove(this)" >Remove';

            }
            rows = rows + 1;
            //nrow.insertCell(7).innerHTML = '<a class="btn btn-default" onclick="remove(this)" >Remove';
            document.getElementById("bundle").value = "";
            document.getElementById("stock").value = parseInt(stock) + 1;


            $('#timberSelect').val(null).trigger('change');
            $('#sizeSelect').val(null).trigger('change');
            $('#count').val(null).trigger('change');
            $('#length').val(null).trigger('change');
            for (i = 1; i < index; i++) {
                //$('#addl').load(document.URL + ' #addl');
                element=document.getElementById('addl');
                element.parentNode.removeChild(element);
            }

        }

    }


    function remove(id) {
       // alert(ids);
        document.getElementById("timberCart").deleteRow(id.parentNode.parentNode.rowIndex);
        //for (i=0; i<ids.length; i++) {
          //  document.getElementById("timberCart").deleteRow(ids[i].parentNode.parentNode.rowIndex);
        //}
    }

    function completePurchase(){
        shipment = document.getElementById("shipmentName").value;
        buyer = document.getElementById("buyerId").value;
        invoice = document.getElementById("invoiceNo").value;
        arrivalDate = document.getElementById("arrivalDate").value;
        vessel = document.getElementById("vessel").value;
        remarks = document.getElementById("remarks").value;
        dataString = "";

        var timberTable=document.getElementById("timberCart");
        var rowLength = timberTable.rows.length;
        var sN=0;
        if (rowLength===1){
            swal({
                title:'Please add timber bundles!',
                text:'',
                type:'error',
                confirmButtonColor:'#009688'
            });
        }
        else {
            for (i = 1; i < rowLength; i++) {
                var oCells = timberTable.rows.item(i).cells;
                var thick = document.getElementById("timberCart").rows.item(i).cells.item(4).innerHTML.split('"');
                var wid = thick[1].split(" ");
                thick = thick[0];
                wid = wid[2];
                var stockNo = document.getElementById("timberCart").rows.item(i).cells.item(2).innerHTML.split('"');
                var bundleNo = document.getElementById("timberCart").rows.item(i).cells.item(1).innerHTML.split('"');
                var timberType = document.getElementById("timberCart").rows.item(i).cells.item(3).innerHTML.split('"');
                var length = document.getElementById("timberCart").rows.item(i).cells.item(5).innerHTML.split('"');
                var pieceCnt = document.getElementById("timberCart").rows.item(i).cells.item(6).innerHTML.split('"');

                if (sN === parseInt(stockNo)) {
                    dataString = dataString + "*****" + length + "*****" + pieceCnt;
                }
                else {
                    dataString = dataString + "#####" + stockNo + "*****" + bundleNo + "*****" + thick + "*****" + wid + "*****" + timberType + "*****" + length + "*****" + pieceCnt;
                    sN = parseInt(stockNo);
                }
                //alert(dataString);

            }
            finishPurchase(shipment,buyer,invoice,arrivalDate,vessel,remarks,dataString);
        }
        //alert(dataString);
    }

    function finishPurchase(shipment,buyer,invoice,arrivalDate,vessel,remarks,dataString) {
        swal({
            title: 'Are you sure?',
            text: "Finish the purchase",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#009688',
            cancelButtonColor: '#bec4ce',
            confirmButtonText: 'Proceed',
            allowOutsideClick: false
        }).then(function () {
            swal({
                title: 'Please wait',
                text: '',
                timer: 3000,
                onOpen: function () {
                    swal.showLoading()
                },
                allowOutsideClick: false
            }).then(function () {},
                // handling the promise rejection
                function (dismiss) {
                    if (dismiss === 'timer') {
                        console.log('I was closed by the timer')
                    }
                }
            );
            $.ajax({
                url : "assests/common/timberSupport/timber_ajax.php",
                type : "POST",
                timeout : 3000,
                async : "false",
                data : {
                    "purchase"  :true,
                    "shipment" : shipment,
                    "buyer" : buyer,
                    "invoice" : invoice,
                    "arrivalDate" : arrivalDate,
                    "vessel" : vessel,
                    "remarks" : remarks,
                    "dataString" : dataString
                },
                success : function(data){

                    if(data==="error"){
                        swal({
                            title:'Connection failed!',
                            text:'',
                            type:'info',
                            confirmButtonColor:'#009688'
                        });
                    }else{
                        swal({
                            title:'Purchase complete!',
                            text:data,
                            type:'success',
                            confirmButtonColor:'#009688'
                        });
                        setTimeout(function(){window.location.href = "purchaseInfo.php?id=<?php echo getLastShipmentId($dbh)?>";},1500);
                    }
                },
                error : function(a,b,c) {
                    swal({
                        title:'Connection failed!',
                        text:'',
                        type:'info',
                        confirmButtonColor:'#009688'
                    });
                }
            });
        });
    }

    /*function addShipment(d) {
        alert(d);

        //var oTable=document.getElementById("timberCart");

        //var rowLength = oTable.rows.length;
        //var timberBundles
        for (i = 1; i < rowLength; i++){

             var oCells = oTable.rows.item(i).cells;
            //var cellLength = oCells.length-1;

            //alert(<?php //echo $ship->getBuyerId()?>);
            //$bundle=new TimberBundle();
            //$bundle->setBundleNo(oCells.item(1).innerHTML);
            //$bundle->setStockNo(oCells.item(2).innerHTML);
            var id=<?php //echo getTimberID($dbh,oCells.item(3).innerHTML);?>;
            //$bundle->setTypeId($id);

            //var thick=document.getElementById("timberCart").rows.item(i).cells.item(4).innerHTML.split('"');
            //var wid=thick[1].split(" ");
            //thick=thick[0];
            //wid=wid[2];
            //alert(id);
            //var size=<?php //echo getsizeID($dbh,thick,wid);?>;
            //alert(size);
        }

    }*/

    function validateStockNo(num) {
        var result='0';
        $.ajax({
            url: "assests/common/timberSupport/timber_ajax.php",
            type: "POST",
            timeout: 3000,
            async: false,
            data: {
                "validateStockNo": true,
                "stockNo": num
            },
            success: function (data) {

                if(data==='0'){

                    result ='1';
                }
                else if (data==='1'){

                    result= '-1';
                }
                else{

                    result= '0';
                }
            },
            error: function () {

                result= '0';
            }

        });

        return result;
    }

    function error(name) {
        swal({
            position: 'top-left',
            type: 'error',
            title: 'Please complete '+name,
            showConfirmButton: false,
            timer: 1500
        })
    }

    /*function finish(ship,) {
        $.ajax({
            url: "assests/common/timberSupport/timber_ajax.php",
            type: "POST",
            timeout: 3000,
            async: false,
            data: {
                "addShipment": true,
                "shipInfo": ship
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