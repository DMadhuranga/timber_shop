<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/20/2017
 * Time: 2:02 PM
 */
include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION["user"])){
    $user = unserialize($_SESSION["user"]);
    if(checkLoginDataGet($dbh,$user->getUserName(),$user->getPassword())==1){
        header("location:home.php");
    }else{
        session_unset();
        setcookie("user", "", time() - 3600);
    }
}
if(isset($_COOKIE["user"])){
    $user = unserialize($_COOKIE["user"]);
    if(checkLoginDataGet($dbh,$user->getUserName(),$user->getPassword())==1){
        $_SESSION["user"] = serialize($user);
        header("location:home.php");
    }else{
        session_unset();
        setcookie("user", "", time() - 3600);
    }
}
$return = "";
if(isset($_REQUEST["user_name"]) && isset($_REQUEST["password"])){
    $user = getUser($dbh,$_REQUEST["user_name"],md5($_REQUEST["password"]));
    if($user==-2){
        die("Connection failed. Please try again later.");
    }elseif ($user==-1){
        $return = "Username or password incorrect";
    }else{
        $_SESSION["user"] = serialize($user);
        if(isset($_REQUEST["stay_sign"])){
            setcookie("user", serialize($user), time() + (86400 * 30));
        }
        header("location:home.php");
    }
}
?>
<!DOCTYPE html>
<html xmlns:color="http://www.w3.org/1999/xhtml">
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
<body>
<section class="material-half-bg">
    <div class="cover"></div>
</section>
<section class="login-content">
    <div class="logo">
        <h1>Kalum Timber</h1>
    </div>
    <div class="login-box">
        <form class="login-form" action="login.php" method="post">
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
            <div class="form-group">
                <label style="color: red"><?php echo $return; ?></label>
                <label class="control-label">USERNAME </label>&nbsp &nbsp &nbsp
                <input name="user_name" class="form-control" type="text" placeholder="Email" autofocus>
            </div>
            <div class="form-group">
                <label  class="control-label">PASSWORD</label>
                <input name="password" class="form-control" type="password" placeholder="Password">
            </div>
            <div class="form-group">
                <div class="utility">
                    <div class="animated-checkbox">
                        <label class="semibold-text">
                            <input name="stay_sign" type="checkbox"><span class="label-text">Stay Signed in</span>
                        </label>
                    </div>
                    <!--
                  <p class="semibold-text mb-0"><a data-toggle="flip">Forgot Password ?</a></p> -->
                </div>
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
            </div>
        </form>
        <form class="forget-form" action="index.html">
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
            <div class="form-group">
                <label class="control-label">EMAIL</label>
                <input class="form-control" type="text" placeholder="Email">
            </div>
            <div class="form-group btn-container">
                <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
            </div>
            <div class="form-group mt-20">
                <p class="semibold-text mb-0"><a data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
            </div>
        </form>
    </div>
</section>
</body>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/plugins/pace.min.js"></script>
<script src="js/main.js"></script>
</html>