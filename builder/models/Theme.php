<?php

class Theme {

	public $id;
	public $name;
	public $file;

	//construtor da classe
	public function __construct($array){

		//se o array não estiver vazio, inicializar as propriedades do objeto com os valores do array
		if (!empty($array)) {
			$this->id = $array['THEME_ID'];
			$this->name = $array['THEME_NAME'];
			$this->file = $array['THEME_FILE'];
		}
  }

	public function __destruct(){

	}

	public function getThemeWithID($paramTheme){

		$DB = fnDBConn();

		$SQL = "SELECT THM.ID AS THEME_ID, THM.NAME AS THEME_NAME, THM.FILE AS THEME_FILE
						FROM THEME AS THM
						WHERE THM.ID = $paramTheme";

		$RESULT = fnDB_DO_SELECT($DB,$SQL);

		$theme = new Theme($RESULT);

		return $theme;
	}

	public function getAllThemes(){

		$DB = fnDBConn();

		$SQL = "SELECT THM.ID AS THEME_ID, THM.NAME AS THEME_NAME, THM.FILE AS THEME_FILE
						FROM THEME AS THM
						WHERE 1
						ORDER BY THM.NAME ASC";

		$RESULT = fnDB_DO_SELECT_WHILE($DB,$SQL);

		$arrThemes = [];

		foreach ($RESULT as $KEY => $ROW) {
			$theme = new Theme($ROW);
			array_push($arrThemes, $theme);
		}

		return $arrThemes;
	}

}
?>
