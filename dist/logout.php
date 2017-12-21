<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/20/2017
 * Time: 2:01 PM
 */
session_start();
session_unset();
setcookie("user", "", time() - 3600);
header("location:login.php");