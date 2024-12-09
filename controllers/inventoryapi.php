<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once 'inventoryController.php';

$controller = new InventoryController();

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        if(isset($_GET['action'])) {
            switch($_GET['action']) {
                case 'logout':
                    $controller->logout();
                    header("Location: login_view.php");
                    exit();
                case 'export':
                    header("Content-Type: text/csv");
                    header("Content-Disposition: attachment; filename=inventory_export.csv");
                    echo $controller->exportData();
                    break;
                case 'changelog':
                    echo json_encode($controller->getChangeLog());
                    break;
                case 'categories':
                    echo json_encode($controller->getCategories());
                    break;
            }
        } else {
            echo json_encode($controller->getInventory());
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $controller->addProduct($data);
        if ($result === true) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to add product. Check server logs for details."]);
        }
        break;
    case 'PUT':
        $id = isset($_GET['id']) ? $_GET['id'] : die();
        $data = json_decode(file_get_contents("php://input"), true);
        $result = $controller->updateProduct($id, $data);
        echo json_encode(["success" => $result]);
        break;
    case 'DELETE':
        $id = isset($_GET['id']) ? $_GET['id'] : die();
        $result = $controller->deleteProduct($id);
        echo json_encode(["success" => $result]);
        break;
}

