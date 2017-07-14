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
  $ecoID = trim(addslashes($_REQUEST['eco']));
  $about = trim(addslashes($_REQUEST['about']));
  $active = trim(addslashes($_REQUEST['active']));
  $deleted = trim(addslashes($_REQUEST['deleted']));

  $callBackSuccess = "location: ../edit-opening.php?s=$id&success=";
  $callBackError = "location: ../edit-opening.php?s=$id&error=";

  // if ($paramInterfaceLanguage == '') {
  //   header($callBackError.urlencode('Error. Choose the language of the site.'));
  //   exit;
  // }
  //
  // if ($paramTheme == '') {
  //   header($callBackError.urlencode('Error. Choose the theme of the site.'));
  //   exit;
  // }

  $study = new Study();

  $study->id = $id;
  $study->interfaceLanguageID = $interfaceLanguageID;
  $study->name = $name;
  $study->side = $side;
  $study->ecoID = $ecoID;
  $study->aboutStudy = $about;
  $study->authorID = $userID;
  $study->active = $active;
  $study->deleted = $deleted;


  $study = $study->editStudyWithStudy($study);

  header($callBackSuccess.urlencode("Estudo alterado com sucesso!"));

  exit;
?>
