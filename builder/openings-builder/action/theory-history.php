<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/TheoryHistory.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $theoryHistoryID = trim(addslashes($_REQUEST['theoryHistoryID']));
  $history = trim(addslashes($_REQUEST['textHistory']));

  $theoryHistory = new TheoryHistory();
  $theoryHistory->id = $theoryHistoryID;
  $theoryHistory->text = $history;
  $theoryHistory->studyID = $studyID;

  $existsCheck = $theoryHistory->getTheoryHistoryForStudy($studyID);

  $theoryHistory->id = $existsCheck->id;

  if ($existsCheck->id != NULL) {
    $operation = $theoryHistory->editTheoryHistoryForTheoryHistory($theoryHistory);
  }else{
    $operation = $theoryHistory->insertTheoryHistory($theoryHistory);
  }

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
