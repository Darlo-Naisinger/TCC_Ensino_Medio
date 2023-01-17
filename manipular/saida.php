<?php
echo "incluiu saida";

$pdo= new PDO('mysql:host=localhost;dbname=tcc', "root","");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//select Max(id) from ponto where id_usuarios=".$_SESSION['id_usuario']." group by id

$consulta = $pdo->query("select id from ponto where id_usuarios = ".$_SESSION['id_usuario']." order by id desc");
  
while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    $id = $linha['id'];
    break;
}
try {
  $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root","");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
  $hora2 = date('H:i:s');
  $stmt = $pdo->prepare('UPDATE ponto SET hora2 = :hora2 WHERE id = '.$id.'');
  $stmt->execute(array(':hora2' => "$hora2"));
     

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}