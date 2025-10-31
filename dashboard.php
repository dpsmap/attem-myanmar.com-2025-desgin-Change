<?php
require_once('./config/db.php');
require_once('./config/helper.php');

$userId = $_SESSION['id'];
$userName = $_SESSION['name'];
$userRole = $_SESSION['role'];
// $user/ = $_SESSION['role'];

if (empty($userId)) {
    header("location: ./login.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
        }

        ul.topnav {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        ul.topnav li {
            float: left;
        }

        ul.topnav li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        ul.topnav li a:hover:not(.active) {
            background-color: #111;
        }

        ul.topnav li a.active {
            background-color: #04AA6D;
        }

        ul.topnav li.right {
            float: right;
        }

        @media screen and (max-width: 600px) {

            ul.topnav li.right,
            ul.topnav li {
                float: none;
            }
        }
    </style>
</head>

<body>
    <nav>
        <ul class="topnav ">
            <li><a class="active" href="/">Home</a></li>
            <li><a href=""><?php echo $userName; ?></a></li>
            <!-- <li><a href="#contact">Contact</a></li> -->
            <li class="right" style="background-color: red;"><a href="#about">Logout</a></li>
        </ul>
    </nav>
    <form action="./addPostWithImage.php" method="post" enctype="multipart/form-data" class="form-control p-3">
        <br>
        <div class="form-group">
            <label for="exampleInputEmail1">Post Name</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
        </div>
        <br>
        <div class="form-group">
            <label for="w3review">TextArea:</label>

            <textarea id="w3review" name="w3review" rows="4" cols="50" class="form-control">
At w3schools.com you will learn how to make a website. They offer free tutorials in all web development technologies.
</textarea>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleFormControlFile1">Example file input</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
        <input type="reset" class="btn btn-danger" value="Cancel">
        <!-- <input type="reset" class="btn btn-info" value="Reset"> -->


    </form>
    <!-- hello  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>