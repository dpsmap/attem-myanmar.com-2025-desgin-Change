<?php
require_once('./config/db.php');
require_once('./config/helper.php');
session_start();

$userId = $_SESSION['id'] ?? null;
$userName = $_SESSION['name'] ?? '';
$userRole = $_SESSION['role'] ?? '';

if (empty($userId)) {
    header("location: ./login.php");
    exit();
}

$row = null;
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("SELECT id, name, description, images, created_at FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: start;
            justify-content: start;
            padding: 2rem;
        }

        .card {
            max-width: 700px;
            width: 100%;
            border: none;
            /* border-radius: 1rem; */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: #fff;
        }

        .card-body h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #212529;
        }

        .card-body p {
            font-size: 1rem;
            color: #495057;
        }

        .back-btn {
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>

<body>

    <?php if ($row): ?>
        <div class="card">
            <?php if (!empty($row['images'])): ?>
                <img src="<?= htmlspecialchars($row['images']) ?>" style="width: 500px;height:400px" alt="Post image" class="post-img img-fluid">
            <?php else: ?>
                <img src="./images/no-image-available-icon-vector.jpg" alt="No image" style="width: 500px;height:400px" class="post-img img-fluid">
            <?php endif; ?>

            <div class="card-body p-4">
                <h6 class="text-muted mb-2">Post ID: <?= htmlspecialchars($row['id']) ?></h6>
                <h2><?= htmlspecialchars($row['name']) ?></h2>
                <hr>
                <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                <div class="text-muted small">Created: <?= htmlspecialchars($row['created_at']) ?></div>
                <a href="./dashboard.php" class="btn btn-primary back-btn">← Back to Posts</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            Post not found.
        </div>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>