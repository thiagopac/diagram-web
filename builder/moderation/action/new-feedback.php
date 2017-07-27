<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/StudyAdministration.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('moderation-feedback');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $message = trim(addslashes($_REQUEST['message']));
  $studyID = trim(addslashes($_REQUEST['studyID']));

  $studyAdministration = new StudyAdministration();

  $studyAdministration->message = $message;
  $studyAdministration->userID = $userID;
  $studyAdministration->studyID = $studyID;

  $operation = $studyAdministration->insertStudyAdministration($studyAdministration);

  $arrResponse = [];
  if ($operation[2] == true) {
    $arrResponse[status] = "error";
  }else{
    $arrResponse[status] = "success";
  }

  echo json_encode($arrResponse);
?>
