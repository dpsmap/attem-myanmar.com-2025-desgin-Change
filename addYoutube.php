<?php 
require_once('./config/db.php');
require_once('./config/helper.php');



$userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$userName = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : '';

if (empty($userId)) {
    header("location: ./login.php");
    exit();
}
 if (isset($_POST['form-sub']) && ($_POST['form-sub']) == 1) {
            $utube = isset($_POST['utube']) ? htmlspecialchars($_POST['utube']) : '';
            $uname = isset($_POST['uname']) ? htmlspecialchars($_POST['uname']) : '';
            
            try {
                $stmt = $conn->prepare("INSERT INTO utubes (name,url, created_at) VALUES (:name, :url, NOW())");
                $stmt->bindParam(":name", $uname);
                $stmt->bindParam(":url", $utube);
                $stmt->execute();

    header("location: ./dashboard.php");
                // echo "<p class=\"p-3 text-primary\">Posting Complete</p>";

                exit();
            } catch (PDOException $e) {
                error_log("YouTube link insertion failed: " . $e->getMessage());
                echo "<p class=\"p-3 text-danger\">Failed to insert YouTube link.</p>";
            }

    }
?>