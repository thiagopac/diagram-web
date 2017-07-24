<?php
  require_once ('../../lib/config.php');
  require_once ('../../models/StudyRating.php');

  #CONTROLE SESSAO
	fnInicia_Sessao ('openings');

  $userID = $_SESSION['USER']['ID'];

  //FORM FIELDS
  $studyID = trim(addslashes($_REQUEST['studyID']));
  $rating = trim(addslashes($_REQUEST['rating']));
  $userID = trim(addslashes($_REQUEST['userID']));

  $studyRating= new StudyRating();
  $studyRating->rating = $rating;
  $studyRating->userID = $userID;
  $studyRating->studyID = $studyID;

  // var_dump($studyRating);
  // exit;

  $existsCheck = $studyRating->getStudyRatingForStudyAndUser($studyID, $userID);

  $studyRating->id = $existsCheck->id;

  if ($existsCheck->id != NULL) {
    $operation = $existsCheck->editRatingForRating($studyRating);
  }else{
    $operation = $existsCheck->insertRating($studyRating);
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
