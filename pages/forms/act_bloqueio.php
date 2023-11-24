<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
  	session_start();
	  }

	if (!isset($_SESSION['usuario'])){
	header('location: pages/samples/login.php');
	exit();
	}
	
	require '../../db/conexao.php' ;
	$conexao = conexao::getInstance();
	
	$acao				=(isset($_POST['acao'])) ? $_POST['acao'] : '';
	$codemp 			=(isset($_POST['codemp'])) ? $_POST['codemp'] : '';
	$ativo				=(isset($_POST['ativo'])) ? $_POST['ativo'] : '';
	
	//echo "<pre>";print_r($arquivo); echo "</pre>"; exit;
	
	$mensagem='';
	
	if ($acao == 'bloqueio'):
	
		$sqlemp = 'update sgempresa set ativo=:bloqueio where codemp=:empcod';
			$stmemp = $conexao->prepare($sqlemp);
			$stmemp->bindvalue(':bloqueio',$ativo);
			$stmemp->bindvalue(':empcod',$codemp);
			$retonaemp = $stmemp->execute();

		$sqlfilial = 'update sgfilial set ativo=:bloqueio where codemp=:empcod';
			$stmfilial = $conexao->prepare($sqlfilial);
			$stmfilial->bindvalue(':bloqueio',$ativo);
			$stmfilial->bindvalue(':empcod',$codemp);
			$retonafilial = $stmfilial->execute();	

		$sqluser = 'update sgusuario set ativousu=:bloqueio where codemp=:empcod';
			$stmuser = $conexao->prepare($sqluser);
			$stmuser->bindvalue(':bloqueio',$ativo);
			$stmuser->bindvalue(':empcod',$codemp);
			$retornauser = $stmuser->execute();			
	
		
		if ($retornauser):
		
			/*echo $retorno;*/
			$sqllog = 	'insert into sgrastro (codemp, codfilial, usuario, acao, data, hora) values
					(:codemp, :codfilial, :usuario, :acao, :data, :hora)';
			
			$stmlog = $conexao->prepare($sqllog);
			$stmlog->bindValue(':codemp',$codemp);
			$stmlog->bindValue(':codfilial','1');
			$stmlog->bindValue(':usuario',$_SESSION['usuario']);
			$stmlog->bindValue(':acao','Bloqueio de acesso');
			$stmlog->bindValue(':data', date('Y-m-d'));
			$stmlog->bindValue(':hora', date('h:i'));
			$retorna = $stmlog->execute();
					
			echo "<center><h2><p class='text-light bg-dark pl-1'>COMANDO DE BLOQUEIO ENVIADO COM SUCESSO. AGUARDE REDIRECIONAMENTO</p></h2></center>";
		else:
			echo "<div class='alert alert-danger' role='alert'>Erro ao Inserir registro</div>";
		endif;
		
			echo "<meta http-equiv=refresh content='1;URL=../../sgempresa.php'>";
	endif;	
	
	if ($acao == 'desbloqueio'):
$sqlemp = 'update sgempresa set ativo=:bloqueio where codemp=:empcod';
			$stmemp = $conexao->prepare($sqlemp);
			$stmemp->bindvalue(':bloqueio',$ativo);
			$stmemp->bindvalue(':empcod',$codemp);
			$retonaemp = $stmemp->execute();

		$sqlfilial = 'update sgfilial set ativo=:bloqueio where codemp=:empcod';
			$stmfilial = $conexao->prepare($sqlfilial);
			$stmfilial->bindvalue(':bloqueio',$ativo);
			$stmfilial->bindvalue(':empcod',$codemp);
			$retonafilial = $stmfilial->execute();	

		$sqluser = 'update sgusuario set ativousu=:bloqueio where codemp=:empcod';
			$stmuser = $conexao->prepare($sqluser);
			$stmuser->bindvalue(':bloqueio',$ativo);
			$stmuser->bindvalue(':empcod',$codemp);
			$retornauser = $stmuser->execute();			
	
		
		if ($retornauser):
		
			/*echo $retorno;*/
			$sqllog = 	'insert into sgrastro (codemp, codfilial, usuario, acao, data, hora) values
					(:codemp, :codfilial, :usuario, :acao, :data, :hora)';
			
			$stmlog = $conexao->prepare($sqllog);
			$stmlog->bindValue(':codemp',$codemp);
			$stmlog->bindValue(':codfilial','1');
			$stmlog->bindValue(':usuario',$_SESSION['usuario']);
			$stmlog->bindValue(':acao','Bloqueio de acesso');
			$stmlog->bindValue(':data', date('Y-m-d'));
			$stmlog->bindValue(':hora', date('h:i'));
			$retorna = $stmlog->execute();
					
			echo "<center><h2><p class='text-light bg-dark pl-1'>COMANDO DE DESBLOQUEIO ENVIADO COM SUCESSO. AGUARDE REDIRECIONAMENTO</p></h2></center>";
		else:
			echo "<div class='alert alert-danger' role='alert'>Erro ao Inserir registro</div>";
		endif;
		
			echo "<meta http-equiv=refresh content='1;URL=../../sgempresa.php'>";
	
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
		
		