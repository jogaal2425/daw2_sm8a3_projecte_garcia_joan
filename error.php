<?php
session_start();

if (!isset($_SESSION['adm'])) {
    header("Location: index.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="ca">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #dc3545;
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
            color: red;
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

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="message"><?php echo isset($_GET['error']) ? htmlspecialchars($_GET['error']) : "Ha ocurrido un error."; ?></p>
        <a href="menu.php">Tornar al menú</a><br>
        <a href="logout.php">Finalitzar sessió</a>
    </div>
</body>
</html>
