<?php
    session_start();
    echo "<h5>Sessió iniciada com usuari: ".$_SESSION['adm']."</h5><br><br>"
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PÀGINA WEB DEL MENÚ PRINCIPAL DE L'APLICACIÓ D'ACCÉS A BASES DE DADES LDAP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h2 {
            color: #007bff;
            text-align: center;
            margin-top: 50px;
        }
        h3 {
            color: #dc3545;
            text-align: center;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            width: 200px;
            padding: 10px;
            margin: 10px;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
        .session-info {
            text-align: center;
            margin-top: 20px;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
            session_start();
            echo "<h5 class='session-info'>Sessió iniciada com usuari: " . $_SESSION['adm'] . "</h5><br><br>";
        ?>
        <h2>MENÚ</h2>

        <div>
            <a href="creausuari.php" class="btn-custom">Crear Usuari</a>
            <a href="modificarusuari.php" class="btn-custom">Modificar Usuari</a>
            <a href="mostrar_usuario.php" class="btn-custom">Mostrar Usuari</a>
            <a href="eliminar_usuario.php" class="btn-custom">Eliminar Usuari</a>
        </div>
        <br>
        <div>
            <a href="logout.php" class="btn-danger">Finalitza sessió</a>
        </div>
    </div>
</body>
</html>
