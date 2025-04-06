<?php
session_start();

if (!isset($_SESSION['adm'])) {
    header("Location: index.php");
    exit();
}
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #28a745;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            width: 300px;
            margin-top: 20px;
        }

        .message {
            margin-top: 10px;
            font-weight: bold;
            color: green;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Èxit!</h2>
    <div class="container">
        <p class="message"><?php echo $message; ?></p>
        <a href="logout.php">Finalitzar Sessió</a>
        <br>
        <a href="menu.php">Tornar al menú</a>
    </div>
</body>
</html>
