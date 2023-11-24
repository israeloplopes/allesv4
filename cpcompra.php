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
	
	$conexao = conexao::getInstance();
	$qry_cpcompra = 'select cp.*, cpf.nomefor from cpcompra as cp
					inner join cpforneced as cpf on cp.codfor=cpf.codfor
					where cp.codemp=:empcod and cpf.codemp=cp.codemp
					limit 100';
	$dts_cpcompra = $conexao->prepare($qry_cpcompra);
	$dts_cpcompra->bindvalue(':empcod',$_SESSION['codemp']);
	$dts_cpcompra->execute();
	$rs_cpcompra = $dts_cpcompra->fetchAll(PDO::FETCH_OBJ);
		
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
<!--	<link href="dual/css/style.css" rel="stylesheet">
    <link href="dual/css/style-responsive.css" rel="stylesheet">-->
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
              <h3 class="page-title">Vendas</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <!--<li class="breadcrumb-item"><a href="fr_cpcompra.php" target="_self">Insere</a></li>
                  <!--<li class="breadcrumb-item active" aria-current="page">Basic tables</li>-->
				  <li class="breadcrumb-item active"><button type="button" class="btn btn-primary btn-rounded btn-fw"><a href="frm_cpcompra.php?ID=0&amp;TP=0">Insere</a></button><li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Consulta Compras</h4>
                    <p class="card-description"><small> Utilize o campo <b>Buscar</b> para filtrar</small>
                    </p>
                    <!--<table class="table table-striped">-->
					<table cellpadding="0" cellspacing="0" border="0" class="table-responsive-sm" id="hidden-table-info">
                      <thead>
                        <tr>
                          <th> ID </th>
                          <th> Cód. </th>
                          <th> Fornecedor</th>
						  <th> Tp Mov.</th>
						  <th> Doc. </th>
						  <th> Dt. Emit</th>
						  <th> Dt. Entrada</th>
						  <th> Vlr. Compra</th>
						  <th> Ação </th>
                        </tr>
                      </thead>
                      <tbody>
					  <?php if(!empty($rs_cpcompra)):?>
					  <?php foreach($rs_cpcompra as $cpcompra):?>
                        <tr>
                          <td class="py-1">
							<?=$cpcompra->id?>
                            <!--<img src="images/faces-clipart/pic-1.png" alt="image" />-->
                          </td>
                          <td><?=$cpcompra->codcompra?></td>
                          <td>
                            <!--<div class="progress">
                              <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>-->
							<?=$cpcompra->nomefor?>
                          </td>
						  <td><?=$cpcompra->codtipomov?></td>
						  <td><?=$cpcompra->doccompra?></td>
						  <td><?=date('d/m/Y', strtotime($cpcompra->dtemitcompra)); ?></td>
						  <td><?=date('d/m/Y', strtotime($cpcompra->dtentvenda)); ?></td>
						  <td align="right"><?=$cpcompra->vlrcompra?></td>
                          <td>
							<button type="button" class="btn btn-warning btn-rounded btn-fw"><a href="frm_cpcompra.php?id=<?=$cpcompra->id?>&amp;TP=1">Edita</a></button>
							<button type="button" class="btn btn-danger btn-rounded btn-fw"><a href="frm_cpcompra.php?id=<?=$cpcompra->id?>&amp;TP=2">Exclui</a></button>
							<button type="button" class="btn btn-info btn-rounded btn-fw"><a href="frm_cpcompra.php?id=<?=$cpcompra->id?>&amp;TP=2">Fatura</a></button>
						  </td>
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
	<script type="text/javascript" language="javascript" src="vendors/advanced-datatable/js/jquery.js"></script>
    <script type="text/javascript" language="javascript" src="vendors/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="vendors/advanced-datatable/js/DT_bootstrap.js"></script>	
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
	 <script type="text/javascript">
	  /* Formating function for row details */
    function fnFormatDetails(oTable, nTr) {
      var aData = oTable.fnGetData(nTr);
      var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
      sOut += '<tr><td>Nome do Conveniado:</td><td>' + aData[1] + ' comprou ' + aData[4] + '</td></tr>';
      sOut += '<tr><td>Em :</td><td>' +aData[2] + ' vindo de ' +aData[3]+'</td></tr>';
      sOut += '<tr><td>Não Confere?:</td><td>Acione o Suporte</td></tr>';
      sOut += '</table>';

      return sOut;
    }

    $(document).ready(function() {
      /*
       * Insert a 'details' column to the table
       */
      var nCloneTh = document.createElement('th');
      var nCloneTd = document.createElement('td');
      nCloneTd.innerHTML = '<img src="vendors/advanced-datatable/images/details_open.png">';
      nCloneTd.className = "center";

      $('#hidden-table-info thead tr').each(function() {
        this.insertBefore(nCloneTh, this.childNodes[0]);
      });

      $('#hidden-table-info tbody tr').each(function() {
        this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
      });

      /*
       * Initialse DataTables, with no sorting on the 'details' column
       */
      var oTable = $('#hidden-table-info').dataTable({
        "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [0]
        }],
        "aaSorting": [
          [1, 'asc']
        ]
      });

      /* Add event listener for opening and closing details
       * Note that the indicator for showing which row is open is not controlled by DataTables,
       * rather it is done here
       */
      $('#hidden-table-info tbody td img').live('click', function() {
        var nTr = $(this).parents('tr')[0];
        if (oTable.fnIsOpen(nTr)) {
          /* This row is already open - close it */
          this.src = "vendors/advanced-datatable/media/images/details_open.png";
          oTable.fnClose(nTr);
        } else {
          /* Open this row */
          this.src = "vendors/advanced-datatable/images/details_close.png";
          oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
        }
      });
    });
  </script>
  </body>
</html>