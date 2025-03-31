<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pàgina Inicial - Aplicació LDAP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        h1 {
            color: #333;
        }
        a {
            display: block;
            margin: 10px 0;
            padding: 10px;
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
    <div class="container">
        <h1>Aplicació d'Accés a Bases de Dades LDAP</h1>
        <h2>DAW2 SM8A3</h2>
        <h3>Autor: jogaal2425</h3>
        <h3>Correu: joan2005garcia@gmail.com</h3>
        <h3>Github: <a href="https://github.com/jogaal2425" target="_blank">Repositori GitHub</a></h3>
        
        <a href="login.php">Inicia sessió</a>
        <a href="info.php">Informació sobre l'aplicació</a>
    </div>
</body>
</html>
