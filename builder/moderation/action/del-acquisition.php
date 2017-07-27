<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/Acquisition.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('moderation-openings');

  //FORM FIELDS
  $acquisitionID = trim(addslashes($_REQUEST['acquisition']));

  $acquisition = new Acquisition();
  $acquisition->id = $acquisitionID;

  $operation = $acquisition->deleteAcquisition($acquisition);

  $arrResponse = [];
  if ($operation[2] == true) {
    $arrResponse[status] = "error";
  }else{
    $arrResponse[status] = "success";
  }

  echo json_encode($arrResponse);
?>
