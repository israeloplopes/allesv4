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

$frase1 = ' sou da empresa ';
$frase2 = $sgfilial->razfilial;
$frase3 = ' c%C3%B3digo ';
$frase4 = $_SESSION['codemp'];
$frase5 = ' estou com d%C3%BAvida e preciso de ajuda';

$newfrase0 = preg_replace("/ /","%20",$resp);
$newfrase1 = preg_replace("/ /","%20",$frase1);
$newfrase2 = preg_replace("/ /","%20",$frase2);
$newfrase3 = preg_replace("/ /","%20",$frase3);
$newfrase4 = preg_replace("/ /","%20",$frase4);
$newfrase5 = preg_replace("/ /","%20",$frase5);

$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");


// check if is a mobile
if ($iphone || $android || $palmpre || $ipod || $berry == true)
{
  header('Location: https://api.whatsapp.com/send?phone=5527997996139&text='.$newfrase0.',%20'.$newfrase1.'*'.$newfrase2.'*'.$newfrase3.'_'.$newfrase4.'_'.$newfrase5.'');

  //OR
  echo "<script>window.location='https://api.whatsapp.com/send?phone=5527997996139&text='.$newfrase0.',%20'.$newfrase1.'*'.$newfrase2.'*'.$newfrase3.'_'.$newfrase4.'_'.$newfrase5.''</script>";
}

// all others
else {
  header('Location: https://web.whatsapp.com/send?phone=5527997996139&text='.$newfrase0.',%20'.$newfrase1.'*'.$newfrase2.'*'.$newfrase3.'_'.$newfrase4.'_'.$newfrase5.'');
  //OR
  echo "<script>window.location='https://web.whatsapp.com/send?phone=5527997996139&text='.$newfrase0.',%20'.$newfrase1.'*'.$newfrase2.'*'.$newfrase3.'_'.$newfrase4.'_'.$newfrase5.''</script>";
}
?>