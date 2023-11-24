<?php
	require '../../db/conexao.php' ;
	$conexao = conexao::getInstance();
	
	$acao				=(isset($_POST['acao'])) ? $_POST['acao'] : '';
	$codemp 			=(isset($_POST['codemp'])) ? $_POST['codemp'] : '';
	$servico			=(isset($_POST['servico'])) ? $_POST['servico'] : '';
	$usuario			=(isset($_POST['usuario'])) ? $_POST['usuario'] : '';
	
	//echo "<pre>";print_r($arquivo); echo "</pre>"; exit;
	$conexao = conexao::getInstance();
	
	$qry_tai_empresas = 'select * from tai_empresas where codemp=:empcod';
	$dts_tai_empresas = $conexao->prepare($qry_tai_empresas);
	$dts_tai_empresas->bindvalue(':empcod',$codemp);
	$dts_tai_empresas->execute();
	$rs_tai_empresas = $dts_tai_empresas->fetch(PDO::FETCH_OBJ);
	
	/*echo "<pre>";print_r($rs_tai_empresas); echo "</pre>"; exit;*/
	$codacesso = $rs_tai_empresas->codacesso;
	
	$mensagem='';
	
	if ($acao == 'incluir'):
				
		$sql = 'insert into tai_emp_servicos (codacesso, codemp, servico) 
		values (:codacesso, :codemp, :servico)';
		
		$stm = $conexao->prepare($sql);
		$stm->bindvalue(':codemp', $codemp);		
		$stm->bindvalue(':codacesso', $codacesso);
		$stm->bindvalue(':servico', $servico);
		$retorno = $stm->execute();
	
		if ($retorno):
		
			/*echo $retorno;*/
	
			$sqllog = 	'insert into sgrastro (codemp, codfilial, usuario, acao, data, hora) values
				(:codemp, :codfilial, :usuario, :acao, :data, :hora)';
				
			$stmlog = $conexao->prepare($sqllog);
			$stmlog->bindValue(':codemp',$codemp);
			$stmlog->bindValue(':codfilial','1');
			$stmlog->bindValue(':usuario',$usuario);
			$stmlog->bindValue(':acao','Inseriu o Tai_Serviço '.$codemp);
			$stmlog->bindValue(':data', date('Y-m-d'));
			$stmlog->bindValue(':hora', date('h:i'));
			$retorna = $stmlog->execute();
					
			echo "<center><h2><p class='text-light bg-dark pl-1'>REGISTRO INSERIDO COM SUCESSO. AGUARDE REDIRECIONAMENTO</p></h2></center>";
		else:
			echo "<div class='alert alert-danger' role='alert'>Erro ao Inserir registro</div>";
		endif;

	echo "<meta http-equiv=refresh content='1;URL=../../tai_emp_servicos.php'>";
	endif;
	
	if ($acao == 'ativacli'):
	
		$sql = 'UPDATE vdcliente SET 
					ativo=:ativo
					WHERE idcliente=:idcliente';
			
			
			$stm = $conexao->prepare($sql);
			$stm->bindValue(':ativo', $ativo);			
			$stm->bindValue(':idcliente', $idcliente);	
			$retorno = $stm->execute();
			
			if ($retorno):
				echo "<div class='col-md-4 grid-margin stretch-card'><div class='card'><div class='card-body'><h4 class='card-title'>Tratamento do Registro</h4>
                    <div class='media'><i class='icon-globe icon-md text-info d-flex align-self-start mr-3'></i><div class='media-body'>
                        <p class='card-text'>Registro Inserido com sucesso!</p></div></div></div></div></div>";
			else:
				echo "<div class='alert alert-danger' role='alert'>Erro ao Inserir registro</div>";
			endif;
		
		echo "<meta http-equiv=refresh content='1;URL=../../eqalmox.php'>";
	
	endif;
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Alles</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../../vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="../../vendors/chartist/chartist.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
  </head>
  <body>
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../../vendors/chart.js/Chart.min.js"></script>
    <script src="../../vendors/moment/moment.min.js"></script>
    <script src="../../vendors/daterangepicker/daterangepicker.js"></script>
    <script src="../../vendors/chartist/chartist.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="../../js/dashboard.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>
		
		