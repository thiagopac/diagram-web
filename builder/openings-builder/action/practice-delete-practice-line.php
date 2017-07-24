<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/PracticeLine.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $practiceLineID = trim(addslashes($_REQUEST['practiceLineID']));

  $practiceLine = new PracticeLine();
  $practiceLine->id = $practiceLineID;

  // var_dump($practiceLine);
  // exit;

  $operation = $practiceLine->deletePracticeLineForPracticeLine($practiceLine);

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
