<?php
	session_start();
	session_unset();
	session_destroy();

	include '../../db/conexao.php';
	
	$conexao = conexao::getInstance();
	$qry_sgversao = 'select * from sgversao order by id DESC';
	$dts_sgversao = $conexao->prepare($qry_sgversao);
	$dts_sgversao->execute();
	$rs_sgversao = $dts_sgversao->fetchAll(PDO::FETCH_OBJ);
	foreach ($rs_sgversao as $sgversao);
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Alles é tudo!</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../css/style.css" <!-- End layout styles -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="../../images/logo.png">
                </div>
                <h4>Olá! Pronto para começar...</h4>
                <h6 class="font-weight-light">faça <b>login</b> para continuar.</h6>
                <form class="pt-3" action="../../logar.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="codemp" name="codemp" placeholder="Código da Empresa" onChange="javascript:this.value=this.value.toUpperCase();" autofocus required>
                  </div>				
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" id="usuario" name="usuario" placeholder="Usuário" onChange="javascript:this.value=this.value.toUpperCase();" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" id="senha" name="senha" placeholder="Senha" required;>
                  </div>
                  <div class="mt-3">
                    <!--<a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="../../index.php">ACESSAR</a>-->
					<button class="btn btn-primary btn-fw" href="../../index.php" type="submit"><i class="fa fa-lock"></i> ACESSAR</button>
                  </div>
                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                      <!--<label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input"> Keep me signed in </label>-->
                    </div>
                    <a href="#" class="auth-link text-black">Perdeu a Senha?</a>
                  </div>
                  <div class="mb-2">
                    <!--<button type="button" class="btn btn-block btn-facebook auth-form-btn">
                      <i class="icon-social-facebook mr-2"></i>Connect using facebook </button>-->
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Ainda não tem Alles? <a href="registro.php" class="text-primary">Inscreva-se</a>
				  <center></br><small><b> Versão: <?=$sgversao->versao;?></b></small></center>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/misc.js"></script>
    <!-- endinject -->
  </body>
</html>