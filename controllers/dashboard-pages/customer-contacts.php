<?php
require_once __DIR__ . '/../../controllers/dbconnect.php';

class CustomerContactsController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $contacts = $this->getAllContacts();
        require __DIR__ . '/../../views/dashboard-pages/customer-contacts_view.php';
    }

    public function getAllContacts() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM customer");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching contacts: " . $e->getMessage());
            return [];
        }
    }

    public function createContact() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['Name'], $data['Email'], $data['Phone'], $data['Date'])) {
            echo json_encode(['success' => false, 'error' => 'Incomplete data']);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO customer (Name, Email, Phone, Date) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([$data['Name'], $data['Email'], $data['Phone'], $data['Date']]);
            echo json_encode(['success' => $result]);
        } catch (PDOException $e) {
            error_log("Error creating contact: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }

    public function updateContact() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['CustomerID'], $data['Name'], $data['Email'], $data['Phone'], $data['Date'])) {
            echo json_encode(['success' => false, 'error' => 'Incomplete data']);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE customer SET Name = ?, Email = ?, Phone = ?, Date = ? WHERE CustomerID = ?");
            $result = $stmt->execute([$data['Name'], $data['Email'], $data['Phone'], $data['Date'], $data['CustomerID']]);
            echo json_encode(['success' => $result]);
        } catch (PDOException $e) {
            error_log("Error updating contact: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }

    public function deleteContact() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['CustomerID'])) {
            echo json_encode(['success' => false, 'error' => 'Incomplete data']);
            return;
        }

        try {
            $stmt = $this->pdo->prepare("DELETE FROM customer WHERE CustomerID = ?");
            $result = $stmt->execute([$data['CustomerID']]);
            echo json_encode(['success' => $result]);
        } catch (PDOException $e) {
            error_log("Error deleting contact: " . $e->getMessage());
            echo json_encode(['success' => false, 'error' => 'Database error']);
        }
    }

    public function getContacts() {
        header('Content-Type: application/json');
        echo json_encode($this->getAllContacts());
    }
}

// Instantiate the controller and handle actions
$controller = new CustomerContactsController($pdo);

try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'create_contact':
                $controller->createContact();
                break;
            case 'update_contact':
                $controller->updateContact();
                break;
            case 'delete_contact':
                $controller->deleteContact();
                break;
            case 'get_contacts':
                $controller->getContacts();
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