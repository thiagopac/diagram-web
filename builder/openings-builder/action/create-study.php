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
  $ecoID = trim(addslashes($_REQUEST['eco']));
  $about = trim(addslashes($_REQUEST['about']));

  $callBackSuccess = "location: ../details.php";
  $callBackError = "location: ../create-study.php?error=";

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

  $study->interfaceLanguageID = $interfaceLanguageID;
  $study->name = $name;
  $study->side = $side;
  $study->ecoID = $ecoID;
  $study->aboutStudy = $about;
  $study->authorID = $userID;

  // var_dump($study);
  // exit;

  $study = $study->insertStudy($study);
  $insertedId = $study->id;

  $callBackSuccess .= "?s=$insertedId";
  $callBackSuccess .= "&success=";

  header($callBackSuccess.urlencode("Estudo criado com sucesso!"));

  exit;

?>
