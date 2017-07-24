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

	//construtor da classe
	public function __construct($array){

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
       OSPP.ID_OPENING_STUDY AS OPENING_STUDY_ID
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE 1 = $paramStudyProgressPractice";

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
       OSPP.ID_OPENING_STUDY AS OPENING_STUDY_ID
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE OSPP.ID_OPENING_STUDY = $paramStudy
AND OSPP.ID_USER = $paramUser";

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
       OSPP.ID_OPENING_STUDY AS OPENING_STUDY_ID
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE OSPP.ID_OPENING_STUDY = $paramStudy
AND OSPP.ID_USER = $paramUser
AND OSPP.ID_OPENING_STUDY_PRACTICE_LINE = $paramPracticeLine";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyProgressPractice = new StudyProgressPractice($RESULT);

		return $studyProgressPractice;
	}

	public function getTotalProgressStudyProgressPracticeForUserAndStudy($paramUser, $paramStudy){

		$DB = fnDBConn();

		$SQLUSERHASPRACTICED = "SELECT COUNT(OSPP.ID) AS COUNT_PROGRESS_PRACTICED
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE OSPP.ID_OPENING_STUDY = $paramStudy
AND OSPP.ID_USER = $paramUser
AND OSPP.SESSIONS > 0";

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

		$roundedProgress = number_format((float)$progress, 0, '.', '');

		//evitar que de alguma forma, o valor ultrapasse 100%
		$roundedProgress = $roundedProgress > 100 ? 100 : $roundedProgress;

		return $roundedProgress;
		// return round($progress);
	}

	public function restartStudyProgressPracticeForStudyProgressPractice($paramStudyProgressPractice){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_PROGRESS_PRACTICE AS OSPP SET
		OSPP.SESSIONS = '0',
		OSPP.ERRORS = '0',
		OSPP.TIPS = '0',
		OSPP.PERFECTS = '0'
WHERE OSPP.ID_OPENING_STUDY = $paramStudyProgressPractice->studyID
AND OSPP.ID_USER = $paramStudyProgressPractice->userID";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Usuário reiniciou as estatísticas práticas.");
	}

	public function insertStudyProgressPractice($paramStudyProgressPractice){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY_PROGRESS_PRACTICE
		(ID_OPENING_STUDY_PRACTICE_LINE,
		SESSIONS,
		TIPS,
		ERRORS,
		PERFECTS,
		ID_OPENING_STUDY,
		ID_USER)
		VALUES('$paramStudyProgressPractice->practiceLineID',
		1,
		'$paramStudyProgressPractice->tips',
		'$paramStudyProgressPractice->errors',
		'$paramStudyProgressPractice->perfects',
		'$paramStudyProgressPractice->studyID',
		'$paramStudyProgressPractice->userID')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		// $paramStudyProgressTheory->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Usuário iniciou progresso prático de nova linha.");

		return $RET;
	}

	public function increaseProgressForStudyProgressPractice($paramStudyProgressPractice){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_PROGRESS_PRACTICE AS OSPP SET
		OSPP.SESSIONS = OSPP.SESSIONS + 1,
		OSPP.TIPS = OSPP.TIPS + '$paramStudyProgressPractice->tips',
		OSPP.ERRORS = OSPP.ERRORS + '$paramStudyProgressPractice->errors',
		OSPP.PERFECTS = OSPP.PERFECTS + '$paramStudyProgressPractice->perfects'
WHERE OSPP.ID_OPENING_STUDY = $paramStudyProgressPractice->studyID
AND OSPP.ID_USER = $paramStudyProgressPractice->userID
AND OSPP.ID_OPENING_STUDY_PRACTICE_LINE = $paramStudyProgressPractice->practiceLineID";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Usuário fez progresso prático em linha já treinada.");
	}

}

?>
