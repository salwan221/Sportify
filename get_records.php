<?php
	
	include_once("database_connection_open.php");

	$sql = "select * from test";
	
	$result = mysqli_query($link, $sql);
	$str = "";
	while($row = mysqli_fetch_row($result)){
		$str = $str."<tr>";
		for($i = 0; $i < sizeof($row);$i++)
			$str = $str."<td>".$row[$i]."</td>";
		
		$str = $str."</tr>";
	}
	echo $str;
	
	include_once("database_connection_close.php");
?>
