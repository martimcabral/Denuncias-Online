<?php
include('../aut.php');
include('../iniSis.php');
include('../dbaSis.php');
include('../db.php');
include('../Configs.php');
include('../RegistoSms.php');
include('../RegistoEmails.php');
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
							<a class="nav-link nav-user-img" href="<?php echo $link.$Dir_Denuncias; ?>Denuncias.php">Voltar</a>
                        </li>
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
                                  <h5 class="card-header">Denúncias</h5>
                                    <div class="card-body"> 
										<form action="Denuncias_EnviarResposta.php" multipart="/form-data" method="POST">	
                                            <input hidden type="text" value="<?php echo $IdDoUtilizador?>" name="Utilizador">
                                            <input hidden type="text" value="<?php echo $IAnoSelecionado?>" name="AnoEscolar">
                                            <input hidden type="text" value="<?php echo $_GET['ticket']?>" name="ticket">
                                            <?php 
                                                $ESTADO_TICKET = $_GET['ticket'];
                                                $stmt = $conn->prepare("SELECT * FROM denuncias WHERE numero_ticket = ?");
                                                $stmt->bind_param("i", $ESTADO_TICKET);
                                                $stmt->execute();
                                                $result = $stmt->get_result();
                                                $row = $result->fetch_assoc();
                                            ?>
                                            <div class="form-group">
                                                <label for="inputText3" class="col-form-label">Decreva a Denúncia</label>
                                                <textarea readonly name="descricao" class="form-control" rows="10" id="des" required style="resize: none;" maxlength="3000"><?php echo htmlspecialchars($row['descricao']); ?></textarea>
                                            </div>
                                            <div class="form-group">
												<label for="inputText3" class="col-form-label">Decreva a Resposta</label>
                                                <textarea <?php if ($row["resposta"] != null) echo 'readonly'?> name="resposta" class="form-control" rows="10" id="des" required style="resize: none;" maxlength="3000"><?php echo $row['resposta']?></textarea>
											</div>
											<div class="col-sm-6 pl-0">
												<p class="text-right">
                                                <?php if ($row["resposta"] != null) echo "<p>Fechado a: " . $row["data_fechado"]?>
                                                <?php if ($row["resposta"] == null) echo '<button type="submit" name="gravar_novo_ticket" class="btn btn-space btn-primary">Inserir Resposta</button>'?>
												</p>
											</div>	
										</form>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
                </div>
            </div>
		<?php  include('../rodape.php'); ?>
        </div>
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