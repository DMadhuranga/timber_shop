<?php
/**
 * Created by PhpStorm.
 * User: manjitha
 * Date: 12/21/2017
 * Time: 2:35 PM
 */
include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
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
    <script type="text/javascript" src="https://cdn.emailjs.com/dist/email.min.js"></script>
    <script type="text/javascript">
        (function(){
            emailjs.init("user_5qcJKTtpbmtS06OrUEBSj");
        })();
    </script>
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
        <div class="col-md-6">
            <div class="card">
                <h3 class="card-title">Register New Buyer</h3>
                <div class="card-body">
                    <form>
                        <!--div class="form-group">
                            <label class="control-label" for="select">Select Role</label>
                            <div class="form">
                                <select class="form-control" id="select">
                                    <option>Manager</option>
                                    <option>Cashier</option>
                                    <option>Officer</option>
                                </select>
                            </div>
                        </div-->

                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input class="form-control" type="text" placeholder="Enter first name" id="fname" required/>
                            <label class="text-danger" id="fnameErr"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input class="form-control" type="text" placeholder="Enter last name" id="lname" required/>
                            <label class="text-danger" id="lnameErr"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Firm</label>
                            <input class="form-control" type="text" placeholder="Enter customer's firm " id="firm">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" placeholder="Enter email address" id="email" required/>
                            <label class="text-danger" id="emailErr"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea class="form-control" rows="4" placeholder="Enter address" id="address" ></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Telephone Number</label>
                            <input class="form-control" type="text" placeholder="Enter telephone number" id="telephone" />
                        </div>

                    </form>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary icon-btn" type="button" onclick="show()"><i class="fa fa-fw fa-lg fa-check-circle"></i>Register</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn" href="Create_customer.php"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Javascripts-->
<script type="text/javascript">
    gender = "";
    //error = false;
    fnameErr = lnameErr= emailErr = idErr = "";
    function getGen(){
        if (document.getElementById("male").checked == true){
            return ("male");
        }else if (document.getElementById("male").checked == false){
            return ("female");
        }
    }
    function isEmpty(string){
        return (string == "");
    }


    function errorcheck(){
        console.log(checkMail("admin@gmail.com"));
    }
    function checkMail(email){
        var checkMail = true;
        var ans = -1;
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data:{
                "email" : email,
                "checkMail": checkMail
            },
            async: false,
            success: function(msg){
                //alert(msg);
                ans = msg;
            }
        });
        return ans;
    }

    function checkId(id){
        var checkId = true;
        var ans = -1;
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data:{
                "id" : id,
                "checkId": checkId
            },
            async: false,
            success: function(msg){
                //alert(msg);
                ans = msg;
            }
        });
        return ans;
    }

    function updateDb(fname,lname,email,address,firm){
        var updateDbBuyer = true;
        //alert("running");
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data:{
                //"id" : id,
                //"role": role,
                "fname": fname,
                "lname":lname,
                "email":email,
                "address": address,
                //"telephone":telephone,
                "firm":firm,
                "updateDbBuyer":updateDbBuyer
            },
            async: false,
            success: function(msg){
                if (msg == 1){
                    console.log("Database successfully updated") ;
                    swal(
                        'Success!',
                        'Successfully registered',
                        'success'
                    )


                }else{
                    console.log("Database update Error ");
                    console.log(msg);
                }
            }
        });
    }

    function show(){
        firm = document.getElementById("firm").value;
        email = document.getElementById("email").value;
        fname = document.getElementById("fname").value;
        lname = document.getElementById("lname").value;
        address = document.getElementById("address").value;
        telephone = document.getElementById("telephone").value;
        //id = document.getElementById("ID").value;
        //gender = getGen();
        error = 0;
        //nameErr = emailErr = idErr = "";
        if (isEmpty(fname)){
            error = 1;
            fnameErr = "Please enter first name";
            document.getElementById("fname").focus();
            console.log("fname is empty");
        }
        if (isEmpty(lname)){
            error = 1;
            lnameErr = "Please enter last name";
            document.getElementById("lname").focus();
            console.log("lname is empty");
        }
        /*if (isEmpty(email)){
         error = 1;
         emailErr = "Please enter an email";
         document.getElementById("email").focus();
         console.log("email is empty");
         }else{
         console.log("email is non empty");
         if (checkMail(email)==0){
         console.log("email is unique");
         }else if(checkMail(email) == 1){
         error = 1;
         emailErr = "Email is already used";
         document.getElementById("email").focus();
         console.log("email is already used");
         }else{
         console.log("output from checkMail is" + checkMail(email));
         }

         }
         if (isEmpty(id)){
         error = 1;
         idErr  = "Please enter national Identity card number";
         document.getElementById("ID").focus();
         console.log("id is empty");
         }else{
         if (checkId(id)==0){
         console.log("ID is unique");
         }else if(checkId(id) == 1){
         error = 1;
         document.getElementById("ID").focus();
         console.log("ID is already in use");
         }

         }*/
        document.getElementById("fnameErr").innerHTML = fnameErr;
        document.getElementById("lnameErr").innerHTML = lnameErr;
        document.getElementById("emailErr").innerHTML = emailErr;
        //document.getElementById("idErr").innerHTML = idErr;

        if (error == 0){
            updateDb(fname,lname,email,address,firm);
            setTimeout(function(){ window.location.replace("login.php"); }, 3000);
        }else{
            console.log("Error" + error);
        }
    }






</script>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/pace.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>