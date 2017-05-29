<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

//GET METHODS
$app->get('/', function () { echo "{\"Erro\":\"diretório raiz\"}"; }); //erro no raiz

//POST METHODS
$app->post('/user/login','login');

$app->run();

function getConn()
{
	return new PDO('mysql:host=localhost;dbname=diagramchess-dev','root','mysql',

	array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

function createResponse($status, $message, $data){

		$response["status"] = $status;
		$response["message"] = $message;
		$data != null ? $response["data"] = $data : null;

		echo json_encode($response);
}

function login() {
    $request = \Slim\Slim::getInstance()->request();
    $params = json_decode($request->getBody());

    $sql = "SELECT id, firstname, lastname, login, grants, id_type_user
						FROM user
						WHERE login = :login
						AND password = md5(:password)
						AND status = 1";

    try{
            $conn = getConn();
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("login",$params->login);
						$stmt->bindParam("password",$params->password);
            $stmt->execute();
						$response = $stmt->fetch(PDO::FETCH_OBJ);

    } catch(PDOException $e){

        createResponse(0, "Error. Coudn't retrieve data.", $response);
    }

		if ($response != null) {

				//transformar a string de GRANTS em um array de strings com cada permissão separada
				$arrGrants = explode("|", $response->grants);
				$arrGrants = array_filter($arrGrants, 'strlen');
				$arrGrants = array_values($arrGrants);

				$response->grants = $arrGrants;

				createResponse(1, "The data was retrieved successfully", $response);

		}else{

				createResponse(0, "Error. Coudn't retrieve data.", $response);

		}

		$conn = null;
}
