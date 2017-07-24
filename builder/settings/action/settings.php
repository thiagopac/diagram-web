<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/User.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('settings');

  $userID = $_SESSION['USER']['ID'];
  $interfaceLanguage = trim(addslashes($_REQUEST['interfaceLanguage']));
	$theme = trim(addslashes($_REQUEST['theme']));

  $user = new User();
  $user->id = $userID;
  $user->interfaceLanguageID = $interfaceLanguage;
  $user->themeID = $theme;

  $operation = $user->updateInterfaceLanguageAndThemeForUser($user);

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
