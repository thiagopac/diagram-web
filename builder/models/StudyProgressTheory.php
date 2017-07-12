<?php

class StudyProgressTheory {

	public $id;
	public $learned;
	public $lineID;
	public $userID;
	public $studyID;
	public $dateUpdated;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_PROGRESS_THEORY_ID'];
			$this->learned = $array['OPENING_STUDY_PROGRESS_THEORY_LEARNED'];
			$this->lineID = $array['OPENING_LINE_ID'];
			$this->userID = $array['USER_ID'];
			$this->studyID = $array['OPENING_STUDY_ID'];
			$this->dateUpdated = $array['OPENING_STUDY_PROGRESS_THEORY_UPDATED'];

		}
  }

	public function __destruct(){

	}

	public function getStudyProgressTheoryWithID($paramStudyProgressTheory){

		$DB = fnDBConn();

		$SQL = "SELECT OSPT.ID AS OPENING_STUDY_PROGRESS_THEORY_ID,
       OSPT.LEARNED AS OPENING_STUDY_PROGRESS_THEORY_LEARNED,
       OSPT.ID_OPENING_STUDY_THEORY_LINE AS OPENING_LINE_ID,
       OSPT.ID_USER AS USER_ID,
			 OSPT.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSPT.DIN_LAST_UPDATE AS OPENING_STUDY_PROGRESS_THEORY_UPDATED
FROM OPENING_STUDY_PROGRESS_THEORY AS OSPT
WHERE OSPT.ID = $paramStudyProgressTheory";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyProgressTheory = new StudyProgressTheory($RESULT);

		return $studyProgressTheory;
	}

	public function getStudyProgressTheoryForUserAndStudy($paramUser, $paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSPT.ID AS OPENING_STUDY_PROGRESS_THEORY_ID,
       OSPT.LEARNED AS OPENING_STUDY_PROGRESS_THEORY_LEARNED,
       OSPT.ID_OPENING_STUDY_THEORY_LINE AS OPENING_LINE_ID,
       OSPT.ID_USER AS USER_ID,
			 OSPT.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSPT.DIN_LAST_UPDATE AS OPENING_STUDY_PROGRESS_THEORY_UPDATED
FROM OPENING_STUDY_PROGRESS_THEORY AS OSPT
WHERE OSPT.ID_OPENING_STUDY = $paramStudy
AND OSPT.ID_USER = $paramUser";

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrStudyProgressTheory = [];

		foreach ($RESULT as $KEY => $ROW) {
				$studyProgressTheory = new StudyProgressTheory($ROW);
				array_push($arrStudyProgressTheory, $studyProgressTheory);
		}

		return $arrStudyProgressTheory;
	}

	public function getStudyProgressTheoryForUserStudyAndLine($paramUser, $paramStudy, $paramLine){

		$DB = fnDBConn();

		$SQL = "SELECT OSPT.ID AS OPENING_STUDY_PROGRESS_THEORY_ID,
			 OSPT.LEARNED AS OPENING_STUDY_PROGRESS_THEORY_LEARNED,
			 OSPT.ID_OPENING_STUDY_THEORY_LINE AS OPENING_LINE_ID,
			 OSPT.ID_USER AS USER_ID,
			 OSPT.ID_OPENING_STUDY AS OPENING_STUDY_ID,
			 OSPT.DIN_LAST_UPDATE AS OPENING_STUDY_PROGRESS_THEORY_UPDATED
FROM OPENING_STUDY_PROGRESS_THEORY AS OSPT
WHERE OSPT.ID_OPENING_STUDY = $paramStudy
AND OSPT.ID_USER = $paramUser
AND OSPT.ID_OPENING_STUDY_THEORY_LINE = $paramLine";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyProgressTheory = new StudyProgressTheory($RESULT);

		return $studyProgressTheory;
	}

	public function getTotalProgressStudyProgressTheoryForUserAndStudy($paramUser, $paramStudy){

		$DB = fnDBConn();

		$SQLUSERHASLEARNED = "SELECT SUM(OSPT.LEARNED) AS SUM_PROGRESS_LEARNED
FROM OPENING_STUDY_PROGRESS_THEORY AS OSPT
WHERE OSPT.ID_OPENING_STUDY = $paramStudy
AND OSPT.ID_USER = $paramUser";

		$RESULTUSERHASLEARNED = fnDB_DO_SELECT($DB,$SQLUSERHASLEARNED);

		$SQLTOTALLINES = "SELECT COUNT(OSTL.ID) AS TOTAL_STUDY_LINES
FROM OPENING_STUDY_THEORY_LINE AS OSTL
INNER JOIN OPENING_STUDY_THEORY_VARIATION AS OSTV ON OSTV.ID = OSTL.ID_OPENING_STUDY_THEORY_VARIATION
WHERE OSTV.ID_OPENING_STUDY = $paramStudy
AND OSTV.DELETED = 0
AND OSTL.DELETED = 0";

		$RESULTTOTALLINES = fnDB_DO_SELECT($DB,$SQLTOTALLINES);

		$progress = ($RESULTUSERHASLEARNED["SUM_PROGRESS_LEARNED"] / $RESULTTOTALLINES["TOTAL_STUDY_LINES"]) * 100;

		$roundedProgress = number_format((float)$progress, 1, '.', '');

		//evitar que de alguma forma, o valor ultrapasse 100%
		$roundedProgress = $roundedProgress > 100 ? 100 : $roundedProgress;

		return $roundedProgress;
		// return round($progress);
	}

}
?>
