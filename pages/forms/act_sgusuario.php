<?php 
	require '../../db/conexao.php' ;
	require '../../db/functions.php';

	// Atribui uma conexão PDO
	$conexao = conexao::getInstance();
	
	//Recebe dados via GET
	$conexao = conexao::getinstance();
    $retid = (isset($_GET['ID'])) ? $_GET['ID'] : '';
	
	// Recebe os dados enviados pela submissão
	$acao  			 = (isset($_POST['acao'])) ? $_POST['acao'] : '';
	$codemp			 = (isset($_POST['codemp'])) ? $_POST['codemp'] : '';	
	$idusu			 = (isset($_POST['idusu'])) ? $_POST['idusu'] : '';	
	$nomeusu		 = (isset($_POST['nomeusu'])) ? $_POST['nomeusu'] : '';			
	$emailusu		 = (isset($_POST['emailusu'])) ? $_POST['emailusu'] : '';	
	$ativousu		 = (isset($_POST['ativousu'])) ? $_POST['ativousu'] : '';		
	$nivelusu		 = (isset($_POST['nivelusu'])) ? $_POST['nivelusu'] : '';
	$senhausu		 = (isset($_POST['senhausu'])) ? $_POST['senhausu'] : '';		
	$codfilial		 = (isset($_POST['codfilial'])) ? $_POST['codfilial'] : '';
	$dtins			 = (isset($_POST['dtins'])) ? $_POST['dtins'] : '';
	$hins			 = (isset($_POST['hins'])) ? $_POST['hins'] : '';
	$idusuins		 = (isset($_POST['idusuins'])) ? $_POST['idusuins'] : '';
	$cadoutusu		 = (isset($_POST['cadoutusu'])) ? $_POST['cadoutusu'] : '';
	$visualizalucr	 = (isset($_POST['visualizalucr'])) ? $_POST['visualizalucr'] : '';
	$foto_atual		 = (isset($_POST['fotousu'])) ? $_POST['fotousu'] : '';		
	$foto			 = (isset($_POST['foto'])) ? $_POST['foto'] : '';		
	
	function limpaCAMPO($valor){
		$valor = preg_replace('/[^0-9]/','',$valor);
	return $valor;
	}
	
	$senhainicial 	= 'Alles'.date('Y');
	
	// Valida os dados recebidos
	$mensagem = '';
	
	if ($acao == 'incluir'):

		$sqluser = 'INSERT INTO sgusuario (codemp, codfilial, nomeusu, emailusu, ativousu, visualizalucr, cadoutusu, dtins, hins, idusuins, senhausu, nivelusu, fotousu) VALUES
					(:codemp, :codfilial, :nomeusu, :emailusu, :ativousu, :visualizalucr, :cadoutusu, :dtins, :hins, :idusuins, :senhausu, :nivelusu,:fotousu)';
		$stmuser = $conexao->prepare($sqluser);
		$stmuser->bindValue(':codemp', $codemp);
		$stmuser->bindValue(':codfilial', $codfilial);
		$stmuser->bindValue(':nomeusu', $nomeusu);
		$stmuser->bindValue(':emailusu', $emailusu);
		$stmuser->bindValue(':ativousu', $ativousu);
		$stmuser->bindValue(':visualizalucr', $visualizalucr);
		$stmuser->bindValue(':cadoutusu', $cadoutusu);
		$stmuser->bindValue(':dtins', $dtins);
		$stmuser->bindValue(':hins', $hins);
		$stmuser->bindValue(':idusuins', $idusuins);
		$stmuser->bindValue(':senhausu', $senhausu);
		$stmuser->bindValue(':nivelusu', $nivelusu);
		$stmuser->bindValue(':fotousu', $foto);
	
		$retornouser = $stmuser->execute();
		if ($retornouser):
			echo "<div class='alert alert-success' role='alert'>Registro INSERIDO com sucesso, aguarde você está sendo redirecionado ...</div>";
		else:
			echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div>";
		endif;
		echo "<meta http-equiv='refresh' content='1;URL=../../sgusuario.php'>";
	endif;

	if ($acao == 'fotoperfil'):
		
		if(isset($_FILES['fotousu']) && $_FILES['fotousu']['size'] > 0):
			$extensoes_aceitas = array('png', 'jpeg', 'jpg');
			$img_nome = $_FILES['fotousu']['name'];
			$img_separador = explode('.',$img_nome);
			$extensao = strtolower(end($img_separador));
	
		    //$extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));
			// Validamos se a extensão do arquivo é aceita
		    if (array_search($extensao, $extensoes_aceitas) === false):
		       echo "<h1>Extensão Inválida!</h1>";
		       exit;
		    endif;
			 
			// Monta o caminho de destino com o nome do arquivo  
		     $nome_foto = date('dmY') . '_' . $_FILES['fotousu']['name'];  
			 move_uploaded_file($_FILES['fotousu']['tmp_name'], '../../images/faces/'.$nome_foto); 
			
		    // Verifica se o upload foi enviado via POST   
		     if(is_uploaded_file($_FILES['fotousu']['tmp_name'])):
		             
			// Verifica se o diretório de destino existe, senão existir cria o diretório  
		    if(!file_exists("../../images/faces")):
			   echo "Pasta não existe. Estamos criando...";
		       mkdir("../images/faces");  
		    endif;  
		            
			// Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
		    if (!move_uploaded_file($_FILES['fotousu']['tmp_name'], '../../images/faces/'.$nome_foto)):  
		        echo "Houve um erro ao gravar arquivo na pasta de destino!";  
			endif;
		endif;
		else:
			$nome_foto = $foto_atual;
		endif;		
	
		$sql = 'UPDATE sgusuario SET fotousu=:foto WHERE idusu=:usuario';
			
		$stm = $conexao->prepare($sql);
		$stm->bindValue(':foto', $nome_foto);
		$stm->bindValue(':usuario', $idusu);
			
		$retorno = $stm->execute();
		if ($retorno):
			echo "<div class='alert alert-success' role='alert'>Registro EDITADO com sucesso, aguarde você está sendo redirecionado ...</div> ";
		else:
	    	echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div> ";
		endif;
		echo "<meta http-equiv=refresh content='1;URL=../../sgusuario.php'>";
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