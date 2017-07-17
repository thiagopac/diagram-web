<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/Line.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $lineID = trim(addslashes($_REQUEST['lineID']));
  $lineVariationID = trim(addslashes($_REQUEST['lineVariationID']));
  $lineName = trim(addslashes($_REQUEST['lineName']));
  $lineText = trim(addslashes($_REQUEST['lineText']));
  $linePGN = trim(addslashes($_REQUEST['linePGN']));

  //retira as chaves vazias de comentários
  $linePGN = str_replace("{}", "", $linePGN);
  $linePGN = str_replace("{ }", "", $linePGN);
  $linePGN = str_replace("{  }", "", $linePGN);

  $line = new Line();
  $line->id = $lineID;
  $line->name = $lineName;
  $line->text = $lineText;
  $line->variationID = $lineVariationID ;
  $line->pgn =  $linePGN;

  if ($lineID == NULL) {
    $operation = $line->insertLine($line);
  }else{
    $operation = $line->editLineForLine($line);
  }

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
