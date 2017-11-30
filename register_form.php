<?php

include_once ("database_connection_open.php");
if(array_key_exists("uname",$_POST) && array_key_exists("uemail",$_POST) && array_key_exists("upassword",$_POST)){
    $uname=$_POST["uname"];
    $uemail=$_POST["uemail"];
    $upassword=$_POST["upassword"];

    $query="select * from users where uemail='".mysqli_escape_string($link,$uemail)."'";
    if($result=mysqli_query($link,$query)){
        if(mysqli_num_rows($result)==0){
            $query_register_user="insert into users (uname,uemail,upassword) values ('".mysqli_escape_string($link,$uname)."','".mysqli_escape_string($link,$uemail)."','".mysqli_escape_string($link,$upassword)."')";
            if($result_register_user=mysqli_query($link,$query_register_user)){
                $id=mysqli_insert_id($link);
                $securePassword=md5(md5($id).$upassword);

                $query_update_password="update users set upassword ='".mysqli_escape_string($link,$securePassword)."' where uid=".$id."";

                if(mysqli_query($link,$query_update_password)){

                    // echo "yes";

                }else{
                    // echo "no";
                }
                //successfully registered
                echo "1";
                // echo "<div class='alert alert-success' role='alert'>Sign up successful.</div>";
            }else{
                //error signing up
                echo "2";
                 // echo "<div class='alert alert-danger' role='alert'>Error signing up. Try again!</div>";
            }
        }else{
            //alerady exists
            echo "3";
            // echo "<div class='alert alert-danger' role='alert'>Email already exists.</div>";
        }
    }else{
        echo "4";
        // echo "<div class='alert alert-danger' role='alert'>Error.</div>";

    }

}
else{
    echo "5";
    // echo "<div class='alert alert-danger' role='alert'>Form data not received.</div>";
}
include_once ("database_connection_close.php");
?>