<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/Study.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $interfaceLanguageID = trim(addslashes($_REQUEST['interfaceLanguageID']));
  $name = trim(addslashes($_REQUEST['name']));
  $side = trim(addslashes($_REQUEST['side']));
  $about = trim(addslashes($_REQUEST['about']));

  $study = new Study();
  $study->id = $studyID;
  $study->interfaceLanguageID = $interfaceLanguageID;
  $study->name = $name;
  $study->side = $side;
  $study->aboutStudy = $about;

  $studyAux = $study->getStudyWithID($study->id);

  $study->authorID = $studyAux->authorID;
  $study->active = $studyAux->active;
  $study->deleted = $studyAux->deleted;

  $operation = $study->editStudyWithStudy($study);

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
