<?php

	include("connect.php"); 
	$link=Connection();	
	$result=mysql_query("SELECT * FROM `templog` ORDER BY `timeStamp` DESC",$link);
	$result2=mysql_query("SELECT * FROM `templog` ORDER BY `tempStamp` DESC LIMIT 1",$link);
	
?>

<html>
	<head>
		<title>Monitoring Suhu Server</title>
		<link rel="stylesheet" href="./css/style.css">
		<link rel="stylesheet" href="./css/bootstrap.css">
	</head>
	<body>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<center><h3 style="text-align:left;" class="hijau tebel">Logging Suhu Server</h3></center>
			</div>
			<div class="col-md-2">
				&nbsp;
			</div>
		</div>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<center><h5 style="text-align:left;" class="miring">Data Logging dengan Arduino, Ethernet Shield dan DHT11</h5></center>
				<hr style="margin-top: 0px; margin-bottom:0px">
			</div>
			<div class="col-md-2">
				&nbsp;
			</div>
		</div>
		<br>
		<?php
			if($result2!==FALSE){
				$ndata=mysql_num_rows($result);
			    while($lastrow = mysql_fetch_array($result2)) {
			    	$last_temp1=$lastrow["tempServer1"];
			    	$last_temp2=$lastrow["tempServer2"];
			    	$last_update=$lastrow["timeStamp"];
			    }
			}
				mysql_free_result($result);
				mysql_close();
				
		?>


<div class="row">
			<div class="col-md-2 col-md-offset-2">
				<div class="panel panel-primary">
  					<div class="panel-heading">
    					<h3 class="panel-title tengah">Navigasi</h3>
  					</div>
  					<div class="panel-body" style="padding:0px;">
    					<table class="table table-stripped table-hover" >
							<tbody>
								<tr class="info">
									<td><span class="glyphicon glyphicon-home"></span><a href="./index.php" style="text-decoration:none;"> Home</a></td>
								</tr>
								<tr>
									<td><span class="glyphicon glyphicon-th-list"></span><a href="./tables.php" style="text-decoration:none;"> Tabel</a></td>
								</tr>
								<tr>
									<td><span class="glyphicon glyphicon-stats"></span><a href="./stats.php" style="text-decoration:none;"> Statistik</td>
								</tr>
							</tbody>
						</table>
  					</div>
				</div>
			</div>
			<div class="col-md-3">
				<table class="table table-bordered">
					<thead>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px; font-size:18px">Suhu Server1 (&degC)</p></center></td>
					</thead>
					<tr class="success">
						
						<td><center><p class="tebel gede" style="margin-top:5px"><?php echo $last_temp1 ?></p></center></td>
					</tr>
				</table>
			</div>
			<div class="col-md-3">
				<table class="table table-bordered">
					<thead>
						<td><center><p class="tebel" style="margin-top:0px; margin-bottom:0px; font-size:18px">Suhu Server2 (&degC)</p></center></td>
					</thead>
					<tr class="info">
						<td><center><p class="tebel gede" style="margin-top:5px"><?php echo $last_temp1	?></p></center></td>
					</tr>
				</table>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-4">
				<p class="tebel">Ringkasan Data:</p>
					<table class="table table-striped table-hover">
						<tr>
							<td><?php $last_update?></td>
							<td>:</td>
							<td><?php echo $last_update?></td>
						</tr>
						<tr>
							<td>Interval Update</td>
							<td>:</td>
							<td>1 menit</td>
						</tr>
						<tr>
							<td><?php echo $ndata ;?></td>
							<td>:</td>
							<td><?php echo $ndata ;?></td>
						</tr>
					</table>
			</div>
			
		</div>
    </div>
	</body>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="./js/modules/data.js"></script>
	<script type="text/javascript" src="./js/modules/exporting.js"></script>
	<script type="text/javascript" src="./js/highcharts.js"></script>
	<script type="text/javascript" src="./js/bootstrap.js"></script>
	
</html>

EOT;

>?