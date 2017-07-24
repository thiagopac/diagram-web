<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/PracticeLine.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $lineID = trim(addslashes($_REQUEST['lineID']));
  $practiceLineID = trim(addslashes($_REQUEST['practiceLineID']));
  $practiceLinePGN = trim(addslashes($_REQUEST['practiceLinePGN']));

  $practiceLine = new PracticeLine();
  $practiceLine->id = $practiceLineID;
  $practiceLine->lineID = $lineID;
  $practiceLine->pgn = $practiceLinePGN;

  // var_dump($practiceLine);
  // exit;

  if ($practiceLineID == NULL) {
    $operation = $practiceLine->insertPracticeLine($practiceLine);
  }else{
    $operation = $practiceLine->editPracticeLineForPracticeLine($practiceLine);
  }

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
