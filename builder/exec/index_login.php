<?php

	### INPUTS
	$strLOGIN  		= strtolower(addslashes($_POST['login']));
	$strPASS   	 	= addslashes($_POST['password']);
	$strPASS_MD5 	= fnSenhaMD5($strPASS);

	//Validacao
	if (($strLOGIN == '') || ($strPASS == ''))
	{
		header('location: ../index.php?mc=1');
		exit;
	}

	//Programacao
	$DB = fnDBConn();
	$arUSUARIO = fnDB_USER_INFO($DB,$strLOGIN,$strPASS_MD5);

	if ((int)$arUSUARIO['ID'] <= 0)
	{
		header('location: ../index.php?mc=1');
		exit;
	}

	//Inicia a sessao
	session_start();
	$_SESSION['USER'] = $arUSUARIO;

	//Adiciona registro na tabela de auditoria
	fnDB_LOG_AUDIT_ADD($DB,'Entrou no sistema.',false);

	//Redirect pra proxima URL valida
	fnHeaderLogin();
?>
