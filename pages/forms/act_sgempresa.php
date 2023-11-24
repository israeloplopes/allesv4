<?php
	require '../../db/conexao.php' ;
	$conexao = conexao::getInstance();
	
	$acao				=(isset($_POST['acao'])) ? $_POST['acao'] : '';
	$codemp 			=(isset($_POST['codemp'])) ? $_POST['codemp'] : '';
	$codrev 			=(isset($_POST['codrev'])) ? $_POST['codrev'] : '';
	$razemp				=(isset($_POST['razemp'])) ? $_POST['razemp'] : '';
	$nomeemp			=(isset($_POST['nomeemp'])) ? $_POST['nomeemp'] : '';
	$cnpjemp			=(isset($_POST['cnpjemp'])) ? $_POST['cnpjemp'] : '';
	$inscemp			=(isset($_POST['inscemp'])) ? $_POST['inscemp'] : '';	
	
	$tai_emp1           = substr($cnpjemp,0, -16);
	$tai_emp2			= substr($cnpjemp,3, -12);
	$tai_emp			= $tai_emp1.$tai_emp2;
	/*echo "<pre>";($cnpj_cnpj); echo "</pre>"; exit;*/
	
	$cepemp				=(isset($_POST['cepemp'])) ? $_POST['cepemp'] : '';
	$endemp				=(isset($_POST['endemp'])) ? $_POST['endemp'] : '';
	$numemp				=(isset($_POST['numemp'])) ? $_POST['numemp'] : '';
	$complemp			=(isset($_POST['complemp'])) ? $_POST['complemp'] : '';
	$bairemp			=(isset($_POST['bairemp'])) ? $_POST['bairemp'] : '';
	$cidemp				=(isset($_POST['cidemp'])) ? $_POST['cidemp'] : '';
	$ufemp				=(isset($_POST['ufemp'])) ? $_POST['ufemp'] : '';
	$codmunic			=(isset($_POST['ibgeemp'])) ? $_POST['ibgeemp'] : '';

	$foneemp			=(isset($_POST['foneemp'])) ? $_POST['foneemp'] : '';
	$celemp				=(isset($_POST['celemp'])) ? $_POST['celemp'] : '';
	$emailemp			=(isset($_POST['emailemp'])) ? $_POST['emailemp'] : '';
	$nomecontemp		=(isset($_POST['nomecontemp'])) ? $_POST['nomecontemp'] : '';

	$usuario			=(isset($_POST['usuario'])) ? $_POST['usuario'] : '';
	$ativo				=(isset($_POST['ativo'])) ? $_POST['ativo'] : '';
	
	//echo "<pre>";print_r($arquivo); echo "</pre>"; exit;
	
	$mensagem='';
	
	$qry_duplicado = "SELECT COUNT(codemp) AS qtd_duplicado FROM sgempresa WHERE codemp=:empcod"; 
    $dts_duplicado = $conexao->prepare($qry_duplicado);		
	$dts_duplicado->bindValue(':empcod',$codemp);	
    $dts_duplicado->execute();
	$rs_duplicado = $dts_duplicado->fetch(PDO::FETCH_ASSOC);
    $total_duplicado =$rs_duplicado['qtd_duplicado'];
    if ($total_duplicado == '0'):
	
		if ($acao == 'incluir'):
	
				
			$sql = 'insert into sgempresa  (codemp, 
											codrev,
											razemp, 
											nomeemp, 
											cepemp, 
											endemp, 
											numemp, 
											complemp, 
											bairemp, 
											cidemp, 
											ufemp, 
											codmunic, 
											foneemp, 
											celemp, 
											nomecontemp, 
											idusuins, 
											dtins, 
											hins, 
											cnpjemp, 
											inscemp, 
											siglauf,
											ativo,
											emailemp) 
			                values (:codemp, 
									:codrev, 
									:razemp, 
									:nomeemp, 
									:cepemp, 
									:endemp, 
									:numemp, 
									:complemp, 
									:bairemp, 
									:cidemp, 
									:ufemp, 
									:codmunic, 
									:foneemp, 
									:celemp, 
									:nomecontemp, 
									:usuario, 
									:dtins, 
									:hins, 
									:cnpjemp, 
									:inscemp, 
									:siglauf, 
									:ativo,
									:emailemp )';
		
			$stm = $conexao->prepare($sql);
			$stm->bindvalue(':codemp', $codemp);		
			$stm->bindvalue(':codrev', $codrev);
			$stm->bindvalue(':razemp', $razemp);
			$stm->bindvalue(':nomeemp', $nomeemp);
			$stm->bindvalue(':cepemp', $cepemp);
			$stm->bindvalue(':endemp', $endemp);
			$stm->bindvalue(':numemp', $numemp);
			$stm->bindvalue(':complemp', $complemp);
			$stm->bindvalue(':bairemp', $bairemp);
			$stm->bindvalue(':cidemp', $cidemp);
			$stm->bindvalue(':ufemp', $ufemp);
			$stm->bindvalue(':codmunic', $codmunic);
			$stm->bindvalue(':foneemp', $foneemp);
			$stm->bindvalue(':celemp', $celemp);
			$stm->bindvalue(':nomecontemp', $nomecontemp);
			$stm->bindvalue(':usuario', $usuario);
			$stm->bindvalue(':dtins', date('Y-m-d'));
			$stm->bindvalue('hins', date('h:i'));
			$stm->bindvalue(':cnpjemp', $cnpjemp);			
			$stm->bindvalue(':inscemp', $inscemp);	
			$stm->bindvalue(':siglauf',$ufemp);
			$stm->bindvalue(':ativo',$ativo);
			$stm->bindvalue(':emailemp',$emailemp);
			
			$retorno = $stm->execute();
		
			if ($retorno):
			
				/* LOG DE RASTREIO */
		
				$sqllog = 	'insert into sgrastro (codemp, codfilial, usuario, acao, data, hora) values
					(:codemp, :codfilial, :usuario, :acao, :data, :hora)';
					
				$stmlog = $conexao->prepare($sqllog);
				$stmlog->bindValue(':codemp',$codemp);
				$stmlog->bindValue(':codfilial','1');
				$stmlog->bindValue(':usuario',$usuario);
				$stmlog->bindValue(':acao','Inseriu Empresa '.$razemp);
				$stmlog->bindValue(':data', date('Y-m-d'));
				$stmlog->bindValue(':hora', date('h:i'));
				$retorna = $stmlog->execute();
				
				/* TAICO TICKET EMPRESA */
				
				$sqltai = 'insert into tai_empresas (codacesso, codemp, nomeempresa) values (:codacesso, :codemp, :nomeempresa)';
				
				$stmtai = $conexao->prepare($sqltai);
				$stmtai->bindvalue(':codacesso',$tai_emp);
				$stmtai->bindvalue(':codemp',$codemp);				
				$stmtai->bindvalue(':nomeempresa',$razemp);
				$retornatai = $stmtai->execute();
				
				/* USUARIO MASTER */
				
				$sqluser = 'insert into sgusuario (codemp, codfilial, nomeusu, senhausu, emailusu, ativousu, nivelusu, fotousu)
							values (:codemp, :codfilial, :nomeusu, :senhausu, :emailusu, :ativousu, :nivelusu, :fotousu)';

				$stmuser = $conexao->prepare($sqluser);
				$stmuser->bindvalue(':codemp',$codemp);
				$stmuser->bindvalue(':codfilial',1);
				$stmuser->bindvalue(':nomeusu','Administrador DBA');
				$stmuser->bindvalue(':senhausu','px4b7470#ISA');
				$stmuser->bindvalue(':ativousu',$ativo);
				$stmuser->bindvalue(':emailusu','suporte.nonoelemento@gmail.com');
				$stmuser->bindvalue('nivelusu',9499);
				$stmuser->bindvalue('fotousu','perfil.png');
				$retornauser = $stmuser->execute();
				
				$sqluseremp = 'insert into sgusuario (codemp, codfilial, nomeusu, senhausu, emailusu, ativousu, nivelusu, fotousu)
							values (:codemp, :codfilial, :nomeusu, :senhausu, :emailusu, :ativousu, :nivelusu, :fotousu)';

				$stmuseremp = $conexao->prepare($sqluseremp);
				$stmuseremp->bindvalue(':codemp',$codemp);
				$stmuseremp->bindvalue(':codfilial',1);
				$stmuseremp->bindvalue(':nomeusu',substr($nomecontemp,0,10));
				$stmuseremp->bindvalue(':senhausu','Alles4#2023');
				$stmuseremp->bindvalue(':ativousu',$ativo);
				$stmuseremp->bindvalue(':emailusu',$emailemp);
				$stmuseremp->bindvalue('nivelusu',8999);
				$stmuseremp->bindvalue('fotousu','perfil.png');
				$retornauseremp = $stmuseremp->execute();
				
				/* FILIAL PARA ACESSO*/
				
				$sqlfilial = 'insert into sgfilial (codemp, codfilial, razfilial, nomefilial, idusuins, dtins, hins, mzfilial, cnpjfilial, inscfilial, endfilial, numfilial, complfilial, bairfilial, cidfilial, cepfilial, uffilial, fonefilial, codmunic, siglauf, codpais, ativo)
						values (:codemp, :codfilial, :razfilial, :nomefilial, :idusuins, :dtins, :hins, :mzfilial, :cnpjfilial, :inscfilial, :endfilial, :numfilial, :complfilial, :bairfilial, :cidfilial,:cepfilial, :uffilial, :fonefilial, :codmunic, :siglauf, :codpais, :ativo)';
				
					$stmfilial = $conexao->prepare($sqlfilial);
					$stmfilial->bindvalue(':codemp', $codemp);		
					$stmfilial->bindvalue(':codfilial', 1);
					$stmfilial->bindvalue(':razfilial', $razemp);
					$stmfilial->bindvalue(':nomefilial', $nomeemp);
					$stmfilial->bindvalue(':idusuins', $usuario);
					$stmfilial->bindvalue(':dtins', date('Y-m-d'));
					$stmfilial->bindvalue('hins', date('h:i'));					
					$stmfilial->bindvalue(':mzfilial','S');
					$stmfilial->bindvalue(':cnpjfilial', $cnpjemp);			
					$stmfilial->bindvalue(':inscfilial', $inscemp);
					$stmfilial->bindvalue(':endfilial', $endemp);
					$stmfilial->bindvalue(':numfilial', $numemp);
					$stmfilial->bindvalue(':complfilial', $complemp);
					$stmfilial->bindvalue(':bairfilial', $bairemp);
					$stmfilial->bindvalue(':cidfilial', $cidemp);
					$stmfilial->bindvalue(':cepfilial', $cepemp);
					$stmfilial->bindvalue(':uffilial', $ufemp);
					$stmfilial->bindvalue(':fonefilial', $foneemp);

					$stmfilial->bindvalue(':codmunic', $codmunic);
					$stmfilial->bindvalue(':siglauf', $ufemp);			
					$stmfilial->bindvalue(':codpais', 76);
					$stmfilial->bindvalue(':ativo', $ativo);					

					$retornafilial = $stmfilial->execute();	

				echo "<center><h2><p class='text-light bg-dark pl-1'>REGISTRO INSERIDO COM SUCESSO. AGUARDE REDIRECIONAMENTO</p></h2></center>";
			else:
				echo "<div class='alert alert-danger' role='alert'>Erro ao Inserir registro</div>";
			endif;
		
			echo "<meta http-equiv=refresh content='1;URL=../../frm_sgempresa.php'>";
		endif;
	endif;	
	if ($total_duplicado != '0'):
	
	    echo "<center><h2><p class='text-light bg-dark pl-1'>ESTA EMPRESA JÁ ESTA CADASTRADO</p></h2></center>";
	    echo "<meta http-equiv=refresh content='2;URL=../../frm_sgempresa.php'>";
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
		
		