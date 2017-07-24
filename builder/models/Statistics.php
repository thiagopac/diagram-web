<?php
require_once('StudyProgressPractice.php');
require_once('StudyProgressTheory.php');

class Statistics {

	//construtor da classe
	public function __construct($array){

  }

	public function __destruct(){

	}

	public function getTotalOfPracticeSessionsForStudyAndUser($paramStudy, $paramUser){

		$DB = fnDBConn();

		$SQL = "SELECT SUM(OSPP.SESSIONS) AS SUM_TOTAL_PRACTICE_SESSIONS
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE OSPP.ID_OPENING_STUDY = $paramStudy
AND OSPP.ID_USER = $paramUser";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$value = $RESULT["SUM_TOTAL_PRACTICE_SESSIONS"];

		$value = $value == NULL ? "0" : $value;

		return $value;
	}

	public function getTotalOfPracticePerfectsForStudyAndUser($paramStudy, $paramUser){

		$DB = fnDBConn();

		$SQL = "SELECT SUM(OSPP.PERFECTS) AS SUM_TOTAL_PRACTICE_PERFECTS
FROM OPENING_STUDY_PROGRESS_PRACTICE AS OSPP
WHERE OSPP.ID_OPENING_STUDY = $paramStudy
AND OSPP.ID_USER = $paramUser";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$value = $RESULT["SUM_TOTAL_PRACTICE_PERFECTS"];

		$value = $value == NULL ? "0" : $value;

		return $value;
	}

	//retornar para fins estatísticos os dados da classe de Progresso Prático
	public function getTotalProgressStudyProgressPracticeForUserAndStudy($paramUser, $paramStudy){

		$studyProgressPractice = new StudyProgressPractice();

		return $studyProgressPractice->getTotalProgressStudyProgressPracticeForUserAndStudy($paramUser, $paramStudy);

	}

	//retornar para fins estatísticos os dados da classe de Progresso Teórico
	public function getTotalProgressStudyProgressTheoryForUserAndStudy($paramUser, $paramStudy){

		$studyProgressTheory = new StudyProgressTheory();

		return $studyProgressTheory->getTotalProgressStudyProgressTheoryForUserAndStudy($paramUser, $paramStudy);
	}

}
?>
