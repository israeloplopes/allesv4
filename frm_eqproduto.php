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
		
	//////////////////////////////////////////////////
	// LISTA TODAS AS MARCAS CADASTRADAS
	/////////////////////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_eqmarca = "Select * from eqmarca where codemp=:empcod order by descmarca"; 
	$dts_eqmarca = $conexao->prepare($qry_eqmarca);
	$dts_eqmarca->bindValue(':empcod',$_SESSION['codemp']);	
	$dts_eqmarca->execute();
	$rs_eqmarca = $dts_eqmarca->fetchAll(PDO::FETCH_OBJ);
	
	/////////////////////////////////////////////////
	// LISTA TODAS AS UNIDADES CADASTRADAS
	/////////////////////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_equnidade = 'select * from equnidade where codemp=:empcod order by descunid';
	$dts_equnidade = $conexao->prepare($qry_equnidade);
	$dts_equnidade->bindvalue(':empcod',$_SESSION['codemp']);
	$dts_equnidade->execute();
	$rs_equnidade = $dts_equnidade->fetchAll(PDO::FETCH_OBJ);
	
	/////////////////////////////////////////////////
	// LISTA TODAS OS GRUPOS CADASTRADOS
	/////////////////////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_eqgrupo = "Select * from eqgrupo where codemp=:empcod order by descgrup"; 
	$dts_eqgrupo = $conexao->prepare($qry_eqgrupo);
	$dts_eqgrupo->bindValue(':empcod',$_SESSION['codemp']);	
	$dts_eqgrupo->execute();
	$rs_eqgrupo = $dts_eqgrupo->fetchAll(PDO::FETCH_OBJ);
	
	////////////////////////////////////////////////
	// LISTA TODAS OS ALMOXARIFADOS CADASTRADOS
	/////////////////////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_eqalmox = "Select * from eqalmox where codemp=:empcod order by descalmox"; 
	$dts_eqalmox = $conexao->prepare($qry_eqalmox);
	$dts_eqalmox->bindValue(':empcod',$_SESSION['codemp']);	
	$dts_eqalmox->execute();
	$rs_eqalmox = $dts_eqalmox->fetchAll(PDO::FETCH_OBJ);
	
	////////////////////////////////////////////////
	// LISTA TODAS AS CLASSIFICAÇÕES CADASTRADOS
	/////////////////////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_lfclfiscal = 'select * from lfclfiscal where codemp=:empcod order by codfisc limit 100';
	$dts_lfclfiscal = $conexao->prepare($qry_lfclfiscal);
	$dts_lfclfiscal->bindvalue(':empcod',$_SESSION['codemp']);
	$dts_lfclfiscal->execute();
	$rs_lfclfiscal = $dts_lfclfiscal->fetchAll(PDO::FETCH_OBJ);
	
	/////////////////////////////////////////////////
	// LISTA TODAS OS TIPOS DE PRODUTOS CADASTRADOS
	/////////////////////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_eqtipoprod = "Select * from eqtipoprod order by tipoprod"; 
	$dts_eqtipoprod = $conexao->prepare($qry_eqtipoprod);
	//$dts_eqtipoprod->bindValue(':empcod',$_SESSION['empcod']);	
	$dts_eqtipoprod->execute();
	$rs_eqtipoprod = $dts_eqtipoprod->fetchAll(PDO::FETCH_OBJ);
	
	/*echo "<pre>";print_r($rs_eqtipoprod); echo "</pre>"; exit;*/
		
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
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex align-items-center">
          <a class="navbar-brand brand-logo" href="index.php">
            <img src="images/logo-nome.png" alt="logo" class="logo-dark" />
          </a>
          <a class="navbar-brand brand-logo-mini" href="index.php"><img src="images/logo.png" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center flex-grow-1">
          <h5 class="mb-0 font-weight-medium d-none d-lg-flex"><?=$_SESSION['usuario'];?>, <?=$resp?>!</h5>
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
        <!-- partial:../../partials/_sidebar.html -->
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
              <h3 class="page-title">Produtos</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active"><button type="button" class="btn btn-primary btn-rounded btn-fw"><a href="eqproduto.php">Consulta</a></button><li>
                  <!--<li class="breadcrumb-item active" aria-current="page">Form elements</li>-->
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Insere/Edita Produtos</h4>
                    <p class="card-description"><small> * campos de preenchimento obrigatório <small></p>
                    <form class="forms-sample" action="pages/forms/act_eqproduto.php" method="post" name="equnidadde" id="eqproduto" enctype="multipart/form-data" >
                      <!--<div class="form-group">
                        <label for="exampleInputName1">Cód. Produtos *</label>
                        <input type="text" class="form-control" id="codprod" name="codprod" placeholder="Código Produto" onChange="javascript:this.value=this.value.toUpperCase();" required autofocus>
                      </div>-->
                      <div class="form-group">
                        <label for="exampleInputEmail3">Descrição do Produto*</label>
                        <input type="text" class="form-control" id="descprod" name="descprod" placeholder="Descrição do Produto" onChange="javascript:this.value=this.value.toUpperCase();" required>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Produto Ativo? *</label>
						<select class="form-control" name="ativoprod" id="ativoprod" >
							<option value="SIM">Sim</option>
							<option value="NÃO">Não</option>
						</select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Réferência Produtos *</label>
                        <input type="text" class="form-control" id="refprod" name="refprod" placeholder="Referência do Produto" onChange="javascript:this.value=this.value.toUpperCase();" required >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputName1">Código de Barras/EAN *</label>
                        <input type="text" class="form-control" id="codbarprod" name="codbarprod" placeholder="Codigo de Barras/EAN" onChange="javascript:this.value=this.value.toUpperCase();" required >
						<small>Caso o produto não tenha informe SEM GTIN</small>
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Unidade *</label>
						<select class="form-control" name="codunid" id="codunid" >
							<?php if(!empty($rs_equnidade)):?>
							<?php foreach($rs_equnidade as $equnidade):?>
								<option value="<?=$equnidade->codunid;?>"><?=$equnidade->descunid;?></option>
							<?php endforeach;?>									
						</select>
						<?php else: ?><?php endif; ?>
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Almoxarifado *</label>
						<select class="form-control" name="codalmox" id="codalmox" >
							<?php if(!empty($rs_eqalmox)):?>
							<?php foreach($rs_eqalmox as $eqalmox):?>
								<option value="<?=$eqalmox->codalmox;?>"><?=$eqalmox->descalmox;?></option>
							<?php endforeach;?>									
						</select>
						<?php else: ?><?php endif; ?>
                      </div>		
					  <div class="form-group">
                        <label for="exampleInputName1">Grupo *</label>
						<select class="form-control" name="codgrupo" id="codgrupo" >
							<?php if(!empty($rs_eqgrupo)):?>
							<?php foreach($rs_eqgrupo as $eqgrupo):?>
								<option value="<?=$eqgrupo->codgrup;?>"><?=$eqgrupo->descgrup;?></option>
							<?php endforeach;?>									
						</select>
						<?php else: ?><?php endif; ?>
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Marca *</label>
						<select class="form-control" name="codmarca" id="codmarca" >
							<?php if(!empty($rs_eqmarca)):?>
							<?php foreach($rs_eqmarca as $eqmarca):?>
								<option value="<?=$eqmarca->codmarca;?>"><?=$eqmarca->descmarca;?></option>
							<?php endforeach;?>									
						</select>
						<?php else: ?><?php endif; ?>
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputName1">NCM *</label>
						<select class="form-control" name="codfisc" id="codfisc" >
							<?php if(!empty($rs_lfclfiscal)):?>
							<?php foreach($rs_lfclfiscal as $lfclfiscal):?>
								<option value="<?=$lfclfiscal->codfisc;?>"><?=$lfclfiscal->codfisc;?></option>
							<?php endforeach;?>									
						</select>
						<?php else: ?><?php endif; ?>
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Tipo de Produto * </label>
						<select class="form-control" name="tipoprod" id="tipoprod" >
							<?php if(!empty($rs_eqtipoprod)):?>
							<?php foreach($rs_eqtipoprod as $eqtipoprod):?>
								<option value="<?=$eqtipoprod->codtipoprod;?>"><?=$eqtipoprod->tipoprod;?></option>
							<?php endforeach;?>	
						</select>
						<?php else: ?>Não há Registros<?php endif; ?>
                      </div>
					  <hr>
					  <h6><i>Custos e Valores</i></h6>
                      <div class="form-group">
                        <label for="exampleInputName1">Custo Informado *</label>
                        <input type="text" class="form-control" id="custoinfoprod" name="custoinfoprod" placeholder="Custo do Produto" onChange="javascript:this.value=this.value.toUpperCase();" required >
                      </div>	
                      <div class="form-group">
                        <label for="exampleInputName1">Preço Base *</label>
                        <input type="text" class="form-control" id="precobaseprod" name="precobaseprod" placeholder="Preço de Venda" onChange="javascript:this.value=this.value.toUpperCase();" required >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Custo Médio </label>
                        <input type="text" class="form-control" id="custompmprod" name="custompmprod" placeholder="Custo Médio" onChange="javascript:this.value=this.value.toUpperCase();" readonly >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Custo PEPS </label>
                        <input type="text" class="form-control" id="custopepsprod" name="custopepsprod" placeholder="Custo PEPS" onChange="javascript:this.value=this.value.toUpperCase();" readonly >
                      </div>	
					  <hr>
					  <h6><i>Informações Adicionais</i></h6>
					  <div class="form-group">
                        <label for="exampleInputName1">Qtd. Mínima</label>
                        <input type="text" class="form-control" id="qtdminprod" name="qtdminprod" placeholder="Quantidade Mínina em Estoque" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputName1">Qtd. Máxima</label>
                        <input type="text" class="form-control" id="qtdmaxprod" name="qtdmaxprod" placeholder="Quantidade Máxima em Estoque" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputName1">Peso Bruto</label>
                        <input type="text" class="form-control" id="pesobrutprod" name="pesobrutprod" placeholder="Peso Bruto do Item" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputName1">Peso Líquido</label>
                        <input type="text" class="form-control" id="pesoliqprod" name="pesoliqprod" placeholder="Peso Líquido do Item" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>		
					  <div class="form-group">
                        <label for="exampleInputName1">Qtd. Embalagem</label>
                        <input type="text" class="form-control" id="qtdembalagem" name="qtdembalagem" placeholder="Quantidade na Embalagem" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputName1">Prazo de Reposição</label>
                        <input type="text" class="form-control" id="prazorepo" name="prazorepo" placeholder="Prazo de Reposição em Dias" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Código na Balança</label>
                        <input type="text" class="form-control" id="codbalanca" name="codbalanca" placeholder="Código do Produto na Balança" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Código Mix de Produtos</label>
                        <input type="text" class="form-control" id="codmix" name="codmix" placeholder="Código do Mix de Produtos" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Etiqueta RFID</label>
                        <input type="text" class="form-control" id="codrfidprod" name="codrfidprod" placeholder="Código Etiqueta RFID" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Pontos Cartão Fidelidade</label>
                        <input type="text" class="form-control" id="ptsfidelidade" name="ptsfidelidade" placeholder="Quantidade na Embalagem" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>		
					  <div class="form-group">
                        <label for="exampleInputName1">Markup %</label>
                        <input type="text" class="form-control" id="markup" name="markup" placeholder="Marcação em % sobre o Custo" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
					  <h6><i>Marcações</i></h6>	
					  <div class="form-group">
                        <label for="exampleInputName1">Controle por Lote?</label>
                        <input type="checkbox" class="form-control" id="cloteprod" name="cloteprod" value="S" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputName1">Controle por N.º de Série?</label>
                        <input type="checkbox" class="form-control" id="serieprod" name="serieprod" value="S" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputName1">Emite Receita Agronômica?</label>
                        <input type="checkbox" class="form-control" id="usareceitaprod" name="usareceitaprod" value="S" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputName1">Emite Receita Agronômica?</label>
                        <input type="checkbox" class="form-control" id="usareceitaprod" name="usareceitaprod" value="S" >
                      </div>	
					  <h6><i>Comissionamento</i></h6>
					  <div class="form-group">
                        <label for="exampleInputName1">Comissão em % sobre venda do produto</label>
                        <input type="text" class="form-control" id="comisprod" name="comisprod" placeholder="Qual a comissão sobre o produto" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Preço do Produto + Comissão</label>
                        <input type="text" class="form-control" id="precocomisprod" name="precocomisprod" placeholder="Preço Venda Produto + Comissão" onChange="javascript:this.value=this.value.toUpperCase();" >
						<small></span>Deixe em BRANCO para não considerar este preço como venda</span></small>
                      </div>					  
					  <input type="hidden" name="acao"    	value="incluir">
					  <input type="hidden" name="codfilial" value="1">
					  <input type="hidden" name="codemp"  	value="<?=$_SESSION['codemp'];?>">
					  <input type="hidden" name="usuario" 	value="<?=$_SESSION['usuario'];?>">
                      <button type="submit" class="btn btn-primary mr-2">Gravar</button>
                      <button type="reset" class="btn btn-light">Cancela</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          
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
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>