<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/Study.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $interfaceLanguageID = trim(addslashes($_REQUEST['interfaceLanguage']));
	$name = trim(addslashes($_REQUEST['name']));
  $side = trim(addslashes($_REQUEST['side']));
  $about = trim(addslashes($_REQUEST['about']));

  $study = new Study();

  $study->interfaceLanguageID = $interfaceLanguageID;
  $study->name = $name;
  $study->side = $side;
  $study->aboutStudy = $about;
  $study->authorID = $userID;

  $operation = $study->insertStudy($study);
  $insertedID = $operation[1];

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
    $arrResponse[studyID] = $insertedID;
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
