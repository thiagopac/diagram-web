<?php
require_once('User.php');
require_once('Study.php');

class StudyAdministration {

	public $id;
	public $message;
	public $dateCreated;
	public $userID;
	public $studyID;
	public $read;
	public $deleted;

//object entities
	public $user;
	public $study;

	static $showDeleted;
	static $whereDeleted;

	static $orderBy;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND OSADM.DELETED = 0";

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['OPENING_STUDY_ADMINISTRATION_ID'];
			$this->message = $array['OPENING_STUDY_ADMINISTRATION_MESSAGE'];
			$this->dateCreated = $array['OPENING_STUDY_ADMINISTRATION_DATE_CREATED'];
			$this->userID = $array['USER_ID'];
			$this->studyID = $array['OPENING_STUDY_ID'];
			$this->read = $array['OPENING_STUDY_ADMINISTRATION_READ'];

			$this->deleted = $array['OPENING_STUDY_ADMINISTRATION_DELETED'];
		}
  }

	public function __destruct(){

	}

	public function getStudyAdministrationWithIDForUser($paramStudyAdministration, $paramUser){

		$DB = fnDBConn();

		$SQL = "SELECT OSADM.ID AS OPENING_STUDY_ADMINISTRATION_ID,
	       OSADM.MESSAGE AS OPENING_STUDY_ADMINISTRATION_MESSAGE,
	       OSADM.DIN AS OPENING_STUDY_ADMINISTRATION_DATE_CREATED,
	       OSADM.ID_USER AS USER_ID,
	       OSADM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
	       OSADM.READ AS OPENING_STUDY_ADMINISTRATION_READ,
				 OSADM.DELETED AS OPENING_STUDY_ADMINISTRATION_DELETED
	FROM OPENING_STUDY_ADMINISTRATION OSADM
	INNER JOIN OPENING_STUDY AS OS ON OS.ID = OSADM.ID_OPENING_STUDY
	WHERE OSADM.ID = $paramStudyAdministration
	AND OS.ID_USER = $paramUser";

		$SQL = $SQL.self::$whereDeleted;

		$SQL = $SQL.self::$orderBy;

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$studyAdministration = new StudyAdministration($RESULT);

		return $studyAdministration;
	}

	public function getAllStudyAdministrations(){

		$DB = fnDBConn();

		$SQL = "SELECT OSADM.ID AS OPENING_STUDY_ADMINISTRATION_ID,
       OSADM.MESSAGE AS OPENING_STUDY_ADMINISTRATION_MESSAGE,
       OSADM.DIN AS OPENING_STUDY_ADMINISTRATION_DATE_CREATED,
       OSADM.ID_USER AS USER_ID,
       OSADM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
       OSADM.READ AS OPENING_STUDY_ADMINISTRATION_READ,
			 OSADM.DELETED AS OPENING_STUDY_ADMINISTRATION_DELETED
FROM OPENING_STUDY_ADMINISTRATION OSADM
WHERE 1";

		$SQL = $SQL.self::$whereDeleted;

		$SQL = $SQL.self::$orderBy;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrSturyAdministrations = [];

		foreach($RESULT as $KEY => $ROW){
			$studyAdministration = new StudyAdministration($ROW);
			array_push($arrSturyAdministrations, $studyAdministration);
		}

		return $arrSturyAdministrations;
	}

	public function getAllStudyAdministrationsForAuthor($paramUser){

		$DB = fnDBConn();

		$SQL = "SELECT OSADM.ID AS OPENING_STUDY_ADMINISTRATION_ID,
	       OSADM.MESSAGE AS OPENING_STUDY_ADMINISTRATION_MESSAGE,
	       OSADM.DIN AS OPENING_STUDY_ADMINISTRATION_DATE_CREATED,
	       OSADM.ID_USER AS USER_ID,
	       OSADM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
	       OSADM.READ AS OPENING_STUDY_ADMINISTRATION_READ,
				 OSADM.DELETED AS OPENING_STUDY_ADMINISTRATION_DELETED
FROM OPENING_STUDY_ADMINISTRATION OSADM
INNER JOIN OPENING_STUDY AS OS ON OS.ID = OSADM.ID_OPENING_STUDY
WHERE OS.ID_USER = $paramUser";

		$SQL = $SQL.self::$whereDeleted;

		$SQL = $SQL.self::$orderBy;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrStudyAdministrations = [];

		foreach($RESULT as $KEY => $ROW){
			$studyAdministration = new StudyAdministration($ROW);
			array_push($arrStudyAdministrations, $studyAdministration);
		}

		return $arrStudyAdministrations;
	}

	public function getAllStudyAdministrationsForStudy($paramStudy){

		$DB = fnDBConn();

		$SQL = "SELECT OSADM.ID AS OPENING_STUDY_ADMINISTRATION_ID,
	       OSADM.MESSAGE AS OPENING_STUDY_ADMINISTRATION_MESSAGE,
	       OSADM.DIN AS OPENING_STUDY_ADMINISTRATION_DATE_CREATED,
	       OSADM.ID_USER AS USER_ID,
	       OSADM.ID_OPENING_STUDY AS OPENING_STUDY_ID,
	       OSADM.READ AS OPENING_STUDY_ADMINISTRATION_READ,
				 OSADM.DELETED AS OPENING_STUDY_ADMINISTRATION_DELETED
FROM OPENING_STUDY_ADMINISTRATION OSADM
WHERE OSADM.ID_OPENING_STUDY = $paramStudy";

		$SQL = $SQL.self::$whereDeleted;

		$SQL = $SQL.self::$orderBy;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrSturyAdministrations = [];

		foreach($RESULT as $KEY => $ROW){
			$studyAdministration = new StudyAdministration($ROW);
			array_push($arrSturyAdministrations, $studyAdministration);
		}

		return $arrSturyAdministrations;
	}

	public function insertStudyAdministration($paramStudyAdministration){
		$DB = fnDBConn();

		$SQL = "INSERT INTO OPENING_STUDY_ADMINISTRATION
		(MESSAGE,
		ID_USER,
		ID_OPENING_STUDY)
		VALUES('$paramStudyAdministration->message',
		'$paramStudyAdministration->userID',
		'$paramStudyAdministration->studyID')";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		// $paramStudyAdministration->id = $RET[1]; //esse array retorna na posição 0 o número de linhas afetadas pelo update e na posição 1 o id do regitro inserido

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Novo Feedback criado.");

		return $RET;
	}

	public function readStudyAdministration($paramStudyAdministration){
		$DB = fnDBConn();

		$SQL = "UPDATE OPENING_STUDY_ADMINISTRATION AS OSADM SET
		OSADM.READ = 1
WHERE OSADM.ID = '$paramStudyAdministration->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
		fnDB_LOG_AUDIT_ADD($DB,"Feedback lido.");
	}

}
?>
