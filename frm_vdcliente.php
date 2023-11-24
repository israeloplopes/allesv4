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
	
	function get_endereco($cep){
	// formatar o cep removendo caracteres nao numericos
	$cep = preg_replace("/[^0-9]/", "", $cep);
	$url = "http://viacep.com.br/ws/$cep/xml/";
	$xml = simplexml_load_file($url);
	return $xml;
    }
	
	/////////////////////////////////////////////////
	// LISTA TODAS AS CLASSIFICAÇÕES DE CLIENTES
	/////////////////////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_vdclascli = 'select * from vdclascli where codemp=:empcod order by descclascli';
	$dts_vdclascli = $conexao->prepare($qry_vdclascli);
	$dts_vdclascli->bindvalue(':empcod',$_SESSION['codemp']);
	$dts_vdclascli->execute();
	$rs_vdclascli = $dts_vdclascli->fetchAll(PDO::FETCH_OBJ);
	
	/////////////////////////////////////////////////
	// LISTA TODAS AS CLASSIFICAÇÕES DE CLIENTES
	/////////////////////////////////////////////////
	$conexao = conexao::getInstance();
	$qry_vdtipocli = 'select * from vdtipocli where codemp=:empcod order by desctipocli';
	$dts_vdtipocli = $conexao->prepare($qry_vdtipocli);
	$dts_vdtipocli->bindvalue(':empcod',$_SESSION['codemp']);
	$dts_vdtipocli->execute();
	$rs_vdtipocli = $dts_vdtipocli->fetchAll(PDO::FETCH_OBJ);
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
              <h3 class="page-title">Clientes</h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item active"><button type="button" class="btn btn-primary btn-rounded btn-fw"><a href="eqalmox.php">Consulta</a></button><li>
                  <!--<li class="breadcrumb-item active" aria-current="page">Form elements</li>-->
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Insere/Edita Clientes</h4>
                    <p class="card-description"><small> * campos de preenchimento obrigatório <small></p>

                    <form class="forms-sample" action="pages/forms/act_vdtipocli.php" method="post" name="vdcliente" id="vdcliente" enctype="multipart/form-data" >
                      <div class="form-group">
                        <label for="exampleInputName1">Razão Social/Nome Completo *</label>
                        <input type="text" class="form-control" id="razcli" name="razcli" placeholder="Razão Social ou Nome Completo" onChange="javascript:this.value=this.value.toUpperCase();" required autofocus>
						<small><span>Informe Razão Social no caso de Pessoa Jurídica ou Nome Completo no caso de Pessoa Física</span></small>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Nome Fantasia/Apelido *</label>
                        <input type="text" class="form-control" id="nomecli" name="nomecli" placeholder="Nome Fantasia/Apelido" onChange="javascript:this.value=this.value.toUpperCase();" required>
						<small><span>Informe Nome Fantasia no caso de Pessoa Jurídica ou Repita o Nome Completo ou coloque uma nome como é conhecido no caso de Pessoa Física</span></small>						
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Cliente Ativo? *</label>
						<select class="form-control" name="ativocli" id="ativocli" >
							<option value="SIM">Sim</option>
							<option value="NÃO">Não</option>
						</select>
                      </div>					  
					  <div class="form-group">
                        <label for="exampleInputName1">Classificação do Cliente * </label>
						<select class="form-control" name="codclascli" id="codclascli" >
							<?php if(!empty($rs_vdclascli)):?>
							<?php foreach($rs_vdclascli as $vdclascli):?>
								<option value="<?=$vdclascli->codclascli;?>"><?=$vdclascli->descclascli;?></option>
							<?php endforeach;?>	
						</select>
						<?php else: ?>Não há Classificação Cadastrada<?php endif; ?>
                      </div>
					  <div class="form-group">
                        <label for="exampleInputName1">Tipo de Cliente * </label>
						<select class="form-control" name="codtipocli" id="codtipocli" >
							<?php if(!empty($rs_vdtipocli)):?>
							<?php foreach($rs_vdtipocli as $vdtipocli):?>
								<option value="<?=$vdtipocli->codtipocli;?>"><?=$vdtipocli->desctipocli;?></option>
							<?php endforeach;?>	
						</select>
						<?php else: ?>Não há Tipos Cadastrados<?php endif; ?>
                      </div>	
					  <!-- <div class="form-group">
                        <label for="exampleInputEmail3">CNPJ </label>
                        <input type="text" class="form-control" onkeypress="return mask(event, this, '##.###.###/####-##')" id="cnpjcli" name="cnpjcli" placeholder="CNPJ" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
                      <div class="form-group">
                        <label for="exampleInputEmail3">Inscrição Estadual</label>
                        <input type="text" class="form-control" id="insccli" name="insccli" placeholder="Inscrição Estadual" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">CPF</label>
                        <input type="text" class="form-control" onkeypress="return mask(event, this, '###.###.###-##')" id="cpfcli" name="cpfcli" placeholder="CPF" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
                      <div class="form-group">
                        <label for="exampleInputEmail3">RG</label>
                        <input type="text" class="form-control" onkeypress="return mask(event, this, '###.###.###-##')" id="cpfcli" name="cpfcli" placeholder="CPF" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	-->
					  <hr>
					  <h6><i>Endereço e Localização</i></h6>					  
					  <div class="form-group">
						<label for="exampleInputEmail3">CEP</label>
                        <input type="text" class="form-control" onKeyPress="MascaraCEP(parceiros.cep);"  maxlength="9" onBlur="ValidaCEP(parceiros.cep);" name="cepcli" id="cep" placeholder="CEP" required>
					  </div>
					  <div class="form-group">
						<label for="exampleInputEmail3">Endereço</label>
						<input type="text" class="form-control" id="endereco" name="endcli" placeholder="Endereco" onChange="javascript:this.value=this.value.toUpperCase();" required>
					  </div>
					  <div class="form-group">
						<label for="exampleInputEmail3">Número</label>
						<input type="text" class="form-control" id="numero" name="numcli" placeholder="Número" onChange="javascript:this.value=this.value.toUpperCase();" required>
					  </div>
					  <div class="form-group">
						<label for="exampleInputEmail3">Complemento</label>
						<input type="text" class="form-control" id="complemento" name="complcli" placeholder="Complemento" onChange="javascript:this.value=this.value.toUpperCase();" >
					  </div>
					  <div class="form-group">
						<label for="exampleInputEmail3">Bairro</label>
						<input type="text" class="form-control" id="bairro" name="baircli" placeholder="Bairro" onChange="javascript:this.value=this.value.toUpperCase();" required>
					  </div>	
					  <div class="form-group">
						<label for="exampleInputEmail3">Cidade</label>
						<input type="text" class="form-control" id="cidade" name="cidcli" placeholder="Cidade" onChange="javascript:this.value=this.value.toUpperCase();" required>
					  </div>
					  <div class="form-group">
						<label for="exampleInputEmail3">UF</label>
						<input type="text" class="form-control"  id="uf" name="ufcli" placeholder="UF" onChange="javascript:this.value=this.value.toUpperCase();" required>
					  </div>
					  <div class="form-group">
						<label for="exampleInputEmail3">IBGE</label>
						<input type="text" class="form-control"  id="ibge" name="ibgecli" placeholder="Código Cidades IBGE" onChange="javascript:this.value=this.value.toUpperCase();" required>
					  </div>	
					  <hr>
					  <h6><i>Telefone e Contato</i></h6>
					  <div class="form-group">
                        <label for="exampleInputEmail3">Telefone</label>
                        <input type="text" class="form-control" id="fonecli" name="fonecli" placeholder="Telefone" onkeypress="return mask(event, this, '(##) ####-####')" onChange="javascript:this.value=this.value.toUpperCase();" >
						<small><span>Use para Telefone Fixo</span></small>						
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputEmail3">Celular (1)</label>
                        <input type="text" class="form-control" id="celcli" name="celcli" placeholder="Celular" onkeypress="return mask(event, this, '(##)#####-####')" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputEmail3">Celular (2)</label>
                        <input type="text" class="form-control" id="foneent" name="foneent" placeholder="Celular" onkeypress="return mask(event, this, '(##)#####-####')" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputEmail3">E-mail</label>
                        <input type="email" class="form-control" id="emailcli" name="emailcli" placeholder="E-mail" onChange="javascript:this.value=this.value.toLowerCase();" >
                      </div>			
					  <div class="form-group">
                        <label for="exampleInputEmail3">E-mail para envio de NFe</label>
                        <input type="email" class="form-control" id="emailnfecli" name="emailnfecli" placeholder="E-mail para envio de NFe" onChange="javascript:this.value=this.value.toLowerCase();" >
						<small><span>Se esse campo estiver preenchido o email com Danfe e XML será enviado automaticamente</span></small>							
                      </div>
					  <h6><i>Representante Legal</i></h6>
					  <div class="form-group">
                        <label for="exampleInputEmail3">Nome Contato </label>
                        <input type="text" class="form-control" id="nomerespcli" name="nomerespcli" placeholder="Representante Legal/Contato" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputEmail3">Fone Contato</label>
                        <input type="text" class="form-control" id="fonecob" name="fonecob" placeholder="Fone Contato" onkeypress="return mask(event, this, '(##)#####-####')" onChange="javascript:this.value=this.value.toUpperCase();" >
                      </div>	
					  <h6><i>Detalhes e Opções</i></h6>
					  <div class="form-group">
                        <label for="exampleInputEmail3">Consumidor Final?</label>
                        <input type="checkbox" class="form-control" id="consumidorcli" name="consumidorcli" value="S" >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputEmail3">Simples Nacional?</label>
                        <input type="checkbox" class="form-control" id="simplescli" name="simplescli" value="S" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputEmail3">Produtor Rural?</label>
                        <input type="checkbox" class="form-control" id="prodruralcli" name="prodruralcli" value="S" >
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputEmail3">Data Nascimento</label>
                        <input type="text" class="form-control" id="dtnasccli" name="dtnasccli" onkeypress="return mask(event, this, '##/##/####')" >
                      </div>
					  <div class="form-group">
                        <label for="exampleInputEmail3">Pontos Clube/Fidelidade</label>
                        <input type="text" class="form-control" id="qtdpontos" name="qtdpontos" readonly>
                      </div>	
					  <div class="form-group">
                        <label for="exampleInputEmail3">Saldo Crédito</label>
                        <input type="text" class="form-control" id="saldocredito" name="saldocredito" readonly>
                      </div>	
					  <h6><i>Capital Social e Situação</i></h6>	
					  <div class="form-group">
                        <label for="exampleInputEmail3">Data Abertura</label>
                        <input type="text" class="form-control" id="dataabecli" name="dataabecli" onChange="javascript:this.value=this.value.toUpperCase();">
                      </div>		
					  <div class="form-group">
                        <label for="exampleInputEmail3">Capital Social</label>
                        <input type="text" class="form-control" id="capitalcli" name="capitalcli" onChange="javascript:this.value=this.value.toUpperCase();">
                      </div>		
					  <div class="form-group">
                        <label for="exampleInputEmail3">Natureza</label>
                        <input type="text" class="form-control" id="naturezacli" name="naturezacli" onChange="javascript:this.value=this.value.toUpperCase();">
                      </div>		
					  <div class="form-group">
                        <label for="exampleInputEmail3">Situação</label>
                        <input type="text" class="form-control" id="situacaocli" name="situacaocli" onChange="javascript:this.value=this.value.toUpperCase();">
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