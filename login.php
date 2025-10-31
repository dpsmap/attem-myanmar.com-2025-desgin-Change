<?php

date_default_timezone_set("Asia/Yangon");
require_once("./config/db.php");
require_once("./config/helper.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // echo "jell";
    $name = $_POST['name'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE name = :name");

    $stmt->bindParam(":name", $name);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($password == $user['password']) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            // echo $_SESSION['id'];
            // exit();
            header("location: ./dashboard.php");
            exit();
            // echo ('hello');
            // exit();
        } else {
            echo "<script>
            alert('wrong credentials, try again!');
            </script>";
        }

        // var_dump($user);
    } else {
        echo "<script>
            alert('wrong credentials, try again!');
            </script>";
    }




    // echo $name . $password;
    // exit();
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        form {
            border: 3px solid #f1f1f1;
        }

        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }

        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
        }

        img.avatar {
            width: 30%;
            /* border-radius: 50%; */
        }

        .container {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- <h2>Attempt Myanmar Login</h2> -->

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="imgcontainer">
            <img src="./images/logo.JPG" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <label for="name"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="name" required>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <button type="submit">Login</button>
            <!-- <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
            </label> -->
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <!-- <input type="reset" class="cancelbtn"></input> -->
            <input type="reset" class="cancelbtn" value="reset">
            <!-- <span class="psw">Forgot <a href="#">password?</a></span> -->
        </div>
    </form>


</body>

</html>