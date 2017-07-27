<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/User.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('moderation-users');

  //FORM FIELDS
  $userID = trim(addslashes($_REQUEST['user']));

  $user = new User();
  $user->id = $userID;

  $operation = $user->deleteUser($user);

  $arrResponse = [];
  if ($operation[2] == true) {
    $arrResponse[status] = "error";
  }else{
    $arrResponse[status] = "success";
  }

  echo json_encode($arrResponse);
?>
