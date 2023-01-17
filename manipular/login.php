<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">



        <meta name="description" content="Source code generated using layoutit.com">
        <meta name="author" content="LayoutIt!">

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

    </head>
    <body id="corpo">




    </head>
    <style>
        #email {
            width: 100%;
        }
        #senha{
            width: 100%;
        }
        #corpo{
           background-color: #5f7f8f;
        }
        #bt{

            width: 100%;
        }

        #divCenter { 
            background-color:#B0C4DE ;
            width: 480px; 
            height: 340px; 
            border-radius: 10px;
            left: 50%;
            top: 50%;
            margin: -190px 0 0 -210px; 
            padding:10px;
            position: absolute; 
             }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-6 " id="divCenter" >
                <h1 align="center">Sistema de Controle de Ponto</h1>
                <form action="login.php"   method="POST">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Endereço de email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Senha</label>
                        <input type="password" class="form-control" id="senha" placeholder="Digite sua senha" name="senha" required>
                    </div>
                    <input type="submit"  id="bt" class="btn btn-primary" value="Login">
                </form>
            </div>
            <div class="col-md-3">
            </div>
        </div>
    </div>


    <?php
    session_start();
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
        $senha =md5($_POST['senha']);
        
        
        $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root", "");

        $consulta = $pdo->query("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");

        while ($ver = $consulta->fetch(PDO::FETCH_ASSOC)) {
            if ($email == $ver['email'] && $senha ==$ver['senha']) {
                $_SESSION['email'] = $email;
                $_SESSION['senha'] = $senha;
                $_SESSION['id_usuario'] = $ver['id_usuario'];
                $_SESSION['funcao'] = $ver['funcao'];
                $_SESSION['Nome_completo'] = $ver['Nome_completo'];
                //echo 'email'.$_SESSION['email'].'senha'.$_SESSION['senha'].'idUsuario'.$_SESSION['id_usuario'];
                if ($ver['funcao'] == 'Admin') {
                    header('location:index_adm.php');
                } else {
                    header('location:index_funci.php');
                }
            } else {
                // unset ($_SESSION['login']);
                //unset ($_SESSION['senha']);
                header('location:login.php');
            }
        }
    }
    ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>




