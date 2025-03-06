<?php
include('../aut.php');
include('../iniSis.php');
include('../dbaSis.php');
include('../db.php');
include('../Configs.php');
include('../UtilizadoresOnline.php');
viewManager();
?>

<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
	
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <title><?php echo $nomesite; ?></title>
</head>

<body>
    <div class="dashboard-main-wrapper">
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand"><?php echo $TituloAplicacao; ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
						<li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="<?php echo $link; ?>Admin.php" >Inicio</a>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="<?php echo $link; ?>logout.php" >Sair</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <?php include('../menu.php'); ?>
			
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
				<div class="dashboard-short-list">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="card">
								<div class="card-header">
									<h5 class="mb-0">Lista das minhas sugestões do ano escolar <?php echo $anoescolar ?></h5>
									<a href="<?php echo $link . $Dir_Sugestoes_RGPC . 'SugestoesCriar.php' ?>" title="Adicionar nova sugestão">
									    <button class="btn btn-sm btn-outline-light" style="float: right;">
                                            <i class="fas fa-plus-circle"></i>
									    </button>
									</a>
								</div>
                                <div class="card-body">
                                <?php
                                    echo '<div class="card-body">';
                                    echo '<div class="table-responsive">';
                                    echo '<table id="example" class="table table-striped table-bordered second" style="width:100%">';

                                    $sql = "SELECT * FROM sugestoes_rgpc WHERE utilizador = '$IdDoUtilizador' AND id_azores_escola = '$IdAzoresEscola' ORDER BY id DESC";
                                    $result = $conn->query($sql);

                                    $sql_nome = "SELECT nome, utilizador FROM `utilizadores` WHERE id = $IdDoUtilizador";
                                    $result_nome = $conn->query($sql_nome);
                                    $row_nome = $result_nome->fetch_assoc();

                                    echo "<tr>
                                            <th style='width=10px'>Número do Ticket</th>
                                            <th>Utilizador</th>
                                            <th style='width=250px'>Descricao</th>
                                            <th>Data de Criação</th>
                                            <th>Opções</th>
                                        </tr>";

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                <td>" . $row["numero_ticket"] . "</td>
                                                <td>" . $row_nome["nome"] . "</td>
                                                <td>" . $row["descricao"] . "</td>
                                                <td>" . $row["data_de_criacao"] . "</td>
                                                <td align='center'>
                                                    <a href='" . $linkDir_Sugestao_RGPC . "Sugestoes_Responder.php?ticket=" . $row["numero_ticket"] . "'>
                                                        <button class='btn btn-sm btn-outline-light'>
                                                            <img title='Consultar esta Ticket' src='../Images/Icons/RN_parcial.png' height='17px' width='17px'/>
                                                        </button>
                                                    </a>";
                                            echo "</td>
                                            </tr>";
                                        }
                                    }
                                    
                                    echo "</table>";
                                    echo "</div>";
                                    echo "</div>";
                                ?>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
		<?php include('../rodape.php'); ?>
    </div>
  
	<script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="../assets/libs/js/main-js.js"></script>
    <script src="../assets/vendor/shortable-nestable/Sortable.min.js"></script>
    <script src="../assets/vendor/shortable-nestable/sort-nest.js"></script>
    <script src="../assets/vendor/shortable-nestable/jquery.nestable.js"></script>

</body>
</html>
