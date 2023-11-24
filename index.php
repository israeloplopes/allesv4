<?php
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
	include 'db/functions.php';

    foreach ($rs_sgfilial as $sgfilial);
	foreach ($rs_sgversao as $sgversao);


	$hr = date(" H ");
	$temposervidor = 5;
	//$hr = (int)$hr - (int)$temposervidor;
	if($hr >= 12 && $hr<18) {
		$resp = "Boa tarde";}
	else if ($hr >= 0 && $hr <12 ){
		$resp = "Bom dia";}
	else {
		$resp = "Boa noite";}
		
	///////////////////////////////////
	// carrega recados
	///////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_sgrecado = 'select * from sgrecado where codemp=:empcod and lido=:foi order by codrecado desc';
	$dts_sgrecado = $conexao->prepare($qry_sgrecado);
	$dts_sgrecado->bindvalue(':empcod',$_SESSION['codemp']);
	$dts_sgrecado->bindvalue(':foi','N');	
	$dts_sgrecado->execute();
	$rs_sgrecado = $dts_sgrecado->fetchAll(PDO::FETCH_OBJ);	
	
	///////////////////////////////////
	// conta quantas tarefas
	///////////////////////////////////	
	$conexao = conexao::getInstance();
	$qry_attarefa = 'select count(id) AS qtdtarefa, att.* from attarefa as att where att.codemp=:p1 and att.idusuoutro=:p2';
	$dts_attarefa = $conexao->prepare($qry_attarefa);
	$dts_attarefa->bindvalue(':p1',$_SESSION['codemp']);
	$dts_attarefa->bindvalue(':p2',$_SESSION['id']);	
	$dts_attarefa->execute();
	$rs_attarefa  = $dts_attarefa->fetch(PDO::FETCH_OBJ);	
	$conta_tarefa = $rs_attarefa->qtdtarefa;
	
	$hoje = date('Y-m-d');
	
	///////////////////////////////////
	// conta quantas tarefas atrasadas
	///////////////////////////////////	
	$conexao = conexao::getInstance();
	$qry_attar_atrasada = 'select count(id) AS qtdtar_atrasada, att.* from attarefa as att where att.codemp=:p1 and att.idusuoutro=:p2 and att.data>=:p3 and status<>:p4';
	$dts_attar_atrasada = $conexao->prepare($qry_attar_atrasada);
	$dts_attar_atrasada->bindvalue(':p1',$_SESSION['codemp']);
	$dts_attar_atrasada->bindvalue(':p2',$_SESSION['id']);	
	$dts_attar_atrasada->bindvalue(':p3',$hoje);
	$dts_attar_atrasada->bindvalue(':p4','F');	
	$dts_attar_atrasada->execute();
	$rs_attar_atrasada  = $dts_attar_atrasada->fetch(PDO::FETCH_OBJ);	
	$conta_tar_atrasada = $rs_attar_atrasada->qtdtar_atrasada;
	
	///////////////////////////////////
	// conta quantas finalizadas
	///////////////////////////////////		
	$conexao = conexao::getInstance();
	$qry_attar_finalizada = 'select count(id) AS qtdtar_finalizada, att.* from attarefa as att where att.codemp=:p1 and att.idusuoutro=:p2 and status=:p4';
	$dts_attar_finalizada = $conexao->prepare($qry_attar_finalizada);
	$dts_attar_finalizada->bindvalue(':p1',$_SESSION['codemp']);
	$dts_attar_finalizada->bindvalue(':p2',$_SESSION['id']);	
	$dts_attar_finalizada->bindvalue(':p4','F');	
	$dts_attar_finalizada->execute();
	$rs_attar_finalizada  = $dts_attar_finalizada->fetch(PDO::FETCH_OBJ);	
	$conta_tar_finalizada = $rs_attar_finalizada->qtdtar_finalizada;
	/*echo "<pre>";print_r($conta_tarefa); echo "</pre>"; exit;	*/
	
	///////////////////////////////////
	// conta quantas tarefas pendentes
	///////////////////////////////////			
	$conexao = conexao::getInstance();
	$qry_attar_pendente = 'select count(id) AS qtdtar_pendente, att.* from attarefa as att where att.codemp=:p1 and att.idusuoutro=:p2 and att.data<=:p3 and status<>:p4';
	$dts_attar_pendente = $conexao->prepare($qry_attar_pendente);
	$dts_attar_pendente->bindvalue(':p1',$_SESSION['codemp']);
	$dts_attar_pendente->bindvalue(':p2',$_SESSION['id']);	
	$dts_attar_pendente->bindvalue(':p3',$hoje);
	$dts_attar_pendente->bindvalue(':p4','F');	
	$dts_attar_pendente->execute();
	$rs_attar_pendente  = $dts_attar_pendente->fetch(PDO::FETCH_OBJ);	
	$conta_tar_pendente = $rs_attar_pendente->qtdtar_pendente;
	
	///////////////////////////////////
	// Soma valor total das vendas
	///////////////////////////////////		
	$conexao = conexao::getInstance();
	$qry_total_vendas = 'select sum(vlrvenda) AS totalvenda from vdvenda where codemp=:p1 and dtemitvenda=:p3 and statusvenda<>:p5';
	$dts_total_vendas = $conexao->prepare($qry_total_vendas);
	$dts_total_vendas->bindvalue(':p1',$_SESSION['codemp']);
	$dts_total_vendas->bindvalue(':p3',$hoje);
	$dts_total_vendas->bindvalue(':p5','CP');	
	$dts_total_vendas->execute();
	$rs_total_vendas  = $dts_total_vendas->fetch(PDO::FETCH_OBJ);	
	$conta_total_vendas = $rs_total_vendas->totalvenda;
	
	///////////////////////////////////
	// Conta quantos pedidos
	///////////////////////////////////		
	$conexao = conexao::getInstance();
	$qry_total_pedidos = 'select count(codvenda) AS totalpedido from vdvenda where codemp=:p1 and dtemitvenda=:p3';
	$dts_total_pedidos = $conexao->prepare($qry_total_pedidos);
	$dts_total_pedidos->bindvalue(':p1',$_SESSION['codemp']);
	$dts_total_pedidos->bindvalue(':p3',$hoje);
	$dts_total_pedidos->execute();
	$rs_total_pedidos  = $dts_total_pedidos->fetch(PDO::FETCH_OBJ);	
	$conta_total_pedidos = $rs_total_pedidos->totalpedido;
	
	///////////////////////////////////
	// conta quantidade de itens
	///////////////////////////////////		
	$conexao = conexao::getInstance();
	$qry_total_itens = 'select count(coditvenda) as qtditens from vditvenda where codemp=:p1 and dtins=:p3';
	$dts_total_itens = $conexao->prepare($qry_total_itens);
	$dts_total_itens->bindvalue(':p1',$_SESSION['codemp']);
	$dts_total_itens->bindvalue(':p3',$hoje);
	$dts_total_itens->execute();
	$rs_total_itens  = $dts_total_itens->fetch(PDO::FETCH_OBJ);	
	$conta_total_itens = $rs_total_itens->qtditens;	
		/*echo "<pre>";print_r($rs_total_vendas); echo "</pre>"; exit;*/
	

	if(isset($conta_total_vendas) != 0 && isset($conta_total_itens) != 0)
	{
		$resultado = $conta_total_vendas / $conta_total_itens;
	}
	else
	{
		$resultado = 1;
	}	

	//echo $resultado;
	
	///////////////////////////////////
	// carrega vendas do dia
	///////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_vdvenda = 'select vdv.codvenda, vdv.codtipomov, vdv.docvenda, vdv.dtemitvenda, vdv.codcli, vdc.nomecli, vdv.vlrliqvenda, vde.nomevend, fnp.descplanopag from vdvenda as vdv
					inner join vdcliente as  vdc on vdv.codcli=vdc.codcli
					inner join vdvendedor as vde on vdv.codvend=vde.codvend
					inner join fnplanopag as fnp on vdv.codplanopag=fnp.codplanopag
					where vdv.codemp=:empcod and vdv.dtemitvenda=:p1 ';
	$dts_vdvenda = $conexao->prepare($qry_vdvenda);
	$dts_vdvenda->bindvalue(':empcod',$_SESSION['codemp']);
	$dts_vdvenda->bindValue(':p1',$hoje);
	$dts_vdvenda->execute();
	$rs_vdvenda = $dts_vdvenda->fetchAll(PDO::FETCH_OBJ);		
	
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Alles - <?=$sgfilial->razfilial;?> - <?=$_SESSION['usuario'];?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="interact_bar/styles.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="./images/favicon.png" />
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
			<h6><?=$sgfilial->codemp?> - <?=$sgfilial->razfilial;?> - <?=$sgfilial->nomefilial;?></h6>
            <div class="row purchace-popup">
				
				<!-- INICIO ALERTA SISTEMA NONOELEMENTO -->
				<?php include "alertas.php" ?>
				<!-- FIM ALERTA SISTEMA NONOELEMENTO -->
			  
            </div>
            <div class="row">

              <!-- KPI TAREFAS -->
			  <?php include "kpi_tarefas.php" ?>
			  <!-- FIM KPI TAREFAS -->
			  
			  <!-- EVOLUCAO DAS VENDAS -->
			  <?php include "kpi_evolucao.php" ?>
              <!-- FIM EVOLUÇÃO DAS VENDAS -->
			  
            </div>
            <!-- Quick Action Toolbar Starts-->
            <div class="row quick-action-toolbar">
              <div class="col-md-12 grid-margin">
				
				<!-- INICIO QUICK - AÇÕES RÁPIDAS -->
				<?php include "quick.php" ?>
				<!-- FIM QUICK - AÇÕES RÁPIDAS -->
				
              </div>
            </div>
            <!-- Quick Action Toolbar Ends-->
            <div class="row">
              <div class="col-md-12 grid-margin">

				<!-- INICIO RESUMO RELATORIO -->
				<?php include "kpi_resumo.php" ?>
				<!-- FIM RESUMO RELATORIO -->
				
              </div>
            </div>
			
			<!-- INICIO GRÁFICO ONDA -->
			<?php include "kpi_onda.php" ?>
			<!-- FIM GRAFICO ONDA -->
		   
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">

			  <!-- INICIO ULTIMAS VENDAS -->
			  <?php include "kpi_ultvendas.php" ?>
			  <!-- FIM ULTIMAS VENDAS -->
				
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
		  
		  <!-- INICIO RODAPÉ -->
		  <?php include "footer.php" ?>
		  <!-- FIM RODAPÉ -->
		  
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
    <script src="./vendors/chart.js/Chart.min.js"></script>
    <script src="./vendors/moment/moment.min.js"></script>
    <script src="./vendors/daterangepicker/daterangepicker.js"></script>
    <script src="./vendors/chartist/chartist.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="./js/dashboard.js"></script>
    <!-- End custom js for this page -->
    <!-- Outro conteúdo HTML existente -->

    <iframe src="interact_bar/interact_bar.php?codemp=<?php echo $_SESSION['codemp']; ?>&id=<?php echo $_SESSION['nomeusu'] ?>" frameborder="0" scrolling="no"></iframe>


  </body>
</html>