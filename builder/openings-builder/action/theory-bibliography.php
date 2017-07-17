<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/TheoryBibliography.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings-builder');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $theoryBibliographyID = trim(addslashes($_REQUEST['theoryBibliographyID']));
  $bibliography = trim(addslashes($_REQUEST['textBibliography']));

  $theoryBibliography = new TheoryBibliography();
  $theoryBibliography->id = $theoryBibliographyID;
  $theoryBibliography->text = $bibliography;
  $theoryBibliography->studyID = $studyID;

  $existsCheck = $theoryBibliography->getTheoryBibliographyForStudy($studyID);

  $theoryBibliography->id = $existsCheck->id;

  if ($existsCheck->id != NULL) {
    $operation = $theoryBibliography->editTheoryBibliographyForTheoryBibliography($theoryBibliography);
  }else{
    $operation = $theoryBibliography->insertTheoryBibliography($theoryBibliography);
  }

  // var_dump($existsCheck);

  $arrResponse = [];
  if ($operation[2] == false) {
    $arrResponse[status] = "success";
  }else{
    $arrResponse[status] = "error";
  }

  echo json_encode($arrResponse);
?>
