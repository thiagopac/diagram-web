<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/StudyProgressPractice.php');
  require_once ('../../models/PracticeLine.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $userID = trim(addslashes($_REQUEST['userID']));
  $practiceLineID = trim(addslashes($_REQUEST['practiceLineID']));
  $errors = trim(addslashes($_REQUEST['errors']));
  $tips = trim(addslashes($_REQUEST['tips']));
  $perfects = trim(addslashes($_REQUEST['perfects']));

  $studyProgressPractice = new StudyProgressPractice();
  $studyProgressPractice->userID = $userID;
  $studyProgressPractice->studyID = $studyID;
  $studyProgressPractice->practiceLineID = $practiceLineID;
  $studyProgressPractice->errors = $errors;
  $studyProgressPractice->tips = $tips;
  $studyProgressPractice->perfects = $perfects;

  $existsCheck = $studyProgressPractice->getStudyProgressPracticeForUserStudyAndPracticeLine($userID, $studyID, $practiceLineID);

  if ($existsCheck->id != NULL) {
    $operation = $studyProgressPractice->increaseProgressForStudyProgressPractice($studyProgressPractice);
  }else{
    $operation = $studyProgressPractice->insertStudyProgressPractice($studyProgressPractice);
  }

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
