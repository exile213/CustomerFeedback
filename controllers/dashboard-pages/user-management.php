<?php
require_once __DIR__ . '/controllers/dbconnect.php';

class UserManagementController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $users = $this->getAllUsers();
        require __DIR__ . '/views/dashboard-page/user_management.php';
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT id, name, email, role, status FROM employee");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = $data['role'];
        $status = $data['status'];

        $stmt = $this->pdo->prepare("INSERT INTO employee (name, email, password, role, status) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$name, $email, $password, $role, $status]);

        echo json_encode(['success' => $result]);
    }

    public function updateUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];
        $name = $data['name'];
        $email = $data['email'];
        $role = $data['role'];
        $status = $data['status'];

        $stmt = $this->pdo->prepare("UPDATE employee SET name = ?, email = ?, role = ?, status = ? WHERE id = ?");
        $result = $stmt->execute([$name, $email, $role, $status, $id]);

        echo json_encode(['success' => $result]);
    }

    public function deleteUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'];

        $stmt = $this->pdo->prepare("DELETE FROM employee WHERE id = ?");
        $result = $stmt->execute([$id]);

        echo json_encode(['success' => $result]);
    }
}

// Instantiate the controller and call the index method
$controller = new UserManagementController($pdo);

// Check if an action is specified
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'create_user':
            $controller->createUser();
            break;
        case 'update_user':
            $controller->updateUser();
            break;
        case 'delete_user':
            $controller->deleteUser();
            break;
        case 'get_users':
            echo json_encode($controller->getAllUsers());
            break;
        default:
            $controller->index();
            break;
    }
} else {
    $controller->index();
}