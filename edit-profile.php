<?php
session_start();
include("database.php");
if (!isset($_SESSION['user_id'])) { header("Location: index.html"); exit(); }
$user_id = $_SESSION['user_id'];

// Load current user
$stmt = mysqli_prepare($conn, "SELECT name, batch, skills, linkedin FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name'] ?? '');
    $batch = trim($_POST['batch'] ?? '');
    $skills = trim($_POST['skills'] ?? '');
    $linkedin = trim($_POST['linkedin'] ?? '');

    $stmt = mysqli_prepare($conn, "UPDATE users SET name = ?, batch = ?, skills = ?, linkedin = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $batch, $skills, $linkedin, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Profile Updated Successfully!'); window.location='dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error updating profile');</script>";
    }
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            max-width: 520px; margin: 40px auto; background: white; padding: 20px;
            border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .form-container h2 { color: #0056b3; margin-bottom: 15px; }
        .form-container input, .form-container textarea {
            width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;
        }
        .form-container button {
            background-color: #0056b3; color: white; padding: 10px; border: none; width: 100%;
            border-radius: 5px; cursor: pointer;
        }
        .form-container .back { background-color: #6c757d; margin-top: 10px; display:inline-block; text-align:center; }
        a { text-decoration:none; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Profile</h2>
        <form method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" placeholder="Full Name">
            <input type="text" name="batch" value="<?php echo htmlspecialchars($user['batch'] ?? ''); ?>" placeholder="Batch (e.g., 2020-2024)">
            <textarea name="skills" placeholder="Skills (e.g., Python, Web Dev, AI)"><?php echo htmlspecialchars($user['skills'] ?? ''); ?></textarea>
            <input type="url" name="linkedin" value="<?php echo htmlspecialchars($user['linkedin'] ?? ''); ?>" placeholder="LinkedIn Profile URL">
            <button type="submit">Update Profile</button>
        </form>
        <a href="dashboard.php" class="back"><button class="back">Back to Dashboard</button></a>
    </div>
</body>
</html>
