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
	$foto_atual		 = (isset($_POST['fotousu'])) ? $_POST['fotousu'] : '';		
	
	function limpaCAMPO($valor){
		$valor = preg_replace('/[^0-9]/','',$valor);
	return $valor;
	}
	
	$senhainicial 	= 'Alles'.date('Y');
	
	// Valida os dados recebidos
	$mensagem = '';
	
if ($acao == 'incluir') {

    $sqluser = 'INSERT INTO sgusuario (codemp, codrev, usuario, senha, email, nivel, ativo, foto, isync) VALUES
                (:codemp, :codrev, :usuario, :senha, :email, :nivel, :ativo, :foto, :isync)';
    $stmuser = $conexao->prepare($sqluser);
    $stmuser->bindValue(':codemp', $codemp);
    $stmuser->bindValue(':codrev', $codrev);
    $stmuser->bindValue(':usuario', $usuario);
    $stmuser->bindValue(':senha', $senhainicial);
    $stmuser->bindValue(':email', $email);
    $stmuser->bindValue(':nivel', $nivel);
    $stmuser->bindValue(':ativo', 'S');
    $stmuser->bindValue(':isync', $isync);
    $stmuser->bindValue(':foto', $nome_foto);

    $retornouser = $stmuser->execute();
    if ($retornouser) {
        echo "<div class='alert alert-success' role='alert'>Registro INSERIDO com sucesso, aguarde você está sendo redirecionado ...</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Erro ao inserir registro!</div>";
    }
    echo "<meta http-equiv='refresh' content='1;URL=sgusuario.php'>";

};

			
	// Verifica se foi solicitada a edição de dados
	if ($acao == 'editar'):

		if(isset($_FILES['foto']) && $_FILES['foto']['size'] > 0): 
			$extensoes_aceitas = array('bmp' ,'png', 'svg', 'jpeg', 'jpg');
			$img_nome = $_FILES['foto']['name'];
			$img_separador = explode('.',$img_nome);
			$extensao = strtolower(end($img_separador));
	
		    //$extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));
			// Validamos se a extensão do arquivo é aceita
		    if (array_search($extensao, $extensoes_aceitas) === false):
		       echo "<h1>Extensão Inválida!</h1>";
		       exit;
		    endif;
			 
			// Monta o caminho de destino com o nome do arquivo  
		     $nome_foto = date('dmY') . '_' . $_FILES['foto']['name'];  
			 move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'.$nome_foto); 
			
		    // Verifica se o upload foi enviado via POST   
		     if(is_uploaded_file($_FILES['foto']['tmp_name'])):  
		             
			// Verifica se o diretório de destino existe, senão existir cria o diretório  
		    if(!file_exists("fotos")): 
			   echo "Pasta não existe. Estamos criando...";
		       mkdir("fotos");  
		    endif;  
		            
			// Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
		    if (!move_uploaded_file($_FILES['foto']['tmp_name'], 'fotos/'.$nome_foto)):  
		        echo "Houve um erro ao gravar arquivo na pasta de destino!";  
			endif;  
		endif;
		else:
		 	$nome_foto = $foto_atual;
		endif;		

		$sql = 'UPDATE sgusuario SET 
				senha=:senha,
				email=:email,
				nivel=:nivel,
				ativo=:ativo,
				esync=:edita,
				foto=:foto
			WHERE codusuario=:usuariocod';
			
		$stm = $conexao->prepare($sql);
		$stm->bindValue(':senha', $senha);	
		$stm->bindValue(':email', $email);
		$stm->bindValue(':nivel', $nivel);
		$stm->bindValue(':ativo', $ativo);	
		$stm->bindValue(':edita', $esync);				
		$stm->bindValue(':foto', $nome_foto);
		$stm->bindValue(':usuariocod', $codusuario);
		
		$retorno = $stm->execute();
		if ($retorno):
			echo "<div class='alert alert-success' role='alert'>Registro EDITADO com sucesso, aguarde você está sendo redirecionado ...</div> ";
	    else:
	    	echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div> ";
		endif;

		echo "<meta http-equiv=refresh content='1;URL=usuarios.php'>";
    endif;
		
	if ($acao == 'fotoperfil'){
		
		if(isset($_FILES['fotousu']) && $_FILES['fotousu']['size'] > 0){ 
			$extensoes_aceitas = array('png', 'jpeg', 'jpg');
			$img_nome = $_FILES['fotousu']['name'];
			$img_separador = explode('.',$img_nome);
			$extensao = strtolower(end($img_separador));
	
		    //$extensao = strtolower(end(explode('.', $_FILES['foto']['name'])));
			// Validamos se a extensão do arquivo é aceita
		    if (array_search($extensao, $extensoes_aceitas) === false){
		       echo "<h1>Extensão Inválida!</h1>";
		       exit;
		    }
			 
			// Monta o caminho de destino com o nome do arquivo  
		     $nome_foto = date('dmY') . '_' . $_FILES['fotousu']['name'];  
			 move_uploaded_file($_FILES['fotousu']['tmp_name'], '../../images/faces/'.$nome_foto); 
			
		    // Verifica se o upload foi enviado via POST   
		     if(is_uploaded_file($_FILES['fotousu']['tmp_name'])){
		             
			// Verifica se o diretório de destino existe, senão existir cria o diretório  
		    if(!file_exists("../../images/faces")){
			   echo "Pasta não existe. Estamos criando...";
		       mkdir("../images/faces");  
		    }  
		            
			// Essa função move_uploaded_file() copia e verifica se o arquivo enviado foi copiado com sucesso para o destino  
		    if (!move_uploaded_file($_FILES['fotousu']['tmp_name'], '../../images/faces/'.$nome_foto)){  
		        echo "Houve um erro ao gravar arquivo na pasta de destino!";  
			}
		}
		else{
			$nome_foto = $foto_atual;
		}		
	
		$sql = 'UPDATE sgusuario SET fotousu=:foto WHERE idusu=:usuario';
			
		$stm = $conexao->prepare($sql);
		$stm->bindValue(':foto', $nome_foto);
		$stm->bindValue(':usuario', $idusu);
			
		$retorno = $stm->execute();
		if ($retorno){
			echo "<div class='alert alert-success' role='alert'>Registro EDITADO com sucesso, aguarde você está sendo redirecionado ...</div> ";
		} else {
	    	echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div> ";
		}
		echo "<meta http-equiv=refresh content='1;URL=../../sgusuario.php'>";
	}		
		
	if ($acao == 'senha'):
		$sql = 'UPDATE sgusuario SET 
				senha=:senha
				WHERE codusuario=:usuariocod';
			
		$stm = $conexao->prepare($sql);
		$stm->bindValue(':senha', $senha);	
		$stm->bindValue(':usuariocod', $codusuario);
		
		$retorno = $stm->execute();
		if ($retorno):
			echo "<div class='alert alert-success' role='alert'>Registro EDITADO com sucesso, aguarde você está sendo redirecionado ...</div> ";
	    else:
			echo "<div class='alert alert-danger' role='alert'>Erro ao editar registro!</div> ";
		endif;

		echo "<meta http-equiv=refresh content='1;URL=sgusuario.php'>";
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
		
		