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

        if ($_SESSION['funcao'] == 'Vendedor') {
            header('location:index_funci.php');
        }
        if ((!isset($_SESSION['email']) == true) and ( !isset($_SESSION['senha']) == true)) {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('location:login.php');
        }
        $logado = $_SESSION['Nome_completo'];
        ?>
    </head>
    
    <body id="body">
        <style>
            #nom_sis{
                margin: 20%;
            }
            #body{
                background-color: #B0C4DE;
            }
        </style>
        <nav  class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index_adm.php">SDCP</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
            </button>
            <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index_adm.php">Home <span class="sr-only">(página atual)</span></a>
                    </li>  
                        <li class="nav-item">
                        <a class="nav-link" href="Cadastro.php">Cadastrar</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="Banco_horas_adm.php">Banco de horas</a>
                    </li>
                    <form class="form-inline my-3 my-lg-0">
                        <?php
                        echo"<span style='color: #FFF;'>&nbsp Olá Admin $logado &nbsp &nbsp &nbsp</span>";
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
        <h1 id="nom_sis" align='center'>Sistema de Controle de Ponto - SDCP</h1>
        <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
        <script src="js/bootstrap.min.js"></script>
    </body>          
</html>
