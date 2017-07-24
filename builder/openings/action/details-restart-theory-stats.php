<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/StudyProgressTheory.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $userID = trim(addslashes($_REQUEST['userID']));

  $studyProgressTheory = new StudyProgressTheory();
  $studyProgressTheory->userID = $userID;
  $studyProgressTheory->studyID = $studyID;

  // var_dump($studyProgressTheory);
  // exit;

  $operation = $studyProgressTheory->restartStudyProgressTheoryForStudyProgressTheory($studyProgressTheory);

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
