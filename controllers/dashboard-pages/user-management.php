<?php
require_once __DIR__ . '/../../controllers/dbconnect.php';

class UserManagementController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $users = $this->getAllUsers();
        require __DIR__ . '/../../views/dashboard-pages/user-management_view.php';
    }

    public function getAllUsers() {
        try {
            $stmt = $this->pdo->query("SELECT EmployeeID, name, email, role, Status FROM employee");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching users: " . $e->getMessage());
            return [];
        }
    }

    public function createUser() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        // Validate input data
        if (!isset($data['name'], $data['email'], $data['password'], $data['role'])) {
            echo json_encode(['success' => false, 'error' => 'Incomplete data']);
            return;
        }
        
        $name = $data['name'];
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $role = $data['role'];
        $status = isset($data['Status']) ? $data['Status'] : 'pending'; // Default to 'pending' if not set

        try {
            $stmt = $this->pdo->prepare("INSERT INTO employee (name, email, password, role, Status) VALUES (?, ?, ?, ?, ?)");
            $result = $stmt->execute([$name, $email, $password, $role, $status]);
            echo json_encode(['success' => $result]);
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }

    public function updateUser() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['EmployeeID'], $data['name'], $data['email'], $data['role'])) {
            echo json_encode(['success' => false, 'error' => 'Incomplete data']);
            return;
        }
        
        $id = $data['EmployeeID'];
        $name = $data['name'];
        $email = $data['email'];
        $role = $data['role'];
        $status = isset($data['Status']) ? $data['Status'] : 'pending'; // Default to 'pending' if not set

        try {
            $sql = "UPDATE employee SET name = ?, email = ?, role = ?, Status = ?";
            $params = [$name, $email, $role, $status];

            if (!empty($data['password'])) {
                $password = password_hash($data['password'], PASSWORD_DEFAULT);
                $sql .= ", password = ?";
                $params[] = $password;
            }

            $sql .= " WHERE EmployeeID = ?";
            $params[] = $id;

            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute($params);
            echo json_encode(['success' => $result]);
        } catch (PDOException $e) {
            error_log("Error updating user: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }

    public function deleteUser() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['EmployeeID'];

        try {
            $stmt = $this->pdo->prepare("DELETE FROM employee WHERE EmployeeID = ?");
            $result = $stmt->execute([$id]);
            echo json_encode(['success' => $result]);
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }

    public function getUsers() {
        header('Content-Type: application/json');
        echo json_encode($this->getAllUsers());
    }
}

// Instantiate the controller and handle actions
$controller = new UserManagementController($pdo);

try {
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
                $controller->getUsers();
                break;
            default:
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Invalid action']);
                break;
        }
    } else {
        $controller->index();
    }
} catch (Exception $e) {
    error_log("Unhandled error: " . $e->getMessage());
    header('Content-Type: application/json');
    echo json_encode(['error' => 'An unexpected error occurred']);
}