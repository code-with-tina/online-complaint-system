<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];

    // Check if user exists
    $user_check = $conn->prepare("SELECT id FROM users WHERE username=?");
    $user_check->bind_param("s", $username);
    $user_check->execute();
    $user_check->store_result();

    if ($user_check->num_rows == 0) {
        // Create user with default password
        $password = password_hash("1234", PASSWORD_DEFAULT);
        $stmt_user = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt_user->bind_param("ss", $username, $password);
        $stmt_user->execute();
        $user_id = $stmt_user->insert_id;
    } else {
        $user_check->bind_result($user_id);
        $user_check->fetch();
    }

    // Insert complaint
    $stmt = $conn->prepare("INSERT INTO complaints (user_id, subject, description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $subject, $description);
    if ($stmt->execute()) {
        echo "Complaint submitted successfully! <a href='index.php'>Go back</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>