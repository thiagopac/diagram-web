<?php
require_once('User.php');
require_once('Study.php');

class StudyRating {

	public $id;
	public $rating;
	public $userID;
	public $studyID;
	public $dateUpdated;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_RATING_ID'];
			$this->rating = $array['OPENING_RATING_RATING'];

			$this->userID = $array['USER_ID'];
			$this->studyID = $array['OPENING_STUDY_ID'];

			// if (!empty($array['USER_ID'])) {
			// 	$user = new User();
			// 	$this->user = $user->getUserWithID($array['USER_ID']);
			// }

			// if (!empty($array['OPENING_STUDY_ID'])) {
			// 	$study = new Study();
			// 	$this->study = $study->getBasicDataStudyWithID($array['OPENING_STUDY_ID']);
			// }

			$this->dateCreated = $array['OPENING_RATING_DATE_UPDATED'];
		}
  }

	public function __destruct(){

	}

	public function getStudyRatingWithID($paramStudyRating){

		$DB = fnDBConn();

		$SQL = "SELECT ORT.ID AS OPENING_RATING_ID,
       ORT.RATING AS OPENING_RATING_RATING,
       ORT.ID_USER AS USER_ID,
       ORT.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       ORT.DIN_LAST_UPDATE AS OPENING_RATING_DATE_UPDATED
FROM OPENING_STUDY_RATING AS ORT
WHERE ORT.ID = $paramStudyRating";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyRating = new StudyRating($RESULT);

		return $studyRating;
	}

	public function getStudyRatingForStudyAndUser($paramStudy, $paramAuthor){

		$DB = fnDBConn();

		$SQL = "SELECT ORT.ID AS OPENING_RATING_ID,
       ORT.RATING AS OPENING_RATING_RATING,
       ORT.ID_USER AS USER_ID,
       ORT.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       ORT.DIN_LAST_UPDATE AS OPENING_RATING_DATE_UPDATED
FROM OPENING_STUDY_RATING AS ORT
WHERE ORT.ID_OPENING_STUDY = $paramStudy
AND ORT.ID_USER = $paramAuthor";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyRating = new StudyRating($RESULT);

		return $studyRating;
	}

	public function getAverageStudyRatingForStudy($paramStudyRating){

		$DB = fnDBConn();

		$SQL = "SELECT ROUND(AVG(ORT.RATING),2) OPENING_RATING_RATING
FROM OPENING_STUDY_RATING AS ORT
WHERE ORT.ID_OPENING_STUDY = $paramStudyRating";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyRating = new StudyRating($RESULT);

		return $studyRating;
	}

}
?>
