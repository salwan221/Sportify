<?php


$host="localhost";
$user="root";
$password="thisisit";
$database="sportify";

$link=mysqli_connect($host,$user,$password,$database);

if(mysqli_connect_errno()){
    die("database connection failed");
}	

?>
