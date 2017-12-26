<?php
/**
 * Created by PhpStorm.
 * User: AVARM
 * Date: 12/21/2017
 * Time: 10:10 PM
 */
include_once("../dbconnection.php");
include_once("timber_support.php");

if (isset($_REQUEST["changeTimberName"])){
    $id=$_REQUEST["id"];
    $newName=$_REQUEST["new"];
    $result=changeTimberName($dbh,$id,$newName);
    echo $result;
    exit;
}

if (isset($_REQUEST["deleteTimberName"])){
    $id=$_REQUEST["id"];
    $result=deleteTimberType($dbh,$id);
    echo $result;
    exit;
}

if (isset($_REQUEST["addNewTimberType"])){
    $name=$_REQUEST["name"];
    $result=addTimberType($dbh,$name);
    echo $result;
    exit;
}


if (isset($_REQUEST["changeTimberSize"])){
    $id=$_REQUEST["id"];
    $thickness=$_REQUEST["thickness"];
    $width=$_REQUEST["width"];
    $result=changeTimberSize($dbh,$id,$thickness,$width);
    echo $result;
    exit;
}

if (isset($_REQUEST["deleteTimberSize"])){
    $id=$_REQUEST["id"];
    $result=deleteTimberSize($dbh,$id);
    echo $result;
    exit;
}

if (isset($_REQUEST["addNewTimberSize"])){
    $thickness=$_REQUEST["thickness"];
    $width=$_REQUEST["width"];
    $result=addTimberSize($dbh,$thickness,$width);
    echo $result;
    exit;
}

if (isset($_REQUEST["changeTimberPrice"])){
    $typeId=$_REQUEST["typeId"];
    $sizeId=$_REQUEST["sizeId"];
    $price=$_REQUEST["price"];
    $oldPrice=$_REQUEST["oldPrice"];
    $result=changeTimberPrice($dbh,$typeId,$sizeId,$price,$oldPrice);
    echo $result;
    exit;
}
