<?php
#SETA TIMEOUT
	$PHP_TIMEOUT = 300;
	$MYSQL_TIMEOUT = $PHP_TIMEOUT + 10;

	$GLOBALS['rootpath'] = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));


//definindo hora padr�o da aplicacao
date_default_timezone_set('America/Sao_Paulo');

//#ERROR REPORT - LEVE ESTE PEDA�O ABAIXO DE C�DIGO PARA O SCRIPT QUE VC QUER ATIVAR A EXIBI��O DE ERROS PHP
//ini_set('display_errors', 1);
//ini_set('log_errors', 1);
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
//error_reporting(E_ALL);

#DEFAULT
	error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

	if ($_SERVER['SERVER_ADMIN'] == 'admin@diagramchess.com')
		define('FILE_LOG', '/var/log/www/'.date('Y-m-d').'-cms.diagramchess.com_PHP_error.log');
	else
		define('FILE_LOG', 'C:/Server/Apache2.2/logs/'.date('Y-m-d')."-cms.diagramchess.com_PHP_error.log");

	set_time_limit($PHP_TIMEOUT);

#ACESSO MYSQL
	$MYSQL_HOST  = "localhost";
	$MYSQL_LOGIN = "root";
	$MYSQL_SENHA = 'mysql';
	$MYSQL_PORTA = 3306;
	$MYSQL_DATABASE = 'diagramchess-homologacao';
//	var_dump($_SERVER['SERVER_NAME']);die;
	if ($_SERVER['SERVER_NAME'] == 'localhost')
		{
		$MYSQL_HOST  = "localhost";
		$MYSQL_LOGIN = "root";
		$MYSQL_SENHA = "mysql";
		$MYSQL_PORTA = 3306;
		$MYSQL_DATABASE = 'diagramchess-dev';
		// $MYSQL_DATABASE = 'diagramchess-qa';
		}

#MENU
	$MENU_GRANT[]  = array('dashboard');
	$MENU_GRANT[]  = array('administrators');
	$MENU_GRANT[]  = array('settings');
	$MENU_GRANT[]  = array('audit');
	$MENU_GRANT[]  = array('listboards');
	$MENU_GRANT[]  = array('buildpgn');
	$MENU_GRANT[]  = array('buildfen');
	$MENU_GRANT[]  = array('openings');
	$MENU_GRANT[]  = array('openings-builder');

//VARIAVEIS
	$TITULO = "Diagram Chess";

//INCLUDES
	include('funcoes.php');
	include('funcoes_genericas.php');
?>
