<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/20/2017
 * Time: 1:26 PM
 */
include_once("assests/common/basic_support.php");
if(!isset($_SESSION)){
    session_start();
}
header("location:login.php");