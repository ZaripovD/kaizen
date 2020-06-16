<?php include('includes/adminSide.php');
require 'php/orgCheck.php';
require 'php/admaccess.php';

$acc = mysqli_num_rows(mysqli_query($connection,
"SELECT * FROM ideas WHERE status = '4'"));

$deny = mysqli_num_rows(mysqli_query($connection,
"SELECT * FROM ideas WHERE status = '5'"));

$moder = mysqli_num_rows(mysqli_query($connection,
"SELECT * FROM ideas WHERE status = '1' OR status = '2' OR status = '3'"));

?>

<script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['', ''],
          ['Одобрено', <?php echo $acc ?>],
          ['Отказано', <?php echo $deny ?>],
          ['Рассматривается', <?php echo $moder ?>]
        ]);

        var options = {
          title: 'Статистика предложений',
          pieHole: 0.4
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>

<div id="padd"> </div>

<div class="container" id="donutchart" ></div>


<?php include('includes/footer.php') ?>
