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
    <body id="corpo">
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
                        <a class="nav-link" href="Banco_horas_adm.php">Banco de Horas</a>
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

        <style>

            #bt{
                width: 100%;
            }
            #corpo{
                background-color: #5f7f8f;
            }
            #divCad { 
                background-color: #B0C4DE;
                width: 480px; 
                height: 680px; 
                border-radius: 10px;
                left: 50%;
                top: 50%;
                margin: -220px 0 0 -230px; 
                padding:10px;
                position: absolute; 
            }

        </style>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6 " id="divCad" >
                    <h1 align="center">Cadastro de Funcionário</h1>
                    <form action="Cadastro.php"   method="POST">
                        <div class="form-group">
                            <label>Nome Completo: </label>
                            <input type="text" name="nome" class="form-control" id="input" placeholder="Nome" required>                           
                        </div>
                        <div class="form-group">
                            <label>CPF: </label>
                            <input type="text" name="CPF" class="form-control" id="input" placeholder="CPF" required>                           
                        </div>
                        <div class="form-group">
                            <label>Data de Admissão: </label>
                            <input type="date" name="datadmi" class="form-control" id="input"  aria-describedby="inputGroupPrepend2" required>
                        </div>
                        <div class="form-group">
                            <label for="validationDefault03">Salário Contratual: </label>
                            <input type="text" name="salario" class="form-control" id="input" placeholder="Salário" required>
                        </div>
                        <div class="form-group">
                            <label for="validationDefault04">Email: </label>
                            <input type="email" name="email" class="form-control" id="input" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="inputGroupSelect01">Selecione a Função Desejada:</label>
                                </div>
                                <select name="funcao" class="custom-select" id="inputGroupSelect01">
                                    <option selected >Escolher...</option>
                                  <option value="Vendedor" required>Vendedor</option>
                                <option value="Admin" required>Admin</option>  
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="validationDefault05">Carga Horária: </label>
                            <input type="text" name="cargahora" class="form-control" id="input" placeholder="Exemplo: 8h/dia - 44h/semanais - 220h/mensais" required>
                        </div>
                        <input type="submit"  id="bt" class="btn btn-primary" value="Cadastrar">
                    </form>
                </div>
                <div class="col-md-3">
                </div>
            </div>

        </div>

        <?php
        if (!empty($_POST['nome'])) {
            $nome = $_POST['nome'];
            $CPF = $_POST['CPF'];
            $datadmi = $_POST['datadmi'];
            $salario = $_POST['salario'];
            $funcao = $_POST['funcao'];
            $email = $_POST['email'];
            $senha = md5($_POST['CPF']);
            $carga = $_POST['cargahora'];
             echo'
            <div class="alert alert-primary" role="alert">
             Entrada realizada com secesso!  
            </div>';
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->prepare("INSERT INTO usuarios(Nome_completo, CPF, "
                        . "Data_admissao, Salario_Contratual, funcao, carga_horaria, email, senha) "
                        . "VALUES ('" . $nome . "','" . $CPF . "','" . $datadmi . "','" . $salario . "','" . $funcao . "','" . $carga . "',"
                        . "'" . $email . "','" . $senha . "')");
                $stmt->execute(array(':Nome_completo' => $nome, ':CPF' => $CPF, ':Data_admissao' => $datadmi, ':Salario_Contratual' => $salario, ':funcao' => $funcao, ':carga_horaria' => $carga, ':email' => $email, ':senha' => $senha));
                echo $stmt->rowCount();
//$id = $_SESSION['id_usuarios']; 
            } catch (PDOException $e) {
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
