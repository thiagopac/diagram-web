<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/Variation.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $variationID = trim(addslashes($_REQUEST['variationID']));
  $variationName = trim(addslashes($_REQUEST['variationName']));
  $variationEcoCode = trim(addslashes($_REQUEST['variationEcoCode']));
  $variationText = trim(addslashes($_REQUEST['variationText']));

  $variation = new Variation();
  $variation->id = $variationID;
  $variation->name = $variationName;
  $variation->ecoID = $variationEcoCode;
  $variation->text = $variationText;
  $variation->studyID = $studyID;

  if ($variationID == NULL) {
    $operation = $variation->insertVariation($variation);
  }else{
    $operation = $variation->editVariationForVariation($variation);
  }

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
