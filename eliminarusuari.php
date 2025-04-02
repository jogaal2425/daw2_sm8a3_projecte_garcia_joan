<?php
require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$mensaje = "";

// Si se envió el formulario, procesamos la eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['uid']) && !empty($_POST['ou'])) {
        $uid = trim($_POST['uid']);
        $unorg = trim($_POST['ou']);
        $dn = "uid=$uid,ou=$unorg,dc=clotfje,dc=net";

        // Configuración de conexión LDAP
        $opcions = [
            'host' => 'zend-jogaal.clotfje.net',
            'username' => 'cn=admin,dc=clotfje,dc=net',
            'password' => 'fjeclot',
            'bindRequiresDn' => true,
            'accountDomainName' => 'clotfje.net',
            'baseDn' => 'dc=clotfje,dc=net',
        ];

        try {
            // Conectar y autenticar en LDAP
            $ldap = new Ldap($opcions);
            $ldap->bind();

            // Verificar si el usuario existe
            if ($ldap->exists($dn)) {
                $ldap->delete($dn);
                $mensaje = "<p class='success'>Usuario '$uid' eliminado correctamente.</p>";
            } else {
                $mensaje = "<p class='error'> El usuario '$uid' no existe en la OU '$unorg'.</p>";
            }
        } catch (Exception $e) {
            $mensaje = "<p class='error'>Error: " . $e->getMessage() . "</p>";
        }
    } else {
        $mensaje = "<p class='error'>Por favor, completa todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Usuario LDAP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            text-align: center;
            padding: 20px;
        }
        
        h2 {
            color: #007bff;
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

        label {
            display: block;
            font-weight: bold;
            margin: 8px 0;
        }

        input[type="text"] {
            padding: 8px;
            margin: 8px 0;
            border: 1px solid #007bff;
            border-radius: 5px;
            width: 100%;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 10px;
            font-weight: bold;
        }

        .success {
            color: green;
        }

        .error {
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
    </style>
</head>
<body>
    <h2>Eliminar Usuario LDAP</h2>
    <div class="container">
        <form method="POST">
            <label for="uid">UID del Usuario:</label>
            <input type="text" id="uid" name="uid" required>

            <label for="ou">Unidad Organizativa (OU):</label>
            <input type="text" id="ou" name="ou" required>

            <input type="submit" value="Eliminar Usuario">
        </form>

        <?php if (!empty($mensaje)) echo "<div class='message'>$mensaje</div>"; ?>

        <a href="menu.php">Tornar al menú</a>
    </div>
</body>
</html>
