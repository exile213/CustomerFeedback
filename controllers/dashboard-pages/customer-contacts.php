<?php

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login");
    exit();
}

//Logout Functionality
if (isset($_POST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login");
    exit();
}

require_once("controllers/dbconnect.php");
class CustomerContactsController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function index() {
        $contacts = $this->getAllContacts();
        require 'views/dashboard-pages/customer-contacts_view.php';
    }

    public function getAllContacts() {
        $stmt = $this->pdo->query("SELECT * FROM customer ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createContact() {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $this->pdo->prepare("INSERT INTO customer_contacts (name, email, phone, company) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['company']]);
        echo json_encode(['success' => $result]);
    }

    public function updateContact() {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $this->pdo->prepare("UPDATE customer_contacts SET name = ?, email = ?, phone = ?, company = ? WHERE id = ?");
        $result = $stmt->execute([$data['name'], $data['email'], $data['phone'], $data['company'], $data['id']]);
        echo json_encode(['success' => $result]);
    }

    public function deleteContact() {
        $data = json_decode(file_get_contents('php://input'), true);
        $stmt = $this->pdo->prepare("DELETE FROM customer_contacts WHERE id = ?");
        $result = $stmt->execute([$data['id']]);
        echo json_encode(['success' => $result]);
    }
}

// Instantiate the controller and handle actions
$controller = new CustomerContactsController($pdo);

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
            echo json_encode($controller->getAllContacts());
            break;
        default:
            $controller->index();
            break;
    }
} else {
    $controller->index();
}