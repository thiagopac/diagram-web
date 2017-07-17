<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/User.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('moderation-users');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $id = trim(addslashes($_REQUEST['id']));
	$firstName = trim(addslashes($_REQUEST['firstName']));
  $lastName = trim(addslashes($_REQUEST['lastName']));
  $login = trim(addslashes($_REQUEST['login']));
  $eloFide = trim(addslashes($_REQUEST['eloFide']));
  $grants = trim(addslashes($_REQUEST['grants']));
  $birthday = trim(addslashes($_REQUEST['birthday']));
  $countryID = trim(addslashes($_REQUEST['country']));
  $languageID = trim(addslashes($_REQUEST['language']));
  $themeID = trim(addslashes($_REQUEST['theme']));
  $interfaceLanguageID = trim(addslashes($_REQUEST['interfaceLanguage']));
  $status = trim(addslashes($_REQUEST['status']));
  $typeUser = trim(addslashes($_REQUEST['typeUser'])); //role
  $deleted = trim(addslashes($_REQUEST['deleted']));

  $user = new User();

  $user->id = $id;
  $user->firstName = $firstName;
  $user->lastName = $lastName;
  $user->login = $login;
  $user->eloFide = $eloFide;
  $user->grants = $grants;
  $user->birthday = fnDateVisualToDB($birthday);
  $user->countryID = $countryID;
  $user->languageID = $languageID;
  $user->themeID = $themeID;
  $user->interfaceLanguageID = $interfaceLanguageID;
  $user->status = $status;
  $user->password = $password;
  $user->typeUser = $typeUser;
  $user->deleted = $deleted;

  $operation = $user->updateUserData($user);

  $arrResponse = [];
  if ($operation[2] == true) {
    $arrResponse[status] = "error";
  }else{
    $arrResponse[status] = "success";
  }

  echo json_encode($arrResponse);
?>
