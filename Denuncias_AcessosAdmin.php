<?php
include('../aut.php');
include('../iniSis.php');
include('../dbaSis.php');
include('../db.php');
include('../Configs.php');
include('../UtilizadoresOnline.php');
viewManager();

if ($modulo_participacoes_diciplinares == 1){

		if(!empty($_GET['eliminar'])){
			$IdDoDelete = $_GET['eliminar'];
			$MudarDelete['sugestoes_ce'] = '0';
			update('permissoes',$MudarDelete, "id = '$IdDoDelete'");
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
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
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
			        <?php
					$stmt1 = $conn->prepare("SELECT * FROM permissoes WHERE id_azores_escola = ? AND sugestoes_ce = 1");
					if ($stmt1 === false) {
						Informacao('Requisicoes/requesicoes_emprestimos_novo.php', 'alert-warning', 'Erro na preparação da consulta! ', $conn->error, 'btn-danger', 'OK');
						exit();
					}
					$stmt1->bind_param("s", $IdAzoresEscola);
					if (!$stmt1->execute()) {
						Informacao('Requisicoes/requesicoes_emprestimos_novo.php', 'alert-warning', 'Erro na execução da consulta! ', $stmt1->error, 'btn-danger', 'OK');
						exit();
					}
					$result1 = $stmt1->get_result();
					$ReadTodasAcessoGabinete = $result1->fetch_all(MYSQLI_ASSOC);
					$stmt1->close();

					$UsuariosCompletos = [];

					if ($ReadTodasAcessoGabinete) {
						foreach ($ReadTodasAcessoGabinete as $TodasAcessoGabinete) {
							$IdDoUtilizadorSelecionado 	= $TodasAcessoGabinete['id_utilizador'];
							$IdPermissao 				= $TodasAcessoGabinete['id']; 

							$stmt2 = $conn->prepare("SELECT * FROM utilizadores WHERE id = ? AND id_azores_escola = ?");
							if ($stmt2 === false) {
								Informacao('Requisicoes/requesicoes_emprestimos_novo.php', 'alert-warning', 'Erro na preparação da consulta! ', $conn->error, 'btn-danger', 'OK');
								exit();
							}
							$stmt2->bind_param('ss', $IdDoUtilizadorSelecionado, $IdAzoresEscola);
							if (!$stmt2->execute()) {
								Informacao('Requisicoes/requesicoes_emprestimos_novo.php', 'alert-warning', 'Erro na execução da consulta! ', $stmt2->error, 'btn-danger', 'OK');
								exit();
							}
							$result2 = $stmt2->get_result();
							$InformacoesUtilizador = $result2->fetch_assoc();
							$stmt2->close();

							if ($InformacoesUtilizador) {
								$TipoContacto = $InformacoesUtilizador['tipocontatos'];
								$IdDoUtilizadorConsult = $InformacoesUtilizador['idutilizador'];

								if ($TipoContacto == 1) {
									$stmt3 = $conn->prepare("SELECT * FROM professores WHERE id = ? AND id_azores_escola = ?");
								} else {
									$stmt3 = $conn->prepare("SELECT * FROM assistentesoperacionais WHERE id = ? AND id_azores_escola = ?");
								}
								if ($stmt3 === false) {
									Informacao('Requisicoes/requesicoes_emprestimos_novo.php', 'alert-warning', 'Erro na preparação da consulta! ', $conn->error, 'btn-danger', 'OK');
									exit();
								}
								$stmt3->bind_param('ss', $IdDoUtilizadorConsult, $IdAzoresEscola);
								if (!$stmt3->execute()) {
									Informacao('Requisicoes/requesicoes_emprestimos_novo.php', 'alert-warning', 'Erro na execução da consulta! ', $stmt3->error, 'btn-danger', 'OK');
									exit();
								}
								$result3 = $stmt3->get_result();
								$AcessoDadosUtilizador = $result3->fetch_assoc();
								$stmt3->close();

								if ($AcessoDadosUtilizador) {
									$UsuariosCompletos[] = array_merge($TodasAcessoGabinete, $InformacoesUtilizador, $AcessoDadosUtilizador,['id_permissao' => $IdPermissao]);
								}
							}
						}
					}

		
					usort($UsuariosCompletos, function($a, $b) {
						return strcmp($a['nome'], $b['nome']);
					});

					echo '<div class="row">';
					echo '<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">';
					echo '<div class="card">';
					echo '<div class="card-header">';
					echo '<h5 class="mb-0">Acesso ao Gabinete';
					echo '<a href="'.$link.$Dir_Sugestoes.'AcessoSugestoesAdminNovo.php" title="Adicionar novo Utilizador" >';
					echo '<button class="btn btn-sm btn-outline-light" style="float: right;" >';
					echo '<i class="fas fa-plus-circle"></i>';
					echo '</button>';
					echo '</a>';
					echo '</h5>';
					echo '</div>';
					echo '<div class="card-body">';
					echo '<div class="table-responsive">';
					echo '<table id="example" class="table table-striped table-bordered second" style="width:100%">';
					echo '<thead>';
					echo '<tr align=center>';
					echo '<th align="center">Numero</th>';
					echo '<th align="center">ID</th>';
					echo '<th align="center">Foto</th>';
					echo '<th align="center">Nome</th>';
					echo '<th align="center">Opções</th>';
					echo '</tr>';
					echo '</thead>';
					echo '<tbody>';

					$cont = 0;
					foreach ($UsuariosCompletos as $usuario) {
						$cont++;
						echo '<tr>';
						echo '<td align="center">' . $cont . '</td>';
						echo '<td align="center">' . $usuario['id'] . '</td>';
						echo '<td align="center" title="' . $usuario['foto'] . '">';
						if (!empty($usuario['foto'])) {
							echo '<img src="' . $Dir_antes . $Dir_Imagems . $Dir_FotografiasNeDocentes . $IdAzoresEscola . '/' . $usuario['foto'] . '?id=' . $IdFotoNova . '" height="100" width="100">';
						} else {
							echo '<img src="' . $Dir_antes . $Dir_Imagems . $Dir_FotografiasNeDocentes . 'semfoto.jpg?id=' . $IdFotoNova . '" height="100" width="100">';
						}
						echo '</td>';
						echo '<td align="center">' . $usuario['nome'] . '</td>';
						echo '<td align="center">';
						echo '<a href="' . $link . $Dir_Sugestoes . 'AcessoSugestoesAdmin.php?eliminar=' . $usuario['id_permissao'] . '" title="Eliminar">';
						echo '<button class="btn btn-sm btn-outline-light">';
						echo '<font color="#FF0000"><i class="fas fa-trash"></font></i>';
						echo '</button>';
						echo '</a>';
						echo '</td>';
						echo '</tr>';
					}

					echo '</tbody>';
					echo '</table>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';
					echo '</div>';

					?>
					
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


<?php 
}else{header('location: '.$link.'Admin.php');}  

?>