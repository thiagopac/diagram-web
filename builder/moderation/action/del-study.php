<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/Study.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('moderation-openings');

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['study']));

  $study = new Study();
  $study->id = $studyID;

  $operation = $study->deleteStudy($study);

  $arrResponse = [];
  if ($operation[2] == true) {
    $arrResponse[status] = "error";
  }else{
    $arrResponse[status] = "success";
  }

  echo json_encode($arrResponse);
?>
