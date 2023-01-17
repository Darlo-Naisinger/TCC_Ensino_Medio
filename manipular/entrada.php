<?php
echo "incluiu entrada";

        
session_start();
try {
  $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root","");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
  $hora = date('H:i:s');
  $data = date('Y:m:d');
  
  $stmt = $pdo->prepare('INSERT INTO ponto (hora1 , data, id_usuarios) VALUES(:hora1, :data, :id_usuarios)');
 $stmt->execute(array(':hora1' => "$hora", ':data' => "$data", ':id_usuarios' => $_SESSION['id_usuario']));
 
//$id = $_SESSION['id_usuarios'];
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}