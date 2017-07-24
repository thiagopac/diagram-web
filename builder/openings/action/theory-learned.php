<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/StudyProgressTheory.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $studyProgressID = trim(addslashes($_REQUEST['studyProgressID']));
  $lineID = trim(addslashes($_REQUEST['lineID']));
  $learned = trim(addslashes($_REQUEST['learned']));

  // var_dump($studyID);
  // var_dump($lineID);
  // var_dump($learned);
  // exit;
  //
  $studyProgressTheory = new StudyProgressTheory();
  $studyProgressTheory->id = $studyProgressID;
  $studyProgressTheory->learned = $learned;
  $studyProgressTheory->lineID = $lineID;
  $studyProgressTheory->userID = $userID;
  $studyProgressTheory->studyID = $studyID;

  // var_dump($studyProgressTheory);
  // exit;

  $existsCheck = $studyProgressTheory->getStudyProgressTheoryForUserStudyAndLine($userID, $studyID, $lineID);

  $studyProgressTheory->id = $existsCheck->id;

  if ($existsCheck->id != NULL) {
    $operation = $studyProgressTheory->editStudyProgressTheoryForStudyProgressTheory($studyProgressTheory);
  }else{
    $operation = $studyProgressTheory->insertStudyProgressTheory($studyProgressTheory);
  }

  // var_dump($existsCheck);

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
    $arrResponse[progress] = $studyProgressTheory->getTotalProgressStudyProgressTheoryForUserAndStudy($userID, $studyID);
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
