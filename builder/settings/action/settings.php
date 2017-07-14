<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/User.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('settings');

  $userID = $_SESSION['USER']['ID'];
  $paramInterfaceLanguage = trim(addslashes($_REQUEST['selectInterfaceLanguage']));
	$paramTheme = trim(addslashes($_REQUEST['selectTheme']));
  $callBackSuccess = "location: ../settings.php?success=";
  $callBackError = "location: ../settings.php?error=";

  if ($paramInterfaceLanguage == '') {
    header($callBackError.urlencode('Error. Choose the language of the site.'));
    exit;
  }

  if ($paramTheme == '') {
    header($callBackError.urlencode('Error. Choose the theme of the site.'));
    exit;
  }

  $user = new User();
  $user = $user->updateInterfaceLanguageAndThemeForUser($paramInterfaceLanguage, $paramTheme, $userID);

  header($callBackSuccess.urlencode('Alterações realizadas com sucesso!'));
  exit;

?>
