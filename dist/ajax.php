<?php
/**
 * Created by PhpStorm.
 * User: manjitha
 * Date: 12/22/2017
 * Time: 5:25 PM
 */

include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");

if(isset($_REQUEST["checkMail"])){
    $ans = -1;
    if ($dbh) {
        $email = $_REQUEST["email"];
        $sql = $dbh->prepare("select user_name from user where (email=? and deleted=0)");
        $sql->execute(array($email));
        if ($sql) {
            $result = $sql->fetchAll();
            if(sizeof($result)>0){

                $ans= 1;
            }else{
                $ans = 0;
            }
        }
    }
    echo $ans;
    exit();
}

if(isset($_REQUEST["checkUser"])){
    $ans = -1;
    if ($dbh) {
        $uname = $_REQUEST["uname"];
        $sql = $dbh->prepare("select * from user where (user_name=? and deleted=0)");
        $sql->execute(array($uname));
        if ($sql) {
            $result = $sql->fetchAll();
            if(sizeof($result)>0){

                $ans= 1;
            }else{
                $ans = 0;
            }
        }
    }
    echo $ans;
    exit();
}

if(isset($_REQUEST["checkId"])){
    $ans = -1;
    if ($dbh) {
        $id = $_REQUEST["id"];
        $sql = $dbh->prepare("select user_name from user where (id=? and deleted=0)");
        $sql->execute(array($id));
        if ($sql) {
            $result = $sql->fetchAll();
            if(sizeof($result)>0){

                $ans= 1;
            }else{
                $ans = 0;
            }
        }
    }
    echo $ans;
    exit();
}

if (isset($_REQUEST["updateDb"])){
    $ans = -1;
    if ($dbh) {
        $fname = $_REQUEST["fname"];
        $lname = $_REQUEST["lname"];
        $role = $_REQUEST["role"];
        $id = $_REQUEST["id"];
        $email = $_REQUEST["email"];
        $address = $_REQUEST["address"];
        $gender = $_REQUEST["gender"];
        $user_name = $email;
        $password = $email;

        $sql = $dbh->prepare("INSERT INTO user (user_name,role_id,email,first_name,last_name,national_id,address,password) values (?,?,?,?,?,?,?,?)");
        //$sql->bind_param("ssssssss", $user_name, $role, $email,$fname,$lname,$id,$address,$password);
        $sql->execute(array($user_name, $role, $email,$fname,$lname,$id,$address,$password));
        //$sql->close();
        $ans = 1;
    }else{
        $ans = 0;
    }
    echo $ans;
    exit();

}

if (isset($_REQUEST["updateEditDb"])){
    $ans = -1;
    if ($dbh) {
        $fname = $_REQUEST["final_fname"];
        $lname = $_REQUEST["final_lname"];
        $user_name = $_REQUEST["final_uname"];
        $id = $_REQUEST["final_id"];
        $email = $_REQUEST["email"];
        $address = $_REQUEST["final_address"];
        //$gender = $_REQUEST["gender"];
        //$user_name = $email;
        //$password = $email;

        $sql = $dbh->prepare("UPDATE user (user_name,first_name,last_name,national_id,address,password) values (?,?,?,?,?,?,?,?)");
        //$sql->bind_param("ssssssss", $user_name, $role, $email,$fname,$lname,$id,$address,$password);
        $sql->execute(array($user_name, $role, $email,$fname,$lname,$id,$address,$password));
        //$sql->close();
        $ans = 1;
    }else{
        $ans = 0;
    }
    echo $ans;
    exit();

}

if (isset($_REQUEST["updateDbCustomer"])){
    $ans = -1;
    if ($dbh) {
        $fname = $_REQUEST["fname"];
        $lname = $_REQUEST["lname"];
        $full_name = $fname.' '.$lname;
        $firm = $_REQUEST["firm"];
        //$id = $_REQUEST["id"];
        $email = $_REQUEST["email"];
        $address = $_REQUEST["address"];
        //$gender = $_REQUEST["gender"];
        //$user_name = $email;
        //$password = $email;
        $registered_date = date("Y/m/d");
        $sql = $dbh->prepare("INSERT INTO customer (customer_name,firm,email,address,registered_date) values (?,?,?,?,?)");
        //$sql->bind_param("ssssssss", $user_name, $role, $email,$fname,$lname,$id,$address,$password);
        $sql->execute(array($full_name, $firm, $email,$address,$registered_date));
        //$sql->close();
        $ans = 1;
    }else{
        $ans = 0;
    }
    echo $ans;
    exit();

}
if (isset($_REQUEST["updateDbBuyer"])){
    $ans = -1;
    if ($dbh) {
        $fname = $_REQUEST["fname"];
        $lname = $_REQUEST["lname"];
        $full_name = $fname.' '.$lname;
        $firm = $_REQUEST["firm"];
        //$id = $_REQUEST["id"];
        $email = $_REQUEST["email"];
        $address = $_REQUEST["address"];
        //$gender = $_REQUEST["gender"];
        //$user_name = $email;
        //$password = $email;
        $registered_date = date("Y/m/d");
        $sql = $dbh->prepare("INSERT INTO buyer (buyer_name,firm,email,address,registered_date) values (?,?,?,?,?)");
        //$sql->bind_param("ssssssss", $user_name, $role, $email,$fname,$lname,$id,$address,$password);
        $sql->execute(array($full_name, $firm, $email,$address,$registered_date));
        //$sql->close();
        $ans = 1;
    }else{
        $ans = 0;
    }
    echo $ans;
    exit();

}