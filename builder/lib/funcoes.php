<?php

function fnLogText($strMessage,$booDie = false)
	{
	global $booDEV;

	if ($booDEV)
		echo $strMessage;

	$fp = fopen(FILE_LOG, 'a');
	fwrite($fp, date("Y/m/d H:i:s")." - (IP: {$_SERVER['REMOTE_ADDR']})(USER AGENT: {$_SERVER['HTTP_USER_AGENT']})(REQUEST_URI: {$_SERVER['REQUEST_URI']}) -  ".$strMessage.chr(13).chr(10));
	fclose($fp);

	if ($booDie)
		{
		die('FALHA GERAL: '.$strMessage);
		}
	}

function fnDateVisualToDB($dateVisual){
	$dateDB = date("Y-m-d", strtotime($dateVisual));

	return $dateDB;
}

function fnDateDBtoVisual($dateDB){
	$dateVisual = date("m/d/Y", strtotime($dateDB));

	return $dateVisual;
}

function fnDBConn()
	{
	global $MYSQL_HOST, $MYSQL_LOGIN, $MYSQL_SENHA, $MYSQL_PORTA, $MYSQL_DATABASE, $MYSQL_TIMEOUT;

	$erro = false;
	$DBtmp = mysqli_connect($MYSQL_HOST, $MYSQL_LOGIN, $MYSQL_SENHA, $MYSQL_DATABASE,$MYSQL_PORTA) or $erro = true;

	$DBtmp->set_charset("utf8");

	if ($erro)
		{
		$erro = false;
		sleep(3);
		$DBtmp = mysqli_connect($MYSQL_HOST, $MYSQL_LOGIN, $MYSQL_SENHA, $MYSQL_DATABASE,$MYSQL_PORTA) or $erro = true;
		}

	if ($erro)
		{
		sleep(3);
		$DBtmp = mysqli_connect($MYSQL_HOST, $MYSQL_LOGIN, $MYSQL_SENHA, $MYSQL_DATABASE,$MYSQL_PORTA) or fnLogText('(fnDBConn) '.mysqli_connect_error(),true);
		}

	fnDB_DO_EXEC($DBtmp,"SET wait_timeout = {$MYSQL_TIMEOUT}");

	return($DBtmp);
	}

function fnDB_DO_EXEC($DB, $strSQL)
	{
	global $DATABASE_NAME,$SQL_DUMP;

	$error = false;

	$SQL_DUMP .= "\n********************************************************************************\n";
	$SQL_DUMP .= $strSQL;

	$qy = mysqli_query($DB,$strSQL) or $error = true;

	if ($error)
		fnLogText('(fnDB_DO_EXEC) MySQL Error: '.mysqli_error($DB).' (SQL: '.$strSQL.')',true);

	return(array((int)$DB->affected_rows, (int)mysqli_insert_id($DB)) );
}

function fnDB_DO_SELECT_WHILE($DB, $strSQL)
{
	global $DATABASE_NAME,$SQL_DUMP;
	$error = false;

	$SQL_DUMP .= "\n********************************************************************************\n";
	$SQL_DUMP .= $strSQL;

	$qy = mysqli_query($DB,$strSQL) or $error = true;

	if($error) fnLogText('(fnDB_DO_SELECT_WHILE) MySQL Error: '.mysqli_error($DB).' (SQL: '.$strSQL.')',true);

	$arItem = array();
	$i=0;

	while($linha = mysqli_fetch_assoc($qy))
	{
		$arItem[$i] = $linha;
		$i++;
	}

	return($arItem);
}

function fnDB_DO_SELECT($DB, $strSQL)
	{
	global $DATABASE_NAME,$SQL_DUMP;

	$SQL_DUMP .= "\n********************************************************************************\n";
	$SQL_DUMP .= $strSQL;

	$error = false;

	$qy = mysqli_query($DB,$strSQL) or $error = true;

	if ($error)
		fnLogText('(fnDB_DO_SELECT) MySQL Error: '.mysqli_error($DB).' (SQL: '.$strSQL.')',true);

	$linha = mysqli_fetch_assoc($qy);

	return($linha);
}

function fnValidaChars($texto)
	{
	$arCHARS_VALIDOS = array('q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m',
							 '1','2','3','4','5','6','7','8','9','0',
							 ' ',',','.',':',';','?','!','(',')','=','/','*','$','-','+','%','#','@');

	$texto = strtolower($texto);

	for($x=0;$x < strlen($texto);$x++)
		{
		if (!in_array($texto[$x],$arCHARS_VALIDOS))
			return($texto[$x]);
		}

	return(true);
	}

function RemoveAcentos($string="")
{
   if($string != "")
   {
	  $com_acento = "Ã¡ Ã  Ã£ Ã¢ Ã¤ Ã© Ã¨ Ãª Ã« Ã­ Ã¬ Ã® Ã¯ Ã³ Ã² Ã´ Ãµ Ã¶ Ãº Ã¹ Ã» Ã¼ Ã� Ã€ Ãƒ Ã‚ Ã„ Ã‰ Ãˆ ÃŠ Ã‹ Ã� ÃŒ ÃŽ Ã� Ã“ Ã’ Ã• Ã�? Ã– Ãš Ã™ Ã› Ãœ Ã§ Ã‡ Ã± Ã‘";
      $sem_acento = "a a a a a e e e e i i i i o o o o o u u u u A A A A A E E E E I I I I O O O O O U U U U c C n N";
      $c = explode(' ',$com_acento);
      $s = explode(' ',$sem_acento);

      $i=0;
      foreach($c as $letra)
      {
          /**
           * @todo Trocar ereg por preg_match
           */
         if(@ereg($letra, $string))
         {
            $pattern[] = $letra;
            $replacement[] = $s[$i];
         }
         $i=$i+1;
      }

      if(isset($pattern))
      {
         $i=0;
         foreach($pattern as $letra)
         {
            $string = eregi_replace($letra, $replacement[$i], $string);
            $i=$i+1;
         }
         return $string; # retorna string alterada
      }

      return $string; # retorna a mesma string se nada mudou
   }
}

