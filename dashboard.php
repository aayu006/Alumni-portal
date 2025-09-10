<?php
session_start();
include("database.php");
if (!isset($_SESSION['user_id'])) { header("Location: index.html"); exit(); }
$user_id = $_SESSION['user_id'];

// Fetch user
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

// Fetch jobs
$jobs = mysqli_query($conn, "SELECT * FROM jobs ORDER BY created_at DESC");
// Fetch alumni
$alumni = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alumni Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .dashboard-container {
            max-width: 1100px; margin: 20px auto; padding: 20px; background: white;
            border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        .btn {
            background-color: #0056b3; color: white; padding: 8px 15px; border: none;
            border-radius: 6px; cursor: pointer; text-decoration: none; font-weight: 700;
        }
        .btn.secondary { background-color: #6c757d; }
        .btn.danger { background-color: #b30000; }
        .top-actions { display:flex; gap:10px; justify-content:flex-end; margin-bottom: 10px; }
        h1 span { color:#ffd700; }
        .section-card { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="top-actions">
            <a class="btn secondary" href="edit-profile.php">Edit Profile</a>
            <a class="btn danger" href="logout.php">Logout</a>
        </div>
        <h1>Welcome, <span><?php echo htmlspecialchars($user['email']); ?></span> 🎓</h1>

        <div class="section-card">
            <h2>Career Updates</h2>
            <table>
                <tr><th>Job Title</th><th>Company</th><th>Location</th><th>Apply</th></tr>
                <?php while ($job = mysqli_fetch_assoc($jobs)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($job['title']); ?></td>
                    <td><?php echo htmlspecialchars($job['company']); ?></td>
                    <td><?php echo htmlspecialchars($job['location']); ?></td>
                    <td><a href="<?php echo htmlspecialchars($job['link']); ?>" target="_blank">Apply</a></td>
                </tr>
                <?php } ?>
            </table>
        </div>

        <div class="section-card">
            <h2>Registered Alumni</h2>
            <table>
                <tr><th>Name</th><th>Email</th><th>Batch</th><th>Skills</th><th>LinkedIn</th></tr>
                <?php while ($row = mysqli_fetch_assoc($alumni)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['batch'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['skills'] ?? '-'); ?></td>
                    <td>
                        <?php if (!empty($row['linkedin'])) { ?>
                            <a href="<?php echo htmlspecialchars($row['linkedin']); ?>" target="_blank">Profile</a>
                        <?php } else { echo "-"; } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
