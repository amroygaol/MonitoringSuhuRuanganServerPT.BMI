<?php

	include("connection.php");
	$result=mysql_query("SELECT * FROM `templog` ORDER BY `timeStamp` DESC");
?>
<html>
	<head>
		<title>Statistik Data Harian Rata-Rata</title>
		<link rel="stylesheet" href="./css/style.css">
		<link rel="stylesheet" href="./css/bootstrap.css">
		<meta http-equiv="refresh" content="60" > 
	</head>
	<body>
		
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<p><img src="download.png" alt="Logo" style="float:left;width:228px;height:228px;">
				<h1 style="text-align:left; margin-top: 50px; margin-bottom:50px;" class="hijau tebel">Logging Suhu Server</h1></p>
				<hr style="margin-top: 0px; margin-bottom:0px">
			</div>

			<div class="col-md-2">
				&nbsp;
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-2 col-md-offset-2">
				<div class="panel panel-primary">
  					<div class="panel-heading">
    					<h3 class="panel-title tengah">Navigasi</h3>
  					</div>
  					<div class="panel-body" style="padding:0px;">
    					<table class="table table-stripped table-hover" >
							<tbody>
								<tr>
									<td><span class="glyphicon glyphicon-home"></span><a href="./index.php" style="text-decoration:none;"> Home</a></td>
								</tr>
								<tr class="info">
									<td><span class="glyphicon glyphicon-th-list" ></span><a href="./tables.php" style="text-decoration:none;"> Tabel</a></td>
								</tr>
								<tr>
									<td><span class="glyphicon glyphicon-stats"></span><a href="./stats.php" style="text-decoration:none;"> Statistik</td>
								</tr>
							</tbody>
						</table>
  					</div>
				</div>
			</div>
			<div style="height:350px;overflow:auto;" class="col-md-6">
				<p class="tebel">Tabel Data Suhu:</p>
				<table class="table table-striped table-bordered">
					<thead>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px;">Tanggal</p></center></td>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px;">Suhu Server 1 (&degC)</p></center></td>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px;">Suhu Server 2 (&degC)</p></center></td>
					</thead>
					<tbody>
						<?php
		  					if($result!==FALSE){
							    while($row = mysql_fetch_array($result)) {
									//extract $row;
							        printf("<tr><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>",
						            $row["timeStamp"], $row["tempServer1"], $row["tempServer2"]);
								    $value = $row['tempServer1'];
								    $value2= $row['tempServer2'];
								   	$timestamp = strtotime($row['timeStamp'])*1000;
								   	$data1[] = "[$timestamp, $value]";
								   	$data2[] = "[$timestamp, $value2]";
							    }
								//json_encode($data);
							    mysql_free_result($result);
							    mysql_close();
							}
      					?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="./js/modules/data.js"></script>
	<script type="text/javascript" src="./js/modules/exporting.js"></script>
	<script type="text/javascript" src="./js/highcharts.js"></script>
	<script type="text/javascript" src="./js/bootstrap.js"></script>
