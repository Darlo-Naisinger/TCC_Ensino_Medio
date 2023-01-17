
<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <meta charset="UTF-8">
        <title></title>
        <?php
        session_start();
        if ($_SESSION['funcao'] == 'Vendedor') {
            header('location:Banco_horas_funci.php');
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
        <div id="piechart" style="width: 463px; height: 500px;"></div>
        <style>

            #bt{
                width: 100%;
            }
            #corpo{
                background-color: #5f7f8f;  
            }
            #divbancohora { 
                background-color:#B0C4DE ;
                width: 480px; 
                height: 380px; 
                border-radius: 10px;
                left: 50%;
                top: 50%;
                margin: -200px 0 0 -210px; 
                padding:10px;
                position: absolute; 
            }
            #table{
                background-color:#B0C4DE;
                width: 80%; 
            }
        </style>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-6 " id="divbancohora" >
                    <h1 align="center">Banco de Horas</h1>
                    <form action="Banco_horas_adm.php"   method="POST">
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o Nome">
                        </div>
                        <div class="form-group">
                            <label >Primeira Data: </label>
                            <input type="date" class="form-control" id="data1" name="data1">
                        </div>
                        <div class="form-group">
                            <label >Segunda Data:</label>
                            <input type="date" class="form-control" id="data2" name="data2">
                        </div>
                        <input type="submit"  id="bt" class="btn btn-primary" value="Consultar">
                    </form>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
        <?php
        if (!empty($_POST['nome'])) {
            try {
                $nome = $_POST['nome'];
                $data1 = $_POST['data1'];
                $data2 = $_POST['data2'];

                $pdo = new PDO('mysql:host=localhost;dbname=tcc', "root", "");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $consulta = $pdo->query("SELECT * FROM ponto,usuarios WHERE ( data BETWEEN '$data1' AND '$data2' )
                AND ponto.id_usuarios = usuarios.id_usuario and usuarios.Nome_completo = '$nome'");

                if ($consulta->rowCount() > 0) {

                    echo"<table class='table table-hover' id='table' style ='whidth:100%' align='center'>"
                    . "<tr align='center'>"
                    . "<th>Nome</th>"
                    . "<th>Data</th>"
                    . "<th>Entrada</th>"
                    . "<th>Saída</th>"
                    . "<th>Justificativas</th>"
                    . "</tr>";
                 
                    while ($ver = $consulta->fetch(PDO::FETCH_ASSOC)) {
                        
                        $teste = $ver['id_usuario'];
                        
                        if(!isset($ver['hora2'])){
                            $hora2exibir = '--';
                        }else{
                            $hora2exibir = $ver['hora2'];
                        }
                         if ($ver['obs_entra'] === '') {
                        $obs_entra = '--';
                    } else {
                        $obs_entra = $ver['obs_entra'];
                    }
          
                        
                        echo "<tr align= 'center'>"
                        . "<td>" . $ver['Nome_completo'] . "</td>"
                        . "<td>" . date("d/m/Y",strtotime($ver['data']))."</td>"
                        . "<td>" . $ver['hora1'] . "</td>"
                        . "<td>" . $hora2exibir . "</td>"
                        . "<td>" . $obs_entra . "</td>"         
                        . "</tr>";
                    } echo "</table>";
                    $stmt = $pdo->prepare("select time_format( SEC_TO_TIME( SUM( TIME_TO_SEC(somatorio) ) ),'%H:%i:%s')
FROM ( SELECT hora1, hora2, time_format(ABS(TIMEDIFF (hora1,hora2)),'%H:%i:%s') as somatorio from ponto where (data 
BETWEEN :data1 and :data2)and (id_usuarios = '$teste')) as teste");

                    //$stmt->execute();
                    $stmt->execute(array(':data1' => $data1, ':data2' => $data2));


                    $row = $stmt->fetch(PDO::FETCH_BOTH);

                    echo "<center> <h3>" . "Total de horas: " . $row[0] . "</h3></center>";
                    $calculo = 220 - (int) $row[0];
                } else {
                    echo '<div class="alert alert-danger" role="alert">';
                    echo "Nenhum registro para este intervalo!";
                    echo '</div>';
                }
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
                     ['Não trabalhadas', falta],
                    ['Horas trabalhadas', fez],
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


