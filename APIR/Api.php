<?php

require_once dirname(__DIR__).'/Define.php';

// Cargar explícitamente el autoloader para asegurarnos de que la clase exista
require_once ROOT . 'Config' . DS . 'AutoLoad.php';
use Config\AutoLoad;

// Inicializa el autoloader para resolver clases por namespaces
AutoLoad::run();

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'];
$resource = isset($_GET['r']) ? trim($_GET['r']) : '';

function jsonResponse($data, $code = 200) {
	http_response_code($code);
	echo json_encode($data, JSON_UNESCAPED_UNICODE);
	exit;
}

try {
	switch ($resource) {
		case 'roles':
			if ($method !== 'GET') jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
			$model = new Models\Role();
			jsonResponse(['success' => true, 'data' => $model->toList()]);
			break;

		case 'services':
			if ($method !== 'GET') jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
			$model = new Models\Service();
			jsonResponse(['success' => true, 'data' => $model->toList()]);
			break;

		case 'users':
			$userModel = new Models\User();
			if ($method === 'GET') {
				if (isset($_GET['id']) && is_numeric($_GET['id'])) {
					$data = $userModel->getForId((int)$_GET['id']);
				} else {
					$data = $userModel->toList();
				}
				jsonResponse(['success' => true, 'data' => $data]);
			}

			if ($method === 'POST') {
				$body = json_decode(file_get_contents('php://input'), true);
				if (!$body) $body = $_POST;

				// Asignar datos entrantes a la entidad si está presente
				$entity = new Entity\eUser();
				foreach ($body as $k => $v) {
					// Asignar nombres comunes a propiedades de entidad
					$entity->$k = $v;
				}

				$userModel->save($entity);
				jsonResponse(['success' => true, 'message' => 'Usuario guardado (si la BD soporta el stored procedure)']);
			}

			jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
			break;

		case 'login':
			if ($method !== 'POST') jsonResponse(['success' => false, 'message' => 'Method not allowed'], 405);
			$body = json_decode(file_get_contents('php://input'), true);
			if (!$body) $body = $_POST;
			if (empty($body['username']) || empty($body['password'])) {
				jsonResponse(['success' => false, 'message' => 'username and password are required'], 400);
			}
			$userModel = new Models\User();
			$user = $userModel->forUserName($body['username'], $body['password']);
			if ($user) {
				jsonResponse(['success' => true, 'data' => $user]);
			} else {
				jsonResponse(['success' => false, 'message' => 'Credenciales inválidas'], 401);
			}
			break;

		case '':
			jsonResponse(['success' => true, 'message' => 'API running. Use ?r=roles|services|users|login']);
			break;

		default:
			jsonResponse(['success' => false, 'message' => 'Recurso no encontrado: '.$resource], 404);
	}

} catch (Throwable $th) {
	jsonResponse(['success' => false, 'message' => $th->getMessage()], 500);
}

?>

