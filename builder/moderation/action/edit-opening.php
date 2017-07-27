<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/Study.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('moderation-openings');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $interfaceLanguageID = trim(addslashes($_REQUEST['interfaceLanguage']));
  $id = trim(addslashes($_REQUEST['id']));
  $name = trim(addslashes($_REQUEST['name']));
  $side = trim(addslashes($_REQUEST['side']));
  $about = trim(addslashes($_REQUEST['about']));
  $active = trim(addslashes($_REQUEST['active']));
  $deleted = trim(addslashes($_REQUEST['deleted']));

  $study = new Study();

  $study->id = $id;
  $study->interfaceLanguageID = $interfaceLanguageID;
  $study->name = $name;
  $study->side = $side;
  $study->aboutStudy = $about;
  $study->authorID = $userID;
  $study->active = $active;
  $study->deleted = $deleted;

  $operation = $study->editStudyWithStudy($study);

  $arrResponse = [];
  if ($operation[2] == true) {
    $arrResponse[status] = "error";
  }else{
    $arrResponse[status] = "success";
  }

  echo json_encode($arrResponse);
?>
