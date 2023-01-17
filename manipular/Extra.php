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
 /* esse bloco de código em php verifica se existe a sessão, pois o usuário pode
 simplesmente não fazer o login e digitar na barra de endereço do seu navegador 
o caminho para a página principal do site (sistema), burlando assim a obrigação de 
fazer um login, com isso se ele não estiver feito o login não será criado a session, 
então ao verificar que a session não existe a página redireciona o mesmo
 para a index.php.*/
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
        <h1>Hora extra!</h1>
        <form action="Extra.php" method="POST">
                    <label>Data1:</label>
                    <input type="date" name="data1" ><br><br>
                    <label>Data2:</label>
                    <input type="date" name="data2" >
            <input type="submit" value="Verificar" name="saida">
        </form>
        
   <?php
   if(!empty($_POST['data1'])){
 try {
    
$data1 = $_POST['data1'];
$data2 = $_POST['data2'];

  $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root","");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $consulta = $pdo->query("SELECT * FROM ponto WHERE (data BETWEEN '$data1' AND '$data2') AND (id_usuarios = " . $_SESSION['id_usuario'] . ")");
     echo"<table border='1' style ='whidth:100%' align='center'>"
    . "<tr align='center'>"
          . "<th>Hora1</th>"
          . "<th>Hora2</th>"
          . "<th>Data</th>"
          . "<th>id</th>"
          . "</tr>";
    while ($ver = $consulta->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr align= 'center'>"
        . "<td>" . $ver['hora1'] ."</td>"
        . "<td>" . $ver['hora2'] ."</td>"
        ."<td>" . $ver['data'] ."</td>"
        ."<td>" . $ver['id_usuarios'] ."</td>"
        ."</tr>";
       
}  echo "</table>";
  
$stmt = $pdo->prepare("select time_format( SEC_TO_TIME( SUM( TIME_TO_SEC(somatorio) ) ),'%H:%i:%s')
FROM ( SELECT hora1, hora2, time_format(ABS(TIMEDIFF (hora1,hora2)),'%H:%i:%s') as somatorio from ponto where (data 
BETWEEN :data1 and :data2)and (id_usuarios = ".$_SESSION['id_usuario'].")) as teste");
  
  //$stmt->execute();
  $stmt->execute(array(':data1' => $data1,':data2' => $data2));
  
     
  //echo $stmt->rowCount();
  $row = $stmt->fetch(PDO::FETCH_BOTH);
  echo $row[0];
  
$val1 = $row[0];
$val2 = '08:00:00';

$datetime1 = new DateTime($val1);
$datetime2 = new DateTime($val2);

if($row[0] > '08:00:00'){
    $dteDiff = $datetime1->diff($datetime2);
    echo "<br><br>"."teve hora extra:  ".$dteDiff->format("%H:%I:%S");
}
else{
  echo "<br> <br>"."Não teve hora extra!";
  
}}catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}
   }
?>
    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="js/bootstrap.min.js"></script>
        
    </body>
</html>


