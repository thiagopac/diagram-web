<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/TheoryGameStyle.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $theoryGameStyleID = trim(addslashes($_REQUEST['theoryGameStyleID']));
  $gameStyle = trim(addslashes($_REQUEST['textGameStyle']));

  $theoryGameStyle = new TheoryGameStyle();
  $theoryGameStyle->id = $theoryGameStyleID;
  $theoryGameStyle->text = $gameStyle;
  $theoryGameStyle->studyID = $studyID;

  $existsCheck = $theoryGameStyle->getTheoryGameStyleForStudy($studyID);

  $theoryGameStyle->id = $existsCheck->id;

  if ($existsCheck->id != NULL) {
    $operation = $theoryGameStyle->editTheoryGameStyleForTheoryGameStyle($theoryGameStyle);
  }else{
    $operation = $theoryGameStyle->insertTheoryGameStyle($theoryGameStyle);
  }

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
