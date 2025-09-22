<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/../config/database.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit(json_encode(['error' => 'Method not allowed']));
}

// Check if ID is provided
if (!isset($_POST['id']) || empty($_POST['id'])) {
    http_response_code(400);
    exit(json_encode(['error' => 'ID is required']));
}

try {
    $pdo = Database::getConnection();

    // Get the ID from POST data
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Begin transaction
    $pdo->beginTransaction();

    // Prepare DELETE statement
    $stmt = $pdo->prepare("DELETE FROM train_maintenance_report WHERE id = :id");

    // Execute with the ID
    $result = $stmt->execute(['id' => $id]);

    if ($result && $stmt->rowCount() > 0) {
        // Commit the transaction
        $pdo->commit();

        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Record deleted successfully'
        ]);
    } else {
        // If no rows were affected, rollback and return error
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode([
            'error' => 'Record not found or already deleted'
        ]);
    }
} catch (PDOException $e) {
    // If there's an error, rollback the transaction
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Return error response
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error occurred',
        'message' => $e->getMessage()
    ]);
} catch (Exception $e) {
    // Handle any other errors
    http_response_code(500);
    echo json_encode([
        'error' => 'An error occurred',
        'message' => $e->getMessage()
    ]);
}
