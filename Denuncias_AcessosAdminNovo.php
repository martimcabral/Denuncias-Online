<?php
include('../aut.php');
include('../iniSis.php');
include('../dbaSis.php');
include('../Configs.php');
include('../UtilizadoresOnline.php');
viewManager();

if ($modulo_participacoes_diciplinares == 1){
	
		if (isset($_POST['tipoUtilizador']))
			$idTipoUtilizador = $_POST['tipoUtilizador'];

		if (isset($_POST['InserirNovoDocenteTurma'])){ 
			$IdDoUtilizadorADD 				= $_POST['docentes'];
			$MudarAcesso['sugestoes_ce'] 	= '1';
			update('permissoes',$MudarAcesso, "id_utilizador = '$IdDoUtilizadorADD'");
			echo "<script>alert('Utilizador associado com sucesso!');window.location.href='".$link.$Dir_Sugestoes."AcessoSugestoesAdmin.php';</script>";			
		}
?>


<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
	
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/circular-std/style.css">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
	<link rel="stylesheet" href="../assets/vendor/inputmask/css/inputmask.css" />
    <title><?php echo $nomesite; ?></title>
</head>

<body>

    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand"><?php echo $TituloAplicacao; ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                       <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="<?php echo $link.$Dir_Sugestoes; ?>AcessoSugestoesAdmin.php">Voltar</a>
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
		<form name="update" enctype="multipart/form-data" method="POST">
            <div class="container-fluid dashboard-content">
				<div class="dashboard-short-list">
			            <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                               
                                <div class="card">
                                    <h5 class="card-header">Adicionar novo utilizador ao Gabinete</h5>
                                    <div class="card-body">
											<div class="form-group">
											    <label for="inputText3" class="col-form-label">Selecione o tipo de utilizador</label>
												<select class="form-control" name="tipoUtilizador" onchange="submit();" required>
												<?php
													if ($idTipoUtilizador == 1){
														echo '<option value="1" selected>Docente</option>';
														echo '<option value="2">Não Docente</option>';
													}elseif($idTipoUtilizador == 2){
														echo '<option value="1">Docente</option>';
														echo '<option value="2" selected>Não Docente</option>';
													}else{
														echo '<option value = "">Selecione um utilizador</option>';
														echo '<option value="1" >Docente</option>';
														echo '<option value="2">Não Docente</option>';
													}	
												?>		
												</select>
											</div>
											
										<?php	if (!empty($idTipoUtilizador)){ 
										
													if ($idTipoUtilizador == 1){ ?>
											
														<div class="form-group">
															<label for="inputText3" class="col-form-label">Selecione um docente</label>
															<select class="form-control" name="docentes" required>
																<option value ="" selected="selected" >Selecione uma opção</option>
															<?php
																$ReadTodosOsDocentes = read('professores',"where ativo = '1' and id_azores_escola = '$IdAzoresEscola' order by nome ASC");
																foreach($ReadTodosOsDocentes as $TodosOsDocentes):
																	$IdDocenteCorrido = $TodosOsDocentes['id'];
																	
																	$ReadNumeroIdDaTabela = read('utilizadores',"where idutilizador = '$IdDocenteCorrido' and tipocontatos = 1 and id_azores_escola = '$IdAzoresEscola'");
																	foreach($ReadNumeroIdDaTabela as $NumeroIdDaTabela);
																	$IdDocenteValida = $NumeroIdDaTabela['id'];
																	
																	$ExisteJaAssociado = read('permissoes',"where id_utilizador = '$IdDocenteValida' and sugestoes_ce = 1 and id_azores_escola = '$IdAzoresEscola'");
																	if ($ExisteJaAssociado)
																		echo '<option value = "'.$IdDocenteValida.'" disabled style="background-color: #FFCCCC;">'.$TodosOsDocentes['nome'].'</option>';
																	else
																		echo '<option value = "'.$IdDocenteValida.'">'.$TodosOsDocentes['nome'].'</option>';
																endforeach;
															?>		
															</select>
														</div>	
													<?php }elseif($idTipoUtilizador == 2){ ?>
															
															<div class="form-group">
																<label for="inputText3" class="col-form-label">Selecione um não docente</label>
																<select class="form-control" name="docentes" required>
																	<option value ="" selected="selected" >Selecione uma opção</option>
																<?php
																	$ReadTodosOsDocentes = read('assistentesoperacionais',"where ativo = '1' and id_azores_escola = '$IdAzoresEscola' order by nome ASC");
																	foreach($ReadTodosOsDocentes as $TodosOsDocentes):
																		$IdDocenteCorrido = $TodosOsDocentes['id'];
																		
																		$ReadNumeroIdDaTabela = read('utilizadores',"where idutilizador = '$IdDocenteCorrido' and tipocontatos = 2 and id_azores_escola = '$IdAzoresEscola'");
																		foreach($ReadNumeroIdDaTabela as $NumeroIdDaTabela);
																		$IdDocenteValida = $NumeroIdDaTabela['id'];
																	
																		$ExisteJaAssociado = read('permissoes',"where id_utilizador = '$IdDocenteValida' and sugestoes_ce = 1 and id_azores_escola = '$IdAzoresEscola'");
																		if ($ExisteJaAssociado)
																			echo '<option value = "'.$IdDocenteValida.'" disabled style="background-color: #FFCCCC;">'.$TodosOsDocentes['nome'].'</option>';
																		else
																			echo '<option value = "'.$IdDocenteValida.'">'.$TodosOsDocentes['nome'].'</option>';
																	endforeach;
																?>		
																</select>
															</div>
													<?php  } ?>
											
													   <br><br>
														<div class="col-sm-6 pl-0">
															<p class="text-right">
																<button type="submit" name="InserirNovoDocenteTurma" class="btn btn-space btn-primary">Associar esse utilizador</button>
																
															</p>
														</div>	
											
										<?php } ?>	
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>  
            </div>
			</form>
       
  
			<?php include('../rodape.php'); ?>
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


<?php 

	}else{header('location: '.$link.'Admin.php');}  

?>