<?php
	require '../../db/conexao.php' ;
	$conexao = conexao::getInstance();
	
	$acao				=(isset($_POST['acao'])) ? $_POST['acao'] : '';
	$idticket 			=(isset($_POST['ticket'])) ? $_POST['ticket'] : '';
	$item				=(isset($_POST['item'])) ? $_POST['item'] : '';
	$atendido			=(isset($_POST['atendido'])) ? $_POST['atendido'] : '';	
	$descritivo			=(isset($_POST['descritivo'])) ? $_POST['descritivo'] : '';
	$finalizado			=(isset($_POST['finalizado'])) ? $_POST['finalizado'] : '';
	$inatividade		=(isset($_POST['inatividade'])) ? $_POST['inatividade'] : '';
	$anydesk			=(isset($_POST['anydesk'])) ? $_POST['anydesk'] : '';
	$end_anydesk		=(isset($_POST['end_anydesk'])) ? $_POST['end_anydesk'] : '';
	$teamviewer			=(isset($_POST['teamviewer'])) ? $_POST['teamviewer'] : '';
	$end_team			=(isset($_POST['end_team'])) ? $_POST['end_team'] : '';
	$so 				=(isset($_POST['so'])) ? $_POST['so'] : '';
	$usuario			=(isset($_POST['usuario'])) ? $_POST['usuario'] : '';
	$status 			=(isset($_POST['status'])) ? $_POST['status'] : '';
	
	
	//echo "<pre>";print_r($arquivo); echo "</pre>"; exit;
	
	$mensagem='';
	
	if ($acao == 'incluir'):
		
		$sql = 'insert into tai_it_tickets(idticket, item, atendido, descritivo, finalizado, inatividade, anydesk, end_anydesk, teamviewer, end_team, so) values (:idticket,:item, :atendido, :descritivo, :finalizado, :inatividade, :anydesk, :end_anydesk, :teamviewer, :end_team, :so)';
	
		$stm = $conexao->prepare($sql);
		$stm->bindvalue(':idticket', $idticket);		
		$stm->bindvalue(':item', $item);
		$stm->bindvalue(':atendido', $atendido);
		$stm->bindvalue(':descritivo', $descritivo);
		$stm->bindvalue(':finalizado', $finalizado);
		$stm->bindvalue(':inatividade', $inatividade);
		$stm->bindvalue(':anydesk', $anydesk);
		$stm->bindvalue(':end_anydesk', $end_anydesk);
		$stm->bindvalue(':teamviewer', $teamviewer);
		$stm->bindvalue(':end_team', $end_team);
		$stm->bindvalue(':so', $so);
		
		$retorno = $stm->execute();
	
		if ($retorno):
		
			if ($status <> ''):	
			/*echo $retorno;*/
				$sqlitem = 'UPDATE tai_tickets SET status=:p1 WHERE id=:p2';
				$stmitem = $conexao->prepare($sqlitem);
				$stmitem->bindvalue(':p1',$status);
				$stmitem->bindvalue(':p2',$idticket);
				$retonaitem = $stmitem->execute();			
			
			endif;
			
			if ($finalizado == 'T'):	
			/*echo $retorno;*/
				$sqlitem = 'UPDATE tai_tickets SET status=:p1 WHERE id=:p2';
				$stmitem = $conexao->prepare($sqlitem);
				$stmitem->bindvalue(':p1','R');
				$stmitem->bindvalue(':p2',$idticket);
				$retonaitem = $stmitem->execute();			
			
			endif;
			
	
			$sqllog = 	'insert into sgrastro (codemp, codfilial, usuario, acao, data, hora) values
				(:codemp, :codfilial, :usuario, :acao, :data, :hora)';
				
			$stmlog = $conexao->prepare($sqllog);
			$stmlog->bindValue(':codemp','9999');
			$stmlog->bindValue(':codfilial','1');
			$stmlog->bindValue(':usuario',$usuario);
			$stmlog->bindValue(':acao','Inseriu o item Ticket '.$idticket);
			$stmlog->bindValue(':data', date('Y-m-d'));
			$stmlog->bindValue(':hora', date('h:i'));
			$retorna = $stmlog->execute();
					
		echo "<center><h2><p class='text-light bg-dark pl-1'>REGISTRO INSERIDO COM SUCESSO. AGUARDE REDIRECIONAMENTO</p></h2></center>";
		else:
			echo "<div class='alert alert-danger' role='alert'>Erro ao Inserir registro</div>";
		endif;
	
		echo "<meta http-equiv=refresh content='1;URL=../../ticket.php'>";
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
		
		