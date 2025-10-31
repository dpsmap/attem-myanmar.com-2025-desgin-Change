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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <?php if ($row): ?>
        <?php if (!empty($row['images'])): ?>
            <a href="<?php echo htmlspecialchars($row['images']); ?>" target="_blank" rel="noopener noreferrer"><img style="width:300px;height:200px" src="<?php echo htmlspecialchars($row['images']); ?>" class="post-img img-fluid" alt=""></a>
        <?php else: ?>
            <img src="./images/no-image-available-icon-vector.jpg" style="width:300px;height:200px" class="post-img img-fluid" alt="">
        <?php endif; ?>
        <h1>ID: <?= htmlspecialchars($row['id']) ?></h1>
        <h2>Title: <?= htmlspecialchars($row['name']) ?></h2>
        <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
        <?php
        ?>
    <?php else: ?>
        <p>Post not found.</p>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>