<?php

include_once ("database_connection_open.php");
if(array_key_exists("loginEmail",$_POST) && array_key_exists("loginPassword",$_POST)){
    $loginEmail=$_POST["loginEmail"];
    $loginPassword=$_POST["loginPassword"];
    $query_check_email_exists="select * from users where uemail='".mysqli_escape_string($link,$loginEmail)."'";
    if($result=mysqli_query($link,$query_check_email_exists)){
        //email id exists
        if(mysqli_num_rows($result)==1){
            if($row=mysqli_fetch_array($result)){
                //check whether the hashed password matches the one stored in the database
                $hashedPassword=md5(md5($row["uid"]).$loginPassword);

                if($hashedPassword==$row["upassword"]){
                    //passwords match, account exists
                    echo "1";
                    // echo "<div class='alert alert-success' role='alert'>Login successful.</div>";
                }else{
                    //passwords don't match
                    echo "2";
                    // echo "<div class='alert alert-danger' role='alert'>Wrong password.</div>";
                }
            }
        }else if(mysqli_num_rows($result)==0){
            //email id does not exists
            echo "3";
            // echo "<div class='alert alert-danger' role='alert'>Email id doesn't exists.</div>";
        }
    }
    else{

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