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
		
	$conexao = conexao::getinstance();

	
	$ticket 	=(isset($_POST['ticket'])) ? $_POST['ticket'] : '';
	if (!empty($ticket)):		
		$conexao = conexao::getInstance();	
		$qry_retpart = "select max(item) AS ult_item from tai_it_tickets where idticket=:p1";
		$dts_retpart = $conexao->prepare($qry_retpart);		
		$dts_retpart->bindValue(':p1',$ticket);	
		$dts_retpart->execute();	
		$rs_retpart = $dts_retpart->fetch(PDO::FETCH_OBJ);	
		$total_item = $rs_retpart->ult_item;
		$novo_item = $total_item+1;
	endif;
	
	//	echo "<pre>";print_r($novo_item); echo "</pre>"; exit;
	

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
	
	<!--NonoElemento-->
 <script language="JavaScript" type="text/javascript" src="js/MascaraValidacao.js"></script> 
 <script language="JavaScript" type="text/javascript" src="js/jquery.mask.min.js"></script> 

<script>
function mask(e, id, mask){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)){
        mascara(id, mask);
        return true;
    } 
    else{
        if (tecla==8 || tecla==0){
            mascara(id, mask);
            return true;
        } 
        else  return false;
    }
}

function mascara(id, mask){
    var i = id.value.length;
    var carac = mask.substring(i, i+1);
    var prox_char = mask.substring(i+1, i+2);
    if(i == 0 && carac != '#'){
        insereCaracter(id, carac);
        if(prox_char != '#')insereCaracter(id, prox_char);
    }
    else if(carac != '#'){
        insereCaracter(id, carac);
        if(prox_char != '#')insereCaracter(id, prox_char);
    }
    function insereCaracter(id, char){
        id.value += char;
    }
}
</script>
  <!-- Adicionando JQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>

    <!-- Adicionando Javascript -->
    <script type="text/javascript" >

        $(document).ready(function() {

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
                $("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#endereco").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#endereco").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });

    </script>
	
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
              <h3 class="page-title">Item do Ticket</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active"><button type="button" class="btn btn-primary btn-rounded btn-fw"><a href="ticket.php">Consulta</a></button><li>
                  <!--<li class="breadcrumb-item active" aria-current="page">Form elements</li>-->
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Trata Tickets - <?=$ticket;?></h4>
                    <p class="card-description"><small> * campos de preenchimento obrigatório <small></p>
                    <form class="forms-sample" action="pages/forms/act_itemticket.php" method="post" name="itemticket" id="item_ticket" enctype="multipart/form-data" >
                      <div class="form-group">
                        <label for="exampleInputName1">Atendido por</label>
                        <input type="text" class="form-control" id="atendido" name="atendido" onChange="javascript:this.value=this.value.toUpperCase();" placeholder="Atendido por" autofocus required>
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Item</label>
                        <input type="text" class="form-control" id="item" name="item" onChange="javascript:this.value=this.value.toUpperCase();" value="<?=$novo_item?>" >
                      </div>					  
					  <div class="form-group">
                        <label for="exampleInputName1">Descritivo </label>
						<textarea class="form-control" name="descritivo" id="descritivo" cols="30" rows="5" ></textarea>						
                      </div>  
                      <div class="form-group">
                        <label for="exampleInputName1">Finalizado? *</label>
						<select class="form-control" name="finalizado" id="finalizado" >
							<option value="S">Sim</option>
							<option value="N">Não</option>
						</select>
                      </div>	
                      <div class="form-group">
                        <label for="exampleInputName1">Status? *</label>
						<select class="form-control" name="status" id="status" >
							<option value="A">Aberto</option>
							<option value="N">Não Aceito</option>
							<option value="R">Resolvido</option>
							<option value="T">Tratando</option>
							
						</select>
                      </div>					  
                      <div class="form-group">
                        <label for="exampleInputName1">Inatividade? *</label>
						<select class="form-control" name="inatividade" id="inatividade" >
							<option value="S">Sim</option>
							<option value="N">Não</option>
						</select>
                      </div>	
                      <div class="form-group">
                        <label for="exampleInputName1">Anydesk? </label>
						<select class="form-control" name="anydesk" id="anydesk" >
							<option value="S">Sim</option>
							<option value="N">Não</option>
						</select>
                      </div>	
                      <div class="form-group">
                        <label for="exampleInputName1">Endereço Anydesk </label>
						<input type="text" class="form-control" id="end_anydesk" name="end_anydesk" placeholder="Endereço do Anydesk" >
                      </div>						  
                      <div class="form-group">
                        <label for="exampleInputName1">TeamViewer? </label>
						<select class="form-control" name="teamviewer" id="teamviewer" >
							<option value="S">Sim</option>
							<option value="N">Não</option>
						</select>
                      </div>	
                      <div class="form-group">
                        <label for="exampleInputName1">Endereço TeamViewer </label>
						<input type="text" class="form-control" id="end_team" name="end_team" placeholder="Endereço do TeamViewer" >
                      </div>	
                      <div class="form-group">
                        <label for="exampleInputName1">Sistema Operacional </label>
						<select class="form-control" name="so" id="so" >
							<option value="NA">NÃO SE APLICA</option>
							<option value="WXP">Windows XP</option>
							<option value="WV">Windows Vista</option>
							<option value="W7">Windows 7</option>
							<option value="W8">Windows 8</option>
							<option value="W81">Windows 8.1</option>
							<option value="W10">Windows 10</option>
							<option value="W11">Windows 11</option>
							<option value="WS2003">Server 2003</option>
							<option value="WS2008">Server 2008</option>
							<option value="WS2012">Server 2008</option>							
							<option value="WS2016">Server 2016</option>
							<option value="WS2019">Server 2019</option>							
						</select>
                      </div>					  
					  <input type="hidden" name="acao"    	value="incluir">
					  <input type="hidden" name="ticket"	value="<?=$ticket;?>">
					  <!--<input type="hidden" name="item"		value="<?=$novo_item;?>">-->
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