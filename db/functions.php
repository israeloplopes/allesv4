<?php


function session_checker(){

if (!isset($_SESSION['usuario'])){

header ("Location:index.php");
exit();
}
}

function limpaDocumentos($valor){
$valor = trim($valor);
$valor = str_replace(“.”, “”, $valor);
$valor = str_replace(“,”, “”, $valor);
$valor = str_replace(“-“, “”, $valor);
$valor = str_replace(“/”, “”, $valor);
return $valor;
}

function gerar_senha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos){
  $ma = "ABCDEFGHIJKLMNOPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
  $mi = "abcdefghijklmnopqrstuvyxwz"; // $mi contem as letras minusculas
  $nu = "0123456789"; // $nu contem os números
  $si = "!@#$%¨&*()_+="; // $si contem os símbolos
 
  if ($maiusculas){
        // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($ma);
  }
 
    if ($minusculas){
        // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($mi);
    }
 
    if ($numeros){
        // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($nu);
    }
 
    if ($simbolos){
        // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
        $senha .= str_shuffle($si);
    }
 
    // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
    return substr(str_shuffle($senha),0,$tamanho);
}

function formata_dinheiro($valor) {
    $valor = number_format($valor, 2, ',', '.');
    return "R$ " . $valor;
}

function formata_dinheirosemcifrao($valor) {
    $valor = number_format($valor, 2, ',', '.');
    return "" . $valor;
}

function limpaCPF_CNPJ($valor){
	$valor = preg_replace('/[^0-9]/','',$valor);
	return $valor;
}

function formata_porcento($valor) {
    $valor = number_format($valor, 2, ',', '.');
    return "% " . $valor;
}

function formata_money($valor) {
		$valor = (string)$valor;
		$regra = "/^[0-9]{1,3}([.]([0-9]{3}))*[,]([.]{0})[0-9]{0,2}$/";
		if(preg_match($regra,$valor)) {
			return true;
		} else {
			return false;
		}
	}
	
function limpaCPF_CNPJ2($valor){
 $valor = trim($valor);
 $valor = str_replace(".", "", $valor);
 $valor = str_replace(",", "", $valor);
 $valor = str_replace("-", "", $valor);
 $valor = str_replace("/", "", $valor);
 return $valor;
}

function mostraMes($m) {
    switch ($m) {
        case 01: case 1: $mes = "Janeiro";
            break;
        case 02: case 2: $mes = "Fevereiro";
            break;
        case 03: case 3: $mes = "Mar&ccedil;o";
            break;
        case 04: case 4: $mes = "Abril";
            break;
        case 05: case 5: $mes = "Maio";
            break;
        case 06: case 6: $mes = "Junho";
            break;
        case 07: case 7: $mes = "Julho";
            break;
        case 8: case 8: $mes = "Agosto";
            break;
        case 9: case 9: $mes = "Setembro";
            break;
        case 10: $mes = "Outubro";
            break;
        case 11: $mes = "Novembro";
            break;
        case 12: $mes = "Dezembro";
            break;
    }
    return $mes;
}

function databrasil($data){
    return date("d/m/Y", strtotime($data));
}


?>