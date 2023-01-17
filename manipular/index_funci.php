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
        <script src="newjavascript.js"></script>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <meta charset="UTF-8">
        <title></title>
        <?php
        /* esse bloco de código em php verifica se existe a sessão, pois o usuário pode
          simplesmente não fazer o login e digitar na barra de endereço do seu navegador
          o caminho para a página principal do site (sistema), burlando assim a obrigação de
          fazer um login, com isso se ele não estiver feito o login não será criado a session,
          então ao verificar que a session não existe a página redireciona o mesmo
          para a index.php. */
        session_start();
        if ($_SESSION['funcao'] == 'Admin') {
            header('location:index_adm.php');
        }
        if ((!isset($_SESSION['email']) == true) and ( !isset($_SESSION['senha']) == true)) {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('location:login.php');
        }
        $logado = $_SESSION['Nome_completo'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_POST['e'])) {
            unset($_POST['e']);
            $obsentrada = $_POST['obsentrada'];
            echo '<script>
            document.getElementById("btini").style.display = "none";
        </script>';

            try {
                $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                date_default_timezone_set('America/fortaleza');
                $hora = date('H:i:s');
                $data = date('Y:m:d');

                $stmt = $pdo->prepare('INSERT INTO ponto (hora1 , data, id_usuarios,obs_entra) VALUES(:hora1, :data, :id_usuarios,:obs_entra)');
                $stmt->execute(array(':hora1' => "$hora", ':data' => "$data", ':id_usuarios' => $_SESSION['id_usuario'], ':obs_entra' => "$obsentrada"));

                $stmt = $pdo->prepare('UPDATE usuarios SET ultima_op = :op WHERE id_usuario = ' . $_SESSION['id_usuario'] . '');
                $stmt->execute(array(':op' => "e"));
//$id = $_SESSION['id_usuarios'];
                echo'
            <div class="alert alert-primary" role="alert">
             Entrada realizada com secesso!  
            </div>';
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST' & isset($_POST['s'])) {
            unset($_POST['s']);

            $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//select Max(id) from ponto where id_usuarios=".$_SESSION['id_usuario']." group by id

            $consulta = $pdo->query("select id from ponto where id_usuarios = " . $_SESSION['id_usuario'] . " order by id desc");
            echo'
            <div class="alert alert-primary" role="alert">
             Saída realizada com secesso! 
            </div>';
            while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
                $id = $linha['id'];
                break;
            }
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              
               date_default_timezone_set('America/fortaleza');
                $hora2 = date('H:i:s');

                $stmt = $pdo->prepare('UPDATE ponto SET hora2 = :hora2 WHERE id = ' . $id . '');
                $stmt->execute(array(':hora2' => "$hora2"));

                
                $stmt = $pdo->prepare('UPDATE usuarios SET ultima_op = :op WHERE id_usuario = ' . $_SESSION['id_usuario'] . '');
                $stmt->execute(array(':op' => "s"));
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
        ?>

    </head>
    <body  id="corpo" onload="relogio();">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index_funci.php">SDCP</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
            </button>
            <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index_funci.php">Home <span class="sr-only">(página atual)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Banco_horas_funci.php">Banco de Horas</a>
                    </li>
                    <form class="form-inline my-3 my-lg-0"> 
                        <?php
                        echo"<span style='color: #FFF;'>&nbsp Olá $logado &nbsp &nbsp &nbsp</span>";
                        ?>                   
                    </form>
                </ul>
                <form class="form-inline my-2 my-lg-0">
                    <?php
                    echo '<a href="sair.php" class="btn btn-danger">Sair</a> '
                    ?>
                </form> 
            </div>
        </nav>
        <div id="relogio"></div>
        <script type="text/javascript">
            function relogio() {
                var data = new Date();
                var horas = data.getHours();
                var minutos = data.getMinutes();
                var segundos = data.getSeconds();

                if (horas < 10) {
                    horas = "0" + horas;
                }
                if (minutos < 10) {
                    minutos = "0" + minutos;
                }
                if (segundos < 10) {
                    segundos = "0" + segundos;
                }

                document.getElementById("relogio").innerHTML = horas + ":" + minutos + ":" + segundos;
            }
            window.setInterval("relogio()", 1000);


        </script>
        <style type="text/css">
            #relogio {
                font:bold 28pt arial;
                display: block;
                margin: 50px auto;
                padding: 30px;
                background-color: #B0C4DE;
                width: 215px;
                border-radius: 6px;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, .5);}
            #btentr{
                margin-right: 100px  
            }
            nav a img {
                width: 50px;
                padding: 5px;
            }
            #corpo {
                background-color: #5f7f8f;
            }
            #table{
                background-color:#B0C4DE;

                width: 80%;  

            }
            #btini{
                margin: 20px auto;
            }
        </style> 

        <?php
        $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("select ultima_op from usuarios where id_usuario = '$_SESSION[id_usuario]'");

//$stmt->execute();
        $stmt->execute();


        $row = $stmt->fetch(PDO::FETCH_OBJ);
        ?>

        <?php if ($row->ultima_op == 'e'): ?>

            <div id="btini" align="center">
                <form action="index_funci.php" method="POST">
                    <input type="submit" class="btn btn-danger" name="s"  value="Saída"/>
            </div>

        <?php else: ?>

            <div id="btini" align="center">
                <form action="index_funci.php" method="POST">
                    <input type="submit" id="btentr" class="btn btn-primary" name="e" value="Entrar"/><br><br>
                    <h3>Justificativas</h3>
                    <textarea name="obsentrada"></textarea>
                </form>    
            </div>

        <?php endif ?>




        <?php
        $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $consulta = $pdo->query("SELECT * FROM ponto WHERE (id_usuarios = " . $_SESSION['id_usuario'] . ") order by id desc");

        echo' <table id="table"  align="center" class="table table-hover">
  <thead>
    <tr align="center">
      <th scope="col">Dia</th>
      <th scope="col">Entrada</th>
      <th scope="col">Saída</th>
      <th>Justificativas</th>
    </tr>
  </thead>';
        $contador = 0;
        while ($ver = $consulta->fetch(PDO::FETCH_ASSOC)) {
            if ($ver['hora2'] === '00:00:00') {
                $hora2exibir = '--';
            } else {
                $hora2exibir = $ver['hora2'];
            }
            if ($ver['obs_entra'] === '') {
                $obs_entra = '--';
            } else {
                $obs_entra = $ver['obs_entra'];
            }
           
            echo"<tbody>"
            . "<tr align= 'center'>"
            . "<td>" . date("d/m/Y", strtotime($ver['data'])) . "</td>"
            . "<td>" . $ver['hora1'] ."</td>"
            . "<td>" . $hora2exibir ."</td>"
            . "<td>" . $obs_entra . "</td>"
            . "</tr>"
            . "</tbody>";
            $contador++;
            if ($contador == 4) {
                break;
            }
        }echo "</table>";
        ?>
        <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
        <script src="js/bootstrap.min.js"></script>
    </body>          
</html>
