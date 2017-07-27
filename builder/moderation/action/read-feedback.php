<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/StudyAdministration.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('moderation-inbox');

  //FORM FIELDS
  $studyAdministrationID = trim(addslashes($_REQUEST['studyAdministrationID']));

  $studyAdministration = new StudyAdministration();

  $studyAdministration->id = $studyAdministrationID;

  $operation = $studyAdministration->readStudyAdministration($studyAdministration);

  $arrResponse = [];
  if ($operation[2] == true) {
    $arrResponse[status] = "error";
  }else{
    $arrResponse[status] = "success";
  }

  echo json_encode($arrResponse);
?>
