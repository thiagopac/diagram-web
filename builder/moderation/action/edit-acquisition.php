<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/Acquisition.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('moderation-openings');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $id = trim(addslashes($_REQUEST['id']));
  $user = trim(addslashes($_REQUEST['user']));
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $active = trim(addslashes($_REQUEST['active']));
  $deleted = trim(addslashes($_REQUEST['deleted']));

  $acquisition = new Acquisition();

  $acquisition->id = $id;
  $acquisition->approvingUser = $userID;
  $acquisition->userID = $user;
  $acquisition->studyID = $studyID;
  $acquisition->active = $active;
  $acquisition->deleted = $deleted;

  // var_dump($acquisition);
  // exit;

  $operation = $acquisition->editAcquisitionForAcquisition($acquisition);

  $arrResponse = [];
  if ($operation[2] == true) {
    $arrResponse[status] = "error";
  }else{
    $arrResponse[status] = "success";
  }

  echo json_encode($arrResponse);
?>
