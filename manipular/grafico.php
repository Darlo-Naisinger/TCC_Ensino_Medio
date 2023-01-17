<html>
    <head>
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    </head>
    <?php
    session_start();
    if ((!isset($_SESSION['login']) == true) and ( !isset($_SESSION['senha']) == true)) {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('location:login.php');
    }
    ?>
    <body>
        <div id="piechart" style="width: 900px; height: 500px;"></div>


        <form action="grafico.php" method="POST">
            <label>Data1:</label>
            <input type="date" name="data1" ><br><br>
            <label>Data2:</label>
            <input type="date" name="data2" >
            <input type="submit" value="consultar">
            
            <a href="index_adm.php">Voltar</a>
        </form>
<?php
if(!empty($_POST['data1'])){
    try {
    $data1 = $_POST['data1'];
    $data2 = $_POST['data2'];

    $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $consulta = $pdo->query("SELECT * FROM ponto WHERE (data BETWEEN '$data1' AND '$data2') AND (id_usuarios = " . $_SESSION['id_usuario'] . ")");
    echo"<table border='1' style ='whidth:100%' align='center'>"
    . "<tr align='center'>"
    . "<th>Hora1</th>"
    . "<th>Hora2</th>"
    . "<th>Data</th>"
    . "</tr>";
    while ($ver = $consulta->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr align= 'center'>"
        . "<td>" . $ver['hora1'] . "</td>"
        . "<td>" . $ver['hora2'] . "</td>"
        . "<td>" . $ver['data'] . "</td>"
        . "</tr>";
    } echo "</table>";

    $stmt = $pdo->prepare("select time_format( SEC_TO_TIME( SUM( TIME_TO_SEC(somatorio) ) ),'%H:%i:%s')
FROM ( SELECT hora1, hora2, time_format(ABS(TIMEDIFF (hora1,hora2)),'%H:%i:%s') as somatorio from ponto where (data 
BETWEEN :data1 and :data2)and (id_usuarios = " . $_SESSION['id_usuario'] . ")) as teste");

    //$stmt->execute();
    $stmt->execute(array(':data1' => $data1, ':data2' => $data2));


    //echo $stmt->rowCount();
    $row = $stmt->fetch(PDO::FETCH_BOTH);
    $calculo = 160 - (int) $row[0];
    echo $calculo;
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
}
?>    
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            var row = <?php echo (int) $row[0]; ?>;  // valor lido banco
            var falta = <?php echo $calculo; ?>;
            var fez = row;

            function drawChart() {

                var data = google.visualization.arrayToDataTable([
                    ['trabalho', 'Horas por mes'],
                    ['falta', falta],
                    ['fez', fez],
                ]);

                var options = {
                    title: 'Horas Mensais concluidas',

                    hAxis: {
                        maxValue: 160,
                        ticks: [0, .3, .6, .9, 1]
                    }
                };

                var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                chart.draw(data, options);
            }
        </script>
            <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>