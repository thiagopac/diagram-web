<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/User.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('settings-profile');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $id = trim(addslashes($_REQUEST['id']));
	$firstName = trim(addslashes($_REQUEST['firstName']));
  $lastName = trim(addslashes($_REQUEST['lastName']));
  $eloFide = trim(addslashes($_REQUEST['eloFide']));
  $birthday = trim(addslashes($_REQUEST['birthday']));
  $countryID = trim(addslashes($_REQUEST['country']));
  $languageID = trim(addslashes($_REQUEST['language']));

  $user = new User();

  $user->id = $id;
  $user->firstName = $firstName;
  $user->lastName = $lastName;
  $user->eloFide = $eloFide;
  $user->birthday = fnDateVisualToDB($birthday);
  $user->countryID = $countryID;
  $user->languageID = $languageID;

  $operation = $user->updateSelfProfile($user);

  $arrResponse = [];
  if ($operation[2] == true) {
    $arrResponse[status] = "error";
  }else{
    $arrResponse[status] = "success";
  }

  echo json_encode($arrResponse);
?>
