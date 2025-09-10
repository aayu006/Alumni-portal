<?php
session_start();
include("database.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $formType = $_POST['formType'] ?? 'login';
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location='index.html';</script>";
        exit();
    }

    if ($formType === "signup") {
        if (strlen($password) < 6) {
            echo "<script>alert('Password must be at least 6 characters'); window.location='index.html';</script>";
            exit();
        }
        // Check existing
        $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
        mysqli_stmt_bind_param($check, "s", $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);
        if (mysqli_stmt_num_rows($check) > 0) {
            echo "<script>alert('Email already exists'); window.location='index.html';</script>";
            exit();
        }
        mysqli_stmt_close($check);

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($conn, "INSERT INTO users (email, password) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ss", $email, $hash);
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Signup successful! Please login.'); window.location='index.html';</script>";
        } else {
            echo "<script>alert('Signup failed'); window.location='index.html';</script>";
        }
        mysqli_stmt_close($stmt);
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, email, password FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid password'); window.location='index.html';</script>";
            }
        } else {
            echo "<script>alert('Email not registered'); window.location='index.html';</script>";
        }
        mysqli_stmt_close($stmt);
    }
} else {
    header("Location: index.html");
    exit();
}
?>
