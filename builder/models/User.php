<?php
require_once('Country.php');
require_once('Language.php');
require_once('InterfaceLanguage.php');
require_once('Theme.php');

class User {

	public $id;
	public $login;
	public $password;
	public $grants;
	public $firstName;
	public $lastName;
	public $fullName;
	public $avatar;
	public $eloFide;
	public $status;
	public $birthday;
	public $dateCreated;
	public $dateLastLogin;
	public $languageID;
	public $interfaceLanguageID;
	public $themeID;
	public $countryID;
	public $typeUser;
	public $deleted;

	//propriedades entidades
	public $interfaceLanguage;
	public $theme;
	public $country;
	public $language;

	static $showDeleted;
	static $whereDeleted;

	//construtor da classe
	public function __construct($array){

		self::$whereDeleted = self::$showDeleted == true ? "" : " AND U.DELETED = 0";

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['USER_ID'];
			$this->login = $array['USER_LOGIN'];
			$this->grants = $array['USER_GRANTS'];
			$this->firstName = $array['USER_FIRSTNAME'];
			$this->lastName = $array['USER_LASTNAME'];
			$this->avatar = $array['USER_AVATAR'];
			$this->eloFide = $array['USER_ELO_FIDE'];
			$this->status = $array['USER_STATUS'];
			$this->birthday = $array['USER_BIRTHDAY'];
			$this->dateCreated = $array['USER_DATE_CREATED'];
			$this->dateLastLogin = $array['USER_LAST_LOGIN'];
			$this->typeUser = $array['USER_TYPE_USER'];
			$this->deleted = $array['USER_DELETED'];
			$this->languageID = $array['LANGUAGE_ID'];
			$this->interfaceLanguageID = $array['INTERFACE_LANGUAGE_ID'];
			$this->countryID = $array['COUNTRY_ID'];
			$this->themeID = $array['THEME_ID'];

			$this->fullName = $this->firstName." ".$this->lastName;

			// $country = new Country();
			// $this->country = $country->getCountryWithID($array['COUNTRY_ID']);
			//
			// $language = new Language();
			// $this->language = $language->getLanguageWithID($array['LANGUAGE_ID']);
			//
			// $interfaceLanguage = new InterfaceLanguage();
			// $this->interfaceLanguage = $interfaceLanguage->getInterfaceLanguageWithID($array['INTERFACE_LANGUAGE_ID']);
			//
			// $theme = new Theme();
			// $this->theme = $theme->getThemeWithID($array['THEME_ID']);
		}
  }

	public function __destruct(){

	}

	public function getAllUsers(){

		$DB = fnDBConn();

		$SQL = "SELECT U.ID AS USER_ID,
       U.LOGIN AS USER_LOGIN,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME,
       U.AVATAR AS USER_AVATAR,
       U.GRANTS AS USER_GRANTS,
       U.ELO_FIDE AS USER_ELO_FIDE,
       U.STATUS AS USER_STATUS,
       U.BIRTHDAY AS USER_BIRTHDAY,
       U.DIN AS USER_DATE_CREATED,
       U.DIN_LAST_LOGIN AS USER_LAST_LOGIN,
       U.ID_TYPE_USER AS USER_TYPE_USER,
       U.ID_COUNTRY AS COUNTRY_ID,
			 U.ID_LANGUAGE AS LANGUAGE_ID,
			 U.ID_INTERFACE_LANGUAGE AS INTERFACE_LANGUAGE_ID,
			 U.ID_THEME AS THEME_ID,
			 U.DELETED AS USER_DELETED
FROM USER AS U
WHERE 1";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrUsers = [];

		foreach($RESULT as $KEY => $ROW){
	    $user = new User($ROW);
			array_push($arrUsers, $user);
	  }

		return $arrUsers;
	}

	public function getAllActiveUsers(){

		$DB = fnDBConn();

		$SQL = "SELECT U.ID AS USER_ID,
			 U.LOGIN AS USER_LOGIN,
			 U.FIRSTNAME AS USER_FIRSTNAME,
			 U.LASTNAME AS USER_LASTNAME,
			 U.AVATAR AS USER_AVATAR,
			 U.GRANTS AS USER_GRANTS,
			 U.ELO_FIDE AS USER_ELO_FIDE,
			 U.STATUS AS USER_STATUS,
			 U.BIRTHDAY AS USER_BIRTHDAY,
			 U.DIN AS USER_DATE_CREATED,
			 U.DIN_LAST_LOGIN AS USER_LAST_LOGIN,
			 U.ID_TYPE_USER AS USER_TYPE_USER,
			 U.ID_COUNTRY AS COUNTRY_ID,
			 U.ID_LANGUAGE AS LANGUAGE_ID,
			 U.ID_INTERFACE_LANGUAGE AS INTERFACE_LANGUAGE_ID,
			 U.ID_THEME AS THEME_ID,
			 U.DELETED AS USER_DELETED
FROM USER AS U
WHERE U.STATUS = 1
AND U.DELETED = 0";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrUsers = [];

		foreach($RESULT as $KEY => $ROW){
			$user = new User($ROW);
			array_push($arrUsers, $user);
		}

		return $arrUsers;
	}

	public function getAllAdministratorUsers(){

		$DB = fnDBConn();

		$SQL = "SELECT U.ID AS USER_ID,
       U.LOGIN AS USER_LOGIN,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME,
       U.AVATAR AS USER_AVATAR,
       U.GRANTS AS USER_GRANTS,
       U.ELO_FIDE AS USER_ELO_FIDE,
       U.STATUS AS USER_STATUS,
       U.BIRTHDAY AS USER_BIRTHDAY,
       U.DIN AS USER_DATE_CREATED,
       U.DIN_LAST_LOGIN AS USER_LAST_LOGIN,
       U.ID_TYPE_USER AS USER_TYPE_USER,
       U.ID_COUNTRY AS COUNTRY_ID,
			 U.ID_LANGUAGE AS LANGUAGE_ID,
			 U.ID_INTERFACE_LANGUAGE AS INTERFACE_LANGUAGE_ID,
			 U.ID_THEME AS THEME_ID,
			 U.DELETED AS USER_DELETED
FROM USER AS U
WHERE U.ID_TYPE_USER = 1";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrUsers = [];

		foreach($RESULT as $KEY => $ROW){
	    $user = new User($ROW);
			array_push($arrUsers, $user);
	  }

		return $arrUsers;
	}

	public function getUserWithId($paramUser){

		$DB = fnDBConn();

		$SQL = "SELECT U.ID AS USER_ID,
       U.LOGIN AS USER_LOGIN,
       U.FIRSTNAME AS USER_FIRSTNAME,
       U.LASTNAME AS USER_LASTNAME,
       U.AVATAR AS USER_AVATAR,
       U.GRANTS AS USER_GRANTS,
       U.ELO_FIDE AS USER_ELO_FIDE,
       U.STATUS AS USER_STATUS,
       U.BIRTHDAY AS USER_BIRTHDAY,
       U.DIN AS USER_DATE_CREATED,
       U.DIN_LAST_LOGIN AS USER_LAST_LOGIN,
       U.ID_TYPE_USER AS USER_TYPE_USER,
       U.ID_COUNTRY AS COUNTRY_ID,
			 U.ID_LANGUAGE AS LANGUAGE_ID,
			 U.ID_INTERFACE_LANGUAGE AS INTERFACE_LANGUAGE_ID,
			 U.ID_THEME AS THEME_ID,
			 U.DELETED AS USER_DELETED
FROM USER AS U
WHERE U.ID = $paramUser";

		$SQL = $SQL.self::$whereDeleted;

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$user = new User($RESULT);

		return $user;
	}

	public function updateInterfaceLanguageAndThemeForUser($paramLanguage, $paramTheme, $paramUser){
		$DB = fnDBConn();

		$SQL = "UPDATE USER AS U SET U.ID_INTERFACE_LANGUAGE = $paramLanguage,
			U.ID_THEME = $paramTheme
WHERE U.ID = $paramUser";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
	  fnDB_LOG_AUDIT_ADD($DB,"O usuário atualizou suas preferências.");
	}

	public function updateUserData($paramUser){
		$DB = fnDBConn();

		$SQL = "UPDATE USER AS U SET
		U.LOGIN = '$paramUser->login',
		U.FIRSTNAME = '$paramUser->firstName',
		U.LASTNAME = '$paramUser->lastName',
		U.GRANTS = '$paramUser->grants',
		U.ELO_FIDE = '$paramUser->eloFide',
		U.STATUS = '$paramUser->status',
		U.BIRTHDAY = '$paramUser->birthday',
		U.ID_TYPE_USER = '$paramUser->typeUser',
		U.ID_COUNTRY = '$paramUser->countryID',
		U.ID_LANGUAGE = '$paramUser->languageID',
		U.ID_THEME = '$paramUser->themeID',
		U.ID_INTERFACE_LANGUAGE = '$paramUser->interfaceLanguageID',
		U.DELETED = '$paramUser->deleted'
WHERE U.ID = '$paramUser->id'";

		$RET = fnDB_DO_EXEC($DB,$SQL);

		//Adiciona registro na tabela de auditoria
	  fnDB_LOG_AUDIT_ADD($DB,"O usuário atualizou os Dados de Usuário.");

		return $RET;
	}

}
?>
