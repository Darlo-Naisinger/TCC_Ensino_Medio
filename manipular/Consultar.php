<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link href="css/bootstrap.min.css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
    <?php 
    session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
{
  unset($_SESSION['email']);
  unset($_SESSION['senha']);
  header('location:login.php');
  }
 
    ?>   
    </head>
    <body>
        <h1>Consultar!</h1>
            <form action="Consultar.php" method="POST">
            <label>Data1:</label>
            <input type="date" name="data1" ><br><br>
            <label>Data2:</label>
            <input type="date" name="data2" >
            <input type="submit" value="consultar" name="saida">
            <br><br>
            <a href="index_adm.php">Voltar</a>
            </form>
<?php
if(!empty($_POST['data1'])){
$data1 = $_POST['data1'];
$data2 = $_POST['data2'];

$pdo = new PDO('mysql:host=localhost;dbname=tcc',"root","");

$consulta = $pdo->query("SELECT * FROM ponto WHERE (data BETWEEN '$data1' AND '$data2') AND  (id_usuarios = ".$_SESSION['id_usuario'].")");
     echo"<table border='1' style ='whidth:100%' align='center'>"
    . "<tr align='center'>"
          . "<th>Hora1</th>"
          . "<th>Hora2</th>"
          . "<th>Data</th>"
          . "</tr>";
    while ($ver = $consulta->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr align= 'center'>"
        . "<td>" . $ver['hora1'] ."</td>"
        . "<td>" . $ver['hora2'] ."</td>"
        ."<td>" . $ver['data'] ."</td>"
        ."</tr>";
       
}  echo "</table>";
}
?>
            <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="js/bootstrap.min.js"></script>
    </body>
</html>
