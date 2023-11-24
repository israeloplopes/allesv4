<?php
	$conexao = conexao::getInstance();
	$qry_sgfilial = 'select * from sgfilial where codemp=:empcod';
	$dts_sgfilial = $conexao->prepare($qry_sgfilial);
	$dts_sgfilial->bindvalue(':empcod',$_SESSION['codemp']);
	$dts_sgfilial->execute();
	$rs_sgfilial = $dts_sgfilial->fetchAll(PDO::FETCH_OBJ);
	
	/*$conexao = conexao::getInstance();
	$qry_vdvendedor = 'select * from vdvendedor where ativo=:estaok order by nomevendedor';
	$dts_vdvendedor = $conexao->prepare($qry_vdvendedor);
	$dts_vdvendedor->bindvalue(':estaok','S');
	$dts_vdvendedor->execute();
	$rs_vdvendedor = $dts_vdvendedor->fetchAll(PDO::FETCH_OBJ);*/
	
	$conexao = conexao::getInstance();
	$qry_sgversao = 'select * from sgversao order by id DESC limit 1';
	$dts_sgversao = $conexao->prepare($qry_sgversao);
	$dts_sgversao->execute();
	$rs_sgversao = $dts_sgversao->fetchAll(PDO::FETCH_OBJ);
?>