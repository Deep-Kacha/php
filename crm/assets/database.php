<?php
    try{
        $con = mysqli_connect("localhost", "root", "", "COOKING");
    }catch(Exception $e){
        echo "error in connecting database";
    }
?>