function pwStrongCheck($pwd)
	{
		$error = false;
		if(strlen($pwd) < 8)//to short
		{
			$error = true;
		}
		/*if(strlen($pwd) > 20)//to long
		{
			$error = true;
		}*/
		if(!preg_match("#[0-9]+#", $pwd))//at least one number
		{
			$error = true;
		}
		if(!preg_match("#[a-z]+#", $pwd))//at least one letter
		{
			$error = true;
		}
		/*if(!preg_match("#[A-Z]+#", $pwd))//at least one capital letter
		{
			$error = true;
		}*/
		if(!preg_match("#\W+#", $pwd))//at least one symbol
		{
			$error = true;
		}
		return $error;
	}

function fnInicia_Sessao($strGrantPage)
	{
	global $MENU_GRANT,$MENU_ATIVO;

	session_start();

	if (!fnVerifica_Grant($strGrantPage))
		{
		header("location: ../index.php?erroMsg=".urlencode('Sem acesso para a página. Tente novamente.'));
		exit;
		}

	$MENU_ATIVO = $strGrantPage;
	}

function fnVerifica_Grant($strGrantPage,$grants = 'NULL')
	{
	global $MENU_GRANT;

	if ($grants == 'NULL')
		$grants = $_SESSION['USER']['GRANTS'];

	if (strpos($grants, '|'.$strGrantPage.'|') !== false)
		return(true);

	return(false);
	}

function fnHeaderLogin()
	{
	global $MENU_GRANT;

	foreach($MENU_GRANT as $i => $arItem)
		{
		if (strpos($_SESSION['USER']['GRANTS'], '|'.$arItem[0].'|') !== false)
			{
			header("location: ../".$arItem[0].'/dashboard.php'); exit;
			}
		}
	}

# RETORNO DADOS DO USUARIO NO LOGIN
function fnDB_USER_INFO($DB,$strLogin,$strPass)
	{
	global $DATABASE_NAME;
	$error = false;


	$strSQL = "SELECT ID, FIRSTNAME, LASTNAME, LOGIN, GRANTS, ID_TYPE_USER
				FROM $DATABASE_NAME.USER
				WHERE LOGIN = '$strLogin'
				AND PASSWORD = '$strPass'
				AND STATUS=1";


	$qy = mysqli_query($DB, $strSQL) or $error = true;

	if ($error)
	fnLogText('(fnDB_USER_INFO) MySQL Error: '.mysqli_error($DB).' (SQL: '.$strSQL.')',true);

	$linha = mysqli_fetch_array($qy);

	return($linha);
	}

# GERA HASH DA SENHA DO USUARIO
function fnSenhaMD5($string)
	{
	global $SENHA_MD5;

		return md5($string);
	}


# GERA LOG DE AUDITORIA DE AÃ‡Ã•ES DO SISTEMA
function fnDB_LOG_AUDIT_ADD($DB,$descricao,$loga_request = true){
	global $DATABASE_NAME;

	$error = false;

	$ip 	  = addslashes($_SERVER['REMOTE_ADDR']);
	$descricao= addslashes($descricao);

	//Pra nao logar as senhas
	if ($loga_request)
		$request= addslashes(print_r($_REQUEST,true));

	//SQL 1
	$strSQL = "INSERT INTO AUDIT
				(IP, ID_USER, ACTION_DESC, REQUEST, DIN)
				VALUES
				('$ip', {$_SESSION['USER']['ID']}, '$descricao', '$request', NOW())";
	$qy = mysqli_query($DB, $strSQL) or $error = true;

	if ($error)
		fnLogText('(fnDB_LOG_AUDIT_ADD) MySQL Error: '.mysqli_error($DB).' (SQL: '.$strSQL.')',true);

	if($DB->affected_rows == 0){
		return(false);
	}

	$Id = (int)mysqli_insert_id($DB);

	if ($Id == 0)
		return(false);

	return(true);
}

function fnRemoveAcentos($str, $enc = "UTF-8")
	{

	$str = str_replace('"',' ',$str);
	$str = str_replace('Â´',' ',$str);
	$str = str_replace("'",' ',$str);
	$str = str_replace("Â¨",' ',$str);
	$str = str_replace("~",' ',$str);
	$str = str_replace("^",' ',$str);

	$acentos = array(
	'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
	'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
	'C' => '/&Ccedil;/',
	'c' => '/&ccedil;/',
	'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
	'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
	'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
	'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
	'N' => '/&Ntilde;/',
	'n' => '/&ntilde;/',
	'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
	'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
	'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
	'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
	'Y' => '/&Yacute;/',
	'y' => '/&yacute;|&yuml;/',
	'a.' => '/&ordf;/',
	'o.' => '/&ordm;/');

	 return preg_replace($acentos,
						   array_keys($acentos),
						   htmlentities($str,ENT_NOQUOTES, $enc));
	}

?>
