<?php
	ob_start();
	if (!isset($session)) session_start();
	include 'db/conexao.php';
	$codemp   = $_POST['codemp'];
	$usuario  = $_POST['usuario'];
	$senha    = $_POST['senha'];
	

	/*echo "<pre>";print_r($_POST); echo "</pre>"; exit;*/

	$conexao = conexao::getInstance();
	$sqluser = 'SELECT codemp, idusu, nomeusu, emailusu, ativousu, senhausu, nivelusu, fotousu FROM sgusuario WHERE nomeusu=:usuario and senhausu=:senha and codemp=:codemp and ativousu=:taok';
	
	
	//$sqluser = 'SELECT usu.idusuario, usu.usuario, usu.nivel, usu.ativo, usu.senha,usu.codemp,  usu.codcli, usu.email, usu.foto, cli.nome FROM sgusuario as usu
	//			inner join vdcliente as cli on usu.usuario=cli.matricula
	//			WHERE usuario= :user and senha= :pass and ativo= :taok ';
	$stm = $conexao->prepare($sqluser);
	$stm->bindvalue(':usuario',$usuario);
	$stm->bindvalue(':senha',$senha);
	$stm->bindvalue(':codemp',$codemp);	
	$stm->bindvalue(':taok','S');
	$stm->execute();
	$num = $stm->rowCount();
	$usuarios = $stm->fetchAll(PDO::FETCH_OBJ);
	
	/*echo "<pre>";print_r($usuarios); echo "</pre>"; exit;*/
	
		
	// Salva os dados encontrados na sessão
	//$SESSION['UsuarioID'] = $resultado['id'];
	//$SESSION['UsuarioNome'] = $resultado['nome'];
	//$_SESSION['nomeusuario'] = $resultado['nomeusu'];

//$sqluser = $conexao->prepare("Select * from `sgusuario` where idusu='$username' and senhausu='$password'");
//$sqluser = $conexao->prepare("Select * from `sgusuario` where sgusuario.idusu='sysdba'");
//$sqluser->execute();
//$num = $sqluser->rowCount();



	if(!empty($usuarios)):

		echo 'Login Efetuado com sucesso';
		$_SESSION['secao'] = sha1(time());		
		$_SESSION['usuario'] = $usuario;
		foreach ($usuarios as $logado) {
		$_SESSION['nomeusu'] = $logado->nomeusu; 		
		$_SESSION['idusu'] = $logado->idusu; 		
		$_SESSION['id'] =$logado->idusuario;
		$_SESSION['nivelusu']=$logado->nivelusu;
		$_SESSION['emailusu']=$logado->emailusu;
		$_SESSION['foto']=$logado->fotousu;
		$_SESSION['codemp']=$logado->codemp;				
	    }
		
	///
    	header('location: index.php');
	else: 
		//<!--echo "<CENTER><div class='alert alert-success' role='alert'>ESTE USUÁRIO NÃO EXISTE ou USUARIO/SENHA ESTÃO ERRADOS</div> </CENTER></mark>";!-->
		echo "<center><p class='text-light bg-dark pl-1'>ESTE USUÁRIO NÃO EXISTE ou USUARIO/SENHA ESTÃO ERRADOS</p></center>";
		echo "<center><div class='alert alert-success' role='alert'>Sua sessão está sendo desconectada e finalizada. Aguarde...</div></center>";
		
	echo "<meta http-equiv=refresh content='5;URL=pages/samples/login.php'>";
		
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
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
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
  </body>
</html>