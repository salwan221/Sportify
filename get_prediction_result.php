<?php
	
	include_once("database_connection_open.php");

	if(array_key_exists("row_id", $_GET)){

		$row_id=$_GET["row_id"];

		$query="select * from test where ID=".$row_id;

		if($result=mysqli_query($link,$query)){

			$row=mysqli_fetch_row($result);

			$command1="cd classification_algorithm/";
			$command2="python2 model.py ".$row[1]." ".$row[2]." ".$row[3]." ".$row[4]." ".$row[5]." ".$row[6]." ".$row[7]." ".$row[8]." ".$row[9]." ".$row[10]." ".$row[11]." ".$row[12];

			// echo $command2;

			echo shell_exec($command1." && ".$command2);


		}else{

			die("error getting records for row ".$row_id);

		}

	}else{

		die("error getting row id");

	}

	include_once("database_connection_close.php");

?>
