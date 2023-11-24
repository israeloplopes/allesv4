<?php
try{
    if (session_status() !== PHP_SESSION_ACTIVE) {
  	session_start();
	  }

	if (!isset($_SESSION['usuario'])){
	header('location: pages/samples/login.php');
	exit();
	}

	date_default_timezone_set('America/Sao_Paulo');
    include 'db/conexao.php';
	include 'db/dados.php';

	foreach ($rs_sgfilial as $sgfilial);
	foreach ($rs_sgversao as $sgversao);
	foreach ($rs_sgsistema as $sgsistema);		
	
	$hr = date(" H ");
	$temposervidor = 5;
	//$hr = (int)$hr - (int)$temposervidor;
	if($hr >= 12 && $hr<18) {
		$resp = "Boa tarde";}
	else if ($hr >= 0 && $hr <12 ){
		$resp = "Bom dia";}
	else {
		$resp = "Boa noite";}
	
	$conexao = conexao::getInstance();
	$qry_fntiporestr = 'select * from fntiporestr where codemp=:empcod';
	$dts_fntiporestr = $conexao->prepare($qry_fntiporestr);
	$dts_fntiporestr->bindvalue(':empcod',$_SESSION['codemp']);
	$dts_fntiporestr->execute();
	$rs_fntiporestr = $dts_fntiporestr->fetchAll(PDO::FETCH_OBJ);
} catch (Exception $e) {
    	// Algo deu errado, redirecione para a página de erro
    	header("Location: error/index.html");
    	exit; // Certifique-se de sair após o redirecionamento
	}	
	
?>	

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=$sgsistema->nomesistema;?> - <?=$sgfilial->razfilial;?> - <?=$_SESSION['usuario'];?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!--<link href="vendors/advanced-datatable/css/demo_page.css" rel="stylesheet" />-->
    <link href="vendors/advanced-datatable/css/demo_table.css" rel="stylesheet" />
    <!--<link rel="stylesheet" href="vendors/advanced-datatable/css/DT_bootstrap.css" />-->
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" <!-- End layout styles -->
    <link rel="shortcut icon" href="images/favicon.png" />
	<style>
		/* CSS para posicionar o seletor no canto superior direito da tabela */
		.dataTables_length {
			position: absolute;
			right: 100px; /* Ajuste conforme necessário */
			top: 15px;
		}
	</style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
		<div class="navbar-brand-wrapper d-flex align-items-center">
          <a class="navbar-brand brand-logo" href="index.php">
            <img src="images/logo-nome.png" alt="logo" class="logo-dark" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="index.php"><img src="images/logo.png" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
          <h5 class="mb-0 font-weight-medium d-none d-lg-flex">Oi <?=$_SESSION['usuario'];?>, <?=$resp?>!</h5>
          <ul class="navbar-nav navbar-nav-right ml-auto">
            <form class="search-form d-none d-md-block" action="#">
              <i class="icon-magnifier"></i>
              <input type="search" class="form-control" placeholder="O que deseja?" title="Sua busca">
            </form>
			<!-- INICIO MENU SUPORTE -->
			<?php include "menu_suporte.php" ?>
			<!-- FIM MENU SUPORTE -->
			
			<!-- INICIO MENU PERFIL -->
			<?php include "menu_perfil.php" ?>
			<!-- FIM MENU PERFIL -->
												
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
		<!-- INICIO MENU USUARIO -->
			<?php include "menu_usuario.php" ?>
			<!-- FIM MENU USUARIO -->

           <!-- MENU --> 
		   <?php include "menu.php" ?>
		   <!-- FIM MENU --> 
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Tipo de Restrição</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <!--<li class="breadcrumb-item"><a href="fr_fntiporestr.php" target="_self">Insere</a></li>
                  <!--<li class="breadcrumb-item active" aria-current="page">Basic tables</li>-->
				  <li class="breadcrumb-item active"><button type="button" class="btn btn-primary btn-rounded btn-fw"><a href="frm_fntiporestr.php?ID=0&amp;TP=0">Insere</a></button><li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Consulta Tipo de Restrição</h4>
                    <p class="card-description"><small> Utilize o campo <b>Buscar</b> para filtrar</small>
                    </p>
                    <div class="table-responsive">
                    <table id="hidden-table-info" class="table table-striped table-bordered"> 
                      <thead>
                        <tr>
                          <th> ID </th>
                          <th> Cód. Tp. Restr</th>
                          <th> Descrição </th>
						  <th> Bloqueia? </th>
						  <th> Ação </th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php if(!empty($rs_fntiporestr)):?>
					  <?php foreach($rs_fntiporestr as $fntiporestr):?>
                        <tr>
                          <td class="py-1">
							<?=$fntiporestr->id?>
                            <!--<img src="images/faces-clipart/pic-1.png" alt="image" />-->
                          </td>
                          <td><?=$fntiporestr->codtprestr?></td>
                          <td>
                            <!--<div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>-->
							<?=$fntiporestr->desctprestr?>
                          </td>
						  <td><?=$fntiporestr->bloqtprestr?></td>
                          <td>
							<button type="button" class="btn btn-warning btn-rounded btn-fw"><a href="frm_fntiporestr.php?id=<?=$fntiporestr->id?>&amp;TP=1">Edita</a></button>
              <form action="pages/forms/act_fntiporestr.php" class="form-horizontal style-form" name="excluir" id="excluir" method="post">
									<input type="hidden" name="acao"  value="excluir">
                  <input type="hidden" name="id"    value="<?=$fntiporestr->id?>">
									<button type="submit" class="btn btn-danger btn-rounded btn-fw">Exclui</button>
								</form>						  </td>
                          <!--<td></td>-->
                        </tr>
                        <?php endforeach;?>	
                      </tbody>
                    </table>
					<?php else: ?>
						<h4><i class="fa fa-angle-right"></i> Não há dados localizados</h4>
					<?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
		  
          <!-- INICIO RODAPÉ -->
		  <?php include "footer.php" ?>
		  <!-- FIM RODAPE -->
		  
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
	<!-- jQuery -->
<script src="vendors/advanced-datatable/js/jquery.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="vendors/advanced-datatable/css/jquery.dataTables.css">
<script src="vendors/advanced-datatable/js/jquery.dataTables.js"></script>

<!-- DataTables Bootstrap -->
<script src="vendors/advanced-datatable/js/DT_bootstrap.js"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- Custom JavaScript -->
	<script type="text/javascript">
        $(document).ready(function() {
	        var table = $('#hidden-table-info').DataTable({
                "paging": true,
                "pageLength": 10,
                "searching": true,
	            "order": [[1, 'asc']]
            });
        });
    </script>
</body>
</html>