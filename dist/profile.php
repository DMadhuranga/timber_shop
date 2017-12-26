<?php
/**
 * Created by PhpStorm.
 * User: manjitha
 * Date: 12/21/2017
 * Time: 8:58 PM
 */

include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
$sideBar = authenticate($dbh,array("1","0","2"),$_SERVER['REQUEST_URI']);
$user = unserialize($_SESSION["user"]);
$user_name = $user->getUserName();
$fname = $user->getFirstName();
$lname = $user->getLastName();
$id = $user->getNationalId();
$email = $user->getEmail();
$password = $user->getPassword();
$address = $user->getAddress();
$telephone = $user->getContacts();

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
        <div class="col-md-6">
            <div class="card">
                <h3 class="card-title">Edit Profile</h3>
                <div class="card-body">
                    <form>

                        <div class="form-group">
                            <label class="control-label">First Name</label>
                            <input class="form-control" id="fname" type="text" placeholder="<?php echo $fname?>" >
                        </div>
                        <div class="form-group">
                            <label class="control-label">Last Name</label>
                            <input class="form-control" id="lname" type="text" placeholder="<?php echo $lname?>" >
                        </div>
                        <div class="form-group">
                            <label class="control-label">User Name</label>
                            <input class="form-control" id="uname" type="text" placeholder="<?php echo $user_name?>" >
                            <label class="text-danger" id="unameErr"></label>
                        </div>
                        <p><a class="btn btn-info" href="#">Change Password</a></p>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" id="email" placeholder="<?php echo $email?>">
                            <label class="text-danger" id="emailErr"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea class="form-control" rows="4" id="address" placeholder="<?php echo $address?>"></textarea>
                        </div>
                        <?php
                            foreach ($telephone as $item){
                                echo "<div class='form-group'>
                            <label class='control-label'>Contact Number</label>
                            <input class='form-control' type='text' id='id' placeholder='".$item[1]."' required>
                        </div>";
                            }

                        ?>

                        <div class="form-group">
                            <label class="control-label">National Identity Card</label>
                            <input class="form-control" type="text" id="id" placeholder="<?php echo $id?>" required>
                        </div>
                        <!--div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox">I accept the terms and conditions
                                </label>
                            </div>
                        </div-->
                    </form>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary icon-btn" type="button" onclick="show()"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-default icon-btn" href="#"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Javascripts-->
<script>
    function isEmpty(string){
        return (string == "");
    }
    function show(){
        user_name = "<?php echo $user_name?>";
        fname = "<?php echo $fname?>";
        lname = "<?php echo $lname?>";
        id = "<?php echo $id?>";
        email = "<?php echo $email?>";
        address = "<?php echo $address?>";
        error = 0;

        if ((!isEmpty(document.getElementById("uname").value))&&(user_name != document.getElementById("uname").value)){
            final_uname = document.getElementById("uname").value;
        }else{
            final_uname = user_name;
        }
        if ((!isEmpty(document.getElementById("fname").value))&&(fname != document.getElementById("fname").value)){
            final_fname = document.getElementById("fname").value;
        }else{
            final_fname = fname;
        }
        if ((!isEmpty(document.getElementById("lname").value))&&(lname != document.getElementById("lname").value)){
            final_lname = document.getElementById("lname").value;
        }else{
            final_lname = lname;
        }
        if ((!isEmpty(document.getElementById("address").value))&&(address != document.getElementById("address").value)){
            final_address = document.getElementById("address").value;
        }else{
            final_address = address;
        }
        if ((!isEmpty(document.getElementById("telephone").value))&&(telephone != document.getElementById("telephone").value)){
            final_telephone = document.getElementById("telephone").value;
        }else {
            final_telephone = telephone;
        }
        if ((!isEmpty(document.getElementById("id").value))&&(id != document.getElementById("id").value)){
            final_id = document.getElementById("id").value;
        }else{
            final_id = id;
        }

        if (checkUser(final_uname)==0){
            console.log("uname is unique");
        }else if(checkUser(final_uname) == 1){
            error = 1;
            unameErr = "User name is already used";
            document.getElementById("uname").focus();
            console.log("uname is already used");
        }else{
            console.log("output from checkUser is" + checkMail(email));
        }
        if (checkId(id)==0){
            console.log("ID is unique");
        }else if(checkId(id) == 1){
            error = 1;
            idErr = "NIC is already used";
            document.getElementById("ID").focus();
            console.log("ID is already in use");
        }
        if (error == 0){
            updateDb(final_uname,final_fname,final_lname,final_address,final_id,email);
            setTimeout(function(){ window.location.replace("login.php"); }, 3000);

        }else{
            console.log("Error" + error);
        }

    }

    function updateDb(final_uname,final_fname,final_lname,final_address,final_id,email){
        var updateEditDb = true;
        //alert("running");
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data:{
                "final_id" : final_id,
                "final_uname": final_uname,
                "final_fname": final_fname,
                "final_lname":final_lname,
                "email":email,
                "final_address": final_address,
                //"telephone":telephone,
                //"gender":gender,
                "updateEditDb":updateEditDb
            },
            async: false,
            success: function(msg){
                if (msg == 1){
                    console.log("Database successfully updated") ;
                    //emailjs.send("gmail", "template_vSdB32nb", {"from_name":"Kelum Timber","to_name":fname,"user_name":email,"password":email});
                    swal(
                        'Success!',
                        'Successfully Eddited Profile',
                        'success'
                    )

                }else{
                    console.log("Database update Error ");
                }
            }
        });
    }


    function checkUser(uname){
        var checkUser = true;
        var ans = -1;
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data:{
                "uname" : uname,
                "checkUser": checkUser
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
</script>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/pace.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>