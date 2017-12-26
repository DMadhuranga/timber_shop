<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/21/2017
 * Time: 9:59 AM
 */
include_once("assests/common/dbconnection.php");
include_once("assests/common/basic_support.php");
include_once("assests/common/classes/User.php");
$user = unserialize($_SESSION["user"]);
foreach ($user->getContacts() as $number){
    echo $number[0]." - ".$number[1]."</br>";
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="assests/library/sweetAlert2/sweetalert2.min.css">
</head>
<body>

<script type="text/javascript" src="assests/jquery.min.js"></script>
<script type="text/javascript" src="assests/library/sweetAlert2/sweetalert2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        swal({
                title: 'What is your name?',
                input: 'text',
                inputPlaceholder: 'Enter your name or nickname',
                showCancelButton: true,
                preConfirm: function (value) {
                    return new Promise(function (resolve, reject) {
                        if (value === '') {
                            reject("Please include a input")
                        } else {
                            resolve()
                        }
                    })
                }
        }).then(function (name){
            swal(name);
        });

    });
</script>
</body>
</html>