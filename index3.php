<?php

include_once ("database_connection_open.php");

?>


<!DOCTYPE html>
<head>
<title>Sportify</title>
<style>
table {
	background-color: #4CAF50;
    color: black;
    font-family: verdana;
    font-size: 100%;
}
</style>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('http://wallpapercave.com/wp/76enKL8.jpg');"> 
  <!-- ################################################################################################ -->
  <div class="wrapper row1">
    <header id="header" class="hoc clear"> 
      <!-- ################################################################################################ -->
      <div id="logo" class="fl_left">
        <h1><a href="index.html">Sportify</a></h1>
      </div>
      <nav id="mainav" class="fl_right">
        <ul class="clear">
          <li class="active"><a href="index.html">Home</a></li>
          <li><a class="active" href="index1.html">Login/Sign Up</a></li>
          <li><a href="#contact">Contact</a></li>
          <li><a href="#about">About</a></li>
        </ul>
      </nav>
      <!-- ################################################################################################ -->
    </header>
  </div>

  <div id="pageintro" class="hoc clear">

        <div class = "row">
      <div class="content-wrap-table">       

        <div class="main-content-tablecell">

          <div class="row">

            <div class="col-twelve">
              <div class = "col-md-3">                
              </div>
              <!-- <div class = "col-md-6"> -->
      <table id="records" class="table table-responsive table-bordered">
        <h1>Records</h1>
        <tr class="table-active">
          <th>ID</th>
          <th>HTP</th>
          <th>ATP</th>
          <th>HM1</th>
          <th>HM2</th>
          <th>HM3</th>
          <th>AM1</th>
          <th>AM2</th>
          <th>AM3</th>
          <th>HTGD</th>
          <th>ATGD</th>
          <th>DiffFormsPts</th>
          <th>DiffLP</th>
          <th>Result</th>

        </tr>
  

      <?php include("get_records.php") ?>


    </table>

  </div>

</div>



<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>

<script type="text/javascript">

  $("#records tr").css("cursor","pointer");
  
  $('#records').find('tr').click( function(){
      var row = $(this).find('td:first').text();

      var save=$(this).find('td:last');
      save.text('Predicting...');

      $.get("get_prediction_result.php?row_id="+row, function(data, status){

        // alert(data);
        save.text(data);

      });

  });


</script>

</body>
</html>

<?php 

include_once("database_connection_close.php");

?>