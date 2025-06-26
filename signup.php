<?php
require '../config/db.php';
require '../config/cors.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'], $_POST['password'], $_POST['email'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $email = trim($_POST['email']);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("
                INSERT INTO users (username, password, email) 
                VALUES (:username, :password, :email)
            ");

            $result = $stmt->execute([
                'username' => $username,
                'password' => $hashedPassword,
                'email'    => $email
            ]);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Signup successful!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to register user.']);
            }
        } catch (PDOException $e) {
            if ($e->getCode() === '23505') {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'This email is already registered. Try logging in or use another email.'
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'PDO Error: ' . $e->getMessage()]);
            }
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}