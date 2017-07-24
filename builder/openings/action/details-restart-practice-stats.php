<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/StudyProgressPractice.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $userID = trim(addslashes($_REQUEST['userID']));

  $studyProgressPractice = new StudyProgressPractice();
  $studyProgressPractice->userID = $userID;
  $studyProgressPractice->studyID = $studyID;

  // var_dump($studyProgressPractice);
  // exit;

  $operation = $studyProgressPractice->restartStudyProgressPracticeForStudyProgressPractice($studyProgressPractice);

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
