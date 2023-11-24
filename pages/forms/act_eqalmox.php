<?php
	require '../../db/conexao.php' ;
	$conexao = conexao::getInstance();
	
	$acao				=(isset($_POST['acao'])) ? $_POST['acao'] : '';
	$codalmox 			=(isset($_POST['codalmox'])) ? $_POST['codalmox'] : '';
	$descalmox			=(isset($_POST['descalmox'])) ? $_POST['descalmox'] : '';
	$id					=(isset($_POST['id'])) ? $_POST['id'] : '';	
	$codemp				=(isset($_POST['codemp'])) ? $_POST['codemp'] : '';
	$usuario			=(isset($_POST['usuario'])) ? $_POST['usuario'] : '';
	
	//echo "<pre>";print_r($arquivo); echo "</pre>"; exit;
	
	$mensagem='';
	
	$qry_duplicado = "SELECT COUNT(codalmox) AS qtd_duplicado FROM eqalmox WHERE codalmox=:tem and codemp=:empcod"; 
    $dts_duplicado = $conexao->prepare($qry_duplicado);		
	$dts_duplicado->bindValue(':tem',$codalmox);
	$dts_duplicado->bindValue(':empcod',$codemp);	
    $dts_duplicado->execute();
	$rs_duplicado = $dts_duplicado->fetch(PDO::FETCH_ASSOC);
    $total_duplicado =$rs_duplicado['qtd_duplicado'];
    /*echo $total_duplicado;*/
    if ($total_duplicado == '0'):
	
		if ($acao == 'incluir'):
	
				
			$sql = 'insert into eqalmox (codemp, codalmox, descalmox) 
			values (:codemp, :codalmox, :descalmox)';
		
			$stm = $conexao->prepare($sql);
			$stm->bindvalue(':codemp', $codemp);		
			$stm->bindvalue(':codalmox', $codalmox);
			$stm->bindvalue(':descalmox', $descalmox);
			$retorno = $stm->execute();
		
			if ($retorno):
			
				/*echo $retorno;*/
		
				$sqllog = 	'insert into sgrastro (codemp, codfilial, usuario, acao, data, hora) values
					(:codemp, :codfilial, :usuario, :acao, :data, :hora)';
					
				$stmlog = $conexao->prepare($sqllog);
				$stmlog->bindValue(':codemp',$codemp);
				$stmlog->bindValue(':codfilial','1');
				$stmlog->bindValue(':usuario',$usuario);
				$stmlog->bindValue(':acao','Inseriu o Almoxarifado '.$descalmox);
				$stmlog->bindValue(':data', date('Y-m-d'));
				$stmlog->bindValue(':hora', date('h:i'));
				$retorna = $stmlog->execute();
						
			echo "<center><h2><p class='text-light bg-dark pl-1'>REGISTRO INSERIDO COM SUCESSO. AGUARDE REDIRECIONAMENTO</p></h2></center>";
			else:
				echo "<div class='alert alert-danger' role='alert'>Erro ao Inserir registro</div>";
			endif;
		
			echo "<meta http-equiv=refresh content='1;URL=../../frm_eqalmox.php'>";
		endif;
	endif;	
	if ($total_duplicado != '0'):
	
	    echo "<center><h2><p class='text-light bg-dark pl-1'>ESTE ALMOXARIFADO JÁ ESTA CADASTRADO</p></h2></center>";
	    echo "<meta http-equiv=refresh content='2;URL=../../frm_eqalmox.php'>";
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
		
		