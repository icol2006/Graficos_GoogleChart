<?php 
$array = array(
    array('Year', '', array('role' => 'annotation')),
    array('Si', 2, '2%'),
    array('No', 3, '3%'),
	array('Ns/Nr', 8, '8%'),

);

print_r($array);
?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {

        var data = google.visualization.arrayToDataTable(<?php echo json_encode($array); ?>);

        var options = {
            bar: { groupWidth: '64%' },
            legend: {position: 'none'},
			title: 'Texto Pregunta' ,

        };

        var chart = new google.visualization.BarChart(document.getElementById('technological-fields'));
        chart.draw(data, options);
    }
</script>

<div id="technological-fields" style="width: 1000; height: 600;"></div>