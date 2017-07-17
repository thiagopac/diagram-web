<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/TheoryMainGrandMasters.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $theoryMainGrandMastersID = trim(addslashes($_REQUEST['theoryMainGrandMastersID']));
  $mainGrandMasters = trim(addslashes($_REQUEST['textMainGrandMasters']));

  $theoryMainGrandMasters = new TheoryMainGrandMasters();
  $theoryMainGrandMasters->id = $theoryMainGrandMastersID;
  $theoryMainGrandMasters->text = $mainGrandMasters;
  $theoryMainGrandMasters->studyID = $studyID;

  $existsCheck = $theoryMainGrandMasters->getTheoryMainGrandMastersForStudy($studyID);

  $theoryMainGrandMasters->id = $existsCheck->id;

  if ($existsCheck->id != NULL) {
    $operation = $theoryMainGrandMasters->editTheoryMainGrandMastersForTheoryMainGrandMasters($theoryMainGrandMasters);
  }else{
    $operation = $theoryMainGrandMasters->insertTheoryMainGrandMasters($theoryMainGrandMasters);
  }

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
