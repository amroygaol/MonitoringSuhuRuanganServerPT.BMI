<?php

	include("connect.php");
	$link=Connection();	
	$result=mysql_query("SELECT * FROM `templog` ORDER BY `timeStamp` DESC",$link);
?>
<?php // content="text/plain; charset=utf-8"
$value = ['tempServer1'];
$value2= ['tempServer2'];

$data1 = "[$value]";
$data2 = "[$value2]";
// Setup the graph
$graph = new graph(300,250);
$graph->SetScale("textlin");

$theme_class=new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Filled Y-grid');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($timestamp);
$graph->xgrid->SetColor('#E3E3E3');

// Create the first line
$p1 = new LinePlot($data1);
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('Line 1');

// Create the second line
$p2 = new LinePlot($data2);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('Line 2');


$graph->legend->SetFrameWeight(1);

// Output line
$graph->Stroke();

?>
