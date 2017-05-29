<?php
#CONTROLE SESSAO
	fnInicia_Sessao('USUARIO');

### INPUTS
	$ID = (int)$_REQUEST['ID'];

//Validacao
	if ($ID == 0)
		die('Falha Geral: ID invalido');

//Programacao
	$DB = fnDBConn();

	$SQL = "SELECT * FROM USUARIO WHERE ID = $ID";
	$RET = fnDB_DO_SELECT($DB,$SQL);
	$LOGIN = $RET['login'];

	$SQL = "UPDATE USUARIO SET LOGIN = CONCAT(login,'_OFF'), STATUS = 0 WHERE STATUS = 1 AND ID = $ID";
	$RET = fnDB_DO_EXEC($DB,$SQL);

	fnDB_LOG_AUDIT_ADD($DB,"Apagou a conta do Usuário: <strong>$LOGIN</strong>");

	header('location: ../usuarios/?msg='.urlencode('Usuário apagado com sucesso'));
	exit;
?>
