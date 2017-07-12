<?php

class StudyProgressPractice {

	public $id;
	public $practiceLineID;
	public $sessions;
	public $errors;
	public $tips;
	public $perfects;
	public $userID;
	public $studyID;
	public $dateUpdated;
	public $deleted;

	static $showDeleted;
	static $whereDeleted;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND OSPP.DELETED = 0";

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_PROGRESS_PRACTICE_ID'];
			$this->practiceLineID = $array['OPENING_PRACTICE_LINE_ID'];
			$this->sessions = $array['OPENING_STUDY_PROGRESS_PRACTICE_SESSIONS'];
			$this->errors = $array['OPENING_STUDY_PROGRESS_PRACTICE_ERRORS'];
			$this->tips = $array['OPENING_STUDY_PROGRESS_PRACTICE_TIPS'];
			$this->perfects = $array['OPENING_STUDY_PROGRESS_PRACTICE_PERFECTS'];
			$this->userID = $array['USER_ID'];
			$this->studyID = $array['OPENING_STUDY_ID'];
			$this->dateUpdated = $array['OPENING_STUDY_PROGRESS_PRACTICE_UPDATED'];
			$this->deleted = $array['OPENING_STUDY_PROGRESS_PRACTICE_DELETED'];
		}
  }

	public function __destruct(){

	}

	public function getStudyProgressPracticeWithID($paramStudyProgressPractice){

		$DB = fnDBConn();

		$SQL = "SELECT OSPP.ID AS OPENING_STUDY_PROGRESS_PRACTICE_ID,
       OSPP.ID_OPENING_STUDY_PRACTICE_LINE AS OPENING_PRACTICE_LINE_ID,
       OSPP.SESSIONS AS OPENING_STUDY_PROGRESS_PRACTICE_SESSIONS,
       OSPP.ERRORS AS OPENING_STUDY_PROGRESS_PRACTICE_ERRORS,
       OSPP.TIPS AS OPENING_STUDY_PROGRESS_PRACTICE_TIPS,
       OSPP.PERFECTS AS OPENING_STUDY_PROGRESS_PRACTICE_PERFECTS,
       OSPP.ID_USER AS USER_ID,
       OSPP.DIN_LAST_UPDATE AS OPENING_STUDY_PROGRESS_PRACTICE_UPDATED,
       OSPP.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSPP.DELETED AS OPENING_STUDY_PROGRESS_PRACTICE_DELETED
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE 1 = $paramStudyProgressPractice";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyProgressPractice = new StudyProgressPractice($RESULT);

		return $studyProgressPractice;
	}

	public function getStudyProgressPracticeForUserAndStudy($paramUser, $paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSPP.ID AS OPENING_STUDY_PROGRESS_PRACTICE_ID,
       OSPP.ID_OPENING_STUDY_PRACTICE_LINE AS OPENING_PRACTICE_LINE_ID,
       OSPP.SESSIONS AS OPENING_STUDY_PROGRESS_PRACTICE_SESSIONS,
       OSPP.ERRORS AS OPENING_STUDY_PROGRESS_PRACTICE_ERRORS,
       OSPP.TIPS AS OPENING_STUDY_PROGRESS_PRACTICE_TIPS,
       OSPP.PERFECTS AS OPENING_STUDY_PROGRESS_PRACTICE_PERFECTS,
       OSPP.ID_USER AS USER_ID,
       OSPP.DIN_LAST_UPDATE AS OPENING_STUDY_PROGRESS_PRACTICE_UPDATED,
       OSPP.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSPP.DELETED AS OPENING_STUDY_PROGRESS_PRACTICE_DELETED
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE OSPP.ID_OPENING_STUDY = $paramStudy
AND OSPP.ID_USER = $paramUser";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrStudyProgressPractice = [];

		foreach ($RESULT as $KEY => $ROW) {
				$studyProgressPractice = new StudyProgressPractice($ROW);
				array_push($arrStudyProgressPractice, $studyProgressPractice);
		}

		return $arrStudyProgressPractice;
	}

	public function getStudyProgressPracticeForUserStudyAndPracticeLine($paramUser, $paramStudy, $paramPracticeLine){

		$DB = fnDBConn();

		$SQL = "SELECT OSPP.ID AS OPENING_STUDY_PROGRESS_PRACTICE_ID,
       OSPP.ID_OPENING_STUDY_PRACTICE_LINE AS OPENING_PRACTICE_LINE_ID,
       OSPP.SESSIONS AS OPENING_STUDY_PROGRESS_PRACTICE_SESSIONS,
       OSPP.ERRORS AS OPENING_STUDY_PROGRESS_PRACTICE_ERRORS,
       OSPP.TIPS AS OPENING_STUDY_PROGRESS_PRACTICE_TIPS,
       OSPP.PERFECTS AS OPENING_STUDY_PROGRESS_PRACTICE_PERFECTS,
       OSPP.ID_USER AS USER_ID,
       OSPP.DIN_LAST_UPDATE AS OPENING_STUDY_PROGRESS_PRACTICE_UPDATED,
       OSPP.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSPP.DELETED AS OPENING_STUDY_PROGRESS_PRACTICE_DELETED
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE OSPP.ID_OPENING_STUDY = $paramStudy
AND OSPP.ID_USER = $paramUser
AND OSPP.ID_OPENING_STUDY_PRACTICE_LINE = $paramPracticeLine";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyProgressPractice = new StudyProgressPractice($RESULT);

		return $studyProgressPractice;
	}

	public function getTotalProgressStudyProgressPracticeForUserAndStudy($paramUser, $paramStudy){

		$DB = fnDBConn();

		$SQLUSERHASPRACTICED = "SELECT COUNT(OSPP.ID) AS COUNT_PROGRESS_PRACTICED
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE OSPP.ID_OPENING_STUDY = $paramStudy
AND OSPP.ID_USER = $paramUser";

		$SQLUSERHASPRACTICED = $SQLUSERHASPRACTICED.self::$whereDeleted;

		$RESULTUSERHASPRACTICED = fnDB_DO_SELECT($DB,$SQLUSERHASPRACTICED);

		$SQLTOTALPRACTICELINES = "SELECT COUNT(OSPL.ID) AS TOTAL_STUDY_PRACTICE_LINES
FROM OPENING_STUDY_PRACTICE_LINE AS OSPL
INNER JOIN OPENING_STUDY_THEORY_LINE AS OSTL ON OSTL.ID = OSPL.ID_OPENING_STUDY_THEORY_LINE
INNER JOIN OPENING_STUDY_THEORY_VARIATION AS OSTV ON OSTV.ID = OSTL.ID_OPENING_STUDY_THEORY_VARIATION
WHERE OSTV.ID_OPENING_STUDY = $paramStudy
AND OSTV.DELETED = 0
AND OSPL.DELETED = 0";

		$RESULTTOTALPRACTICELINES = fnDB_DO_SELECT($DB,$SQLTOTALPRACTICELINES);

		$progress = ($RESULTUSERHASPRACTICED["COUNT_PROGRESS_PRACTICED"] / $RESULTTOTALPRACTICELINES["TOTAL_STUDY_PRACTICE_LINES"]) * 100;

		$roundedProgress = number_format((float)$progress, 1, '.', '');

		//evitar que de alguma forma, o valor ultrapasse 100%
		$roundedProgress = $roundedProgress > 100 ? 100 : $roundedProgress;

		return $roundedProgress;
		// return round($progress);
	}

}

?>
