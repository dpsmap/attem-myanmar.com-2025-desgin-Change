<?php
require_once('./config/db.php');
require_once('./config/helper.php');

session_start();

$userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$userName = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';

if (empty($userId)) {
    header("location: ./login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';

    $uploadedImagePath = null;

    if (!empty($_FILES['images']) && is_array($_FILES['images']['name'])) {
        $uploadDir = __DIR__ . '/uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            $tmpName = $_FILES['images']['tmp_name'][$i];
            $origName = basename($_FILES['images']['name'][$i]);
            $error = $_FILES['images']['error'][$i];

            if ($error !== UPLOAD_ERR_OK || empty($tmpName)) {
                continue;
            }

            $imageInfo = @getimagesize($tmpName);
            if ($imageInfo === false) {
                continue;
            }

            $ext = pathinfo($origName, PATHINFO_EXTENSION);
            $safeName = uniqid('img_', true) . ($ext ? '.' . $ext : '');
            $destPath = $uploadDir . '/' . $safeName;

            if (move_uploaded_file($tmpName, $destPath)) {
                $uploadedImagePath = 'uploads/' . $safeName;
                break;
            }
        }
    }

    try {
        $stmt = $conn->prepare("INSERT INTO posts (name, description, images, created_at) VALUES (:name, :description, :image, NOW())");
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":image", $uploadedImagePath);
        $stmt->execute();

        header("Location: " . htmlspecialchars($_SERVER["PHP_SELF"]));
        exit();
    } catch (PDOException $e) {
        error_log("Post creation failed: " . $e->getMessage());
        echo "<p class=\"p-3 text-danger\">Failed to create post.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- //cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
    <style>
        body {
            margin: 0;
            background: #f6f7fb;
            color: #333;
        }

        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .card.post-card {
            border: 0;
            box-shadow: 0 6px 18px rgba(18, 38, 63, 0.06);
        }

        .post-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: .375rem;
            border-bottom-left-radius: .375rem;
        }

        .preview-img {
            height: 120px;
            width: auto;
            object-fit: cover;
            border-radius: 6px;
        }

        @media (max-width: 575.98px) {
            .post-img {
                height: 160px;
                border-radius: .375rem;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="/">Attempt Myanmar DashBoard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item me-3"><span class="nav-link">Welcome <?php echo htmlspecialchars($userName); ?></span></li>
                    <li class="nav-item"><a class="btn btn-outline-danger btn-sm" href="./logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-4">
        <div class="row g-4">
            <div class="col-12 col-lg-5">
                <div class="card p-3">
                    <h5 class="mb-3">Create a Post</h5>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Post Title</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter post title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="4" class="form-control" placeholder="Write a short description..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control" name="images[]" id="images" accept="image/*" multiple onchange="previewImages(event)">
                        </div>
                        <div id="preview" class="d-flex flex-wrap gap-2 mb-3"></div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <input type="reset" class="btn btn-outline-secondary" value="Reset">
                        </div>
                    </form>


                    <hr>
                    <hr>
                    <div style="">
                        <h5 class="mb-3">Post Lists</h5>
                        <table class="table table-hover border table-bordered display" id="example">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM `posts` ORDER BY id DESC";
                                $stmt = $conn->query($sql);

                                if ($stmt && $stmt->rowCount() > 0):
                                    $count = 1;
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                ?>
                                        <tr>
                                            <!-- <th scope="row"><?php echo $count++; ?></th> -->
                                            <th scope="row"><?php echo $row['id'] ?></th>

                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                        </tr>
                                    <?php
                                    endwhile;
                                else:
                                    ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No posts found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="col-12 col-lg-7">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <?php
                    try {
                        $countStmt = $conn->query("SELECT COUNT(*) FROM `posts`");
                        $totalPosts = $countStmt ? (int)$countStmt->fetchColumn() : 0;
                    } catch (PDOException $e) {
                        error_log("Count posts failed: " . $e->getMessage());
                        $totalPosts = 0;
                    }
                    ?>
                    <h5 class="mb-0">Total Posts - <?php echo $totalPosts; ?></h5>
                    <small class="text-muted">Latest first</small>
                </div>
                <?php
                $sql = "SELECT * FROM `posts` ORDER BY id DESC ";
                $stmt = $conn->query($sql);
                if ($stmt):
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                ?>
                        <div class="card post-card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <?php if (!empty($row['images'])): ?>
                                        <a href="<?php echo htmlspecialchars($row['images']); ?>" target="_blank" rel="noopener noreferrer"><img src="<?php echo htmlspecialchars($row['images']); ?>" class="post-img img-fluid" alt=""></a>
                                    <?php else: ?>
                                        <img src="./images/no-image-available-icon-vector.jpg" class="post-img img-fluid" alt="">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">

                                        <p>Post id - <?php echo $row['id'] ?></p>
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                        <p class="card-text text-muted small mb-2"><?php echo isset($row['created_at']) ? htmlspecialchars(date('M j, Y \\a\\t g:ia', strtotime($row['created_at']))) : ''; ?> &middot; by <?php echo htmlspecialchars($userName); ?></p>
                                        <p class="card-text"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                else:
                    echo '<p class="p-3">No posts found.</p>';
                endif;
                ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
    <!-- Buttons extension -->
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script>
        var table = $('#example').DataTable({
            pageLength: 25,
            dom: 'Bfrtip'
        });

        function previewImages(event) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';
            for (let file of event.target.files) {
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.classList.add('preview-img');
                img.onload = () => URL.revokeObjectURL(img.src);
                preview.appendChild(img);
            }
        }
    </script>
</body>


</html>