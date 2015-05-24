  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
 <meta http-equiv="Content-Language" content="es" />
 
 
<?php
include 'Data_Access_Sqlite.php';

$baseSQlite = new Data_Access_Sqlite('ba');
$listadoVariables=array();
$comboVariables="";
$variable ="";
$textoPregunta="";
if (isset($_POST['variable'])) {
    $variable = $_POST['variable'];  
}


if (!empty($variable)) {

$table['rows'] = $baseSQlite->consultarResultadosGraficosHorinzo($variable);
$jsonTable = json_encode($baseSQlite->consultarResultadosGraficosHorinzo($variable));

}

$listadoVariables=$baseSQlite->consultarColumnas();
$textoPregunta=$baseSQlite->consultarTextoPregunta($variable);

foreach ($listadoVariables as $fila) {
	
    $comboVariables.= " <option value='" . $fila . "'>" . $fila . "</option>";
}
?>

 <head>

 
 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {


           
      // Create our data table out of JSON data loaded from server.
  
var data = google.visualization.arrayToDataTable(<?php echo $jsonTable; ?>);

		
    
        var options = {

            legend: {position: 'none'},
			title: '<?=$textoPregunta?>', 
			colors:['red','#009900']
        };
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
		
		var chart_div = document.getElementById('chart_div');
		
		// Wait for the chart to finish drawing before calling the getImageURI() method.
		google.visualization.events.addListener(chart, 'ready', function () {
        chart_div.innerHTML = '<img src="' + chart.getImageURI() + '">';
        console.log(chart_div.innerHTML);
		});
	  
	  
        chart.draw(data, options);


      }
    </script>
	
	

	
  </head>
  
  
    <body >
	<div class="container">
	
	 <h1> Graficos Proyecto IPS</H1>
	 
	 <?php
	print '<form name="input" action="index.php" method="post">';
	print "Seleccione la variable  ";
	print '<select name="variable" id="variable">';
	echo $comboVariables;
	print '</select>';
	print '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button id="enviar" class="btn btn-default" > Aceptar </button>';
	?>

     <div id="chart_div"  style="width: 1100; height: 700;"></div>
	 
	 
	 
	 </div>

  </body>